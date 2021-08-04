<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\CustomUserDocument;
use App\Models\DocumentVariation;
use App\Models\DocumentFieldGroup;
use App\Models\DocumentField;
use App\Models\FieldPosition;

use App\Models\TemplateImage;

use App\Models\Signatory;
use App\Models\SignaturePosition;

class CustomUserDocumentController extends Controller
{
	/**
	 *  send a list all custom documents created by the user
	 *  @method: GET 
	 */
	public function index(Request $request, int $user_id)
	{
		$custom_documents = DocumentVariation::whereNull('state')
			->where("user_id", $user_id)
			->get();

		if (!isset($custom_documents)) {
			abort(404);
		}

		return $custom_documents;
	}

	/**
	 *  start creating a custom document
	 *  @method: GET
	 */
	public function start_document()
	{
		$user = Auth::user();
		return view("custom-documents.start_document", [
			"user"	=> $user,
		]);
	}

	/**
	 *  store data for custom user document
	 *  @method: POST
	 */
	public function store(Request $request)
	{
		$is_valid = $this->verify_store_request($request);
		if (!$is_valid) {
			return Response::make('', 400);
		}

		DB::transaction(function () use ($request) {

			/**
			 *  create top-level document variation 
			 * 
			 */
			$variation = DocumentVariation::create([
				"document_id"					=> 19,		// all custom user documents have a fixed parent document
				"user_id"							=> $request->user_id,
				"document_name"				=> $request->document_name,
			]);

			/**
			 *  with nested field hierarchy 
			 *  and field positions
			 */
			foreach ($request->field_hierarchy as $group) {

				$field_group = DocumentFieldGroup::create([
					"document_variation_id"	=> $variation->id,
					"group_name"						=> $group["group_name"],
					"group_description"			=> $group["group_description"],
				]);

				foreach ($group["fields"] as $field) {
					$random_str = Str::random(10);
					$slug = Str::slug($field["field_name"], '_') . '_' . $random_str;

					$document_field = DocumentField::create([
						"document_variation_id"			=> $variation->id,
						"document_field_group_id"		=> $field_group->id,
						"field_name"								=> $field["field_name"],
						"field_slug"								=> $slug,
						"html_input_type"						=> $field["input_type"],
						"wrap_text"									=> $field["wrap_text"],
						"line_length"								=> $field["line_length"],
						"line_height"								=> $field["line_height"],
					]);

					foreach ($field["positions"] as $position) {
						$field_position = FieldPosition::create([
							"document_field_id"		=> $document_field->id,
							"page"								=> $position["page"],
							"x"										=> $position["pixel"]["x"],
							"y"										=> $position["pixel"]["y"],
						]);
					}
				}
			}

			/**
			 *  save pdf page images
			 * 
			 */
			$saved_images = [];

			foreach ($request->document_template["image_encodings"] as $encoding) {
				$location = $this->save_image($encoding["image_encoding"], $variation->id);

				$image = TemplateImage::create([
					"document_variation_id"			=> $variation->id,
					"page"											=> $encoding["page_num"],
					"location"									=> $location,
				]);

				array_push($saved_images, [
					"image_id"	=> $image->id,
					"page"			=> $encoding["page_num"],
				]);
			}

			/**
			 *  create document signatories and signature positions
			 * 
			 */
			foreach ($request->signatories as $signatory) {
				$document_signatory = Signatory::create([
					"document_variation_id"			=> $variation->id,
					"name"											=> $signatory["name"],
				]);

				foreach ($signatory["positions"] as $position) {
					$image_id = array_filter($saved_images, function ($item) use ($position) {
						return $item["page"] === $position["page"];
					});

					$signature_position = [
						"signatory_id"						=> $document_signatory->id,
						"template_image_id"				=> $image_id[0]["image_id"],
						"x"												=> $position["pixel"]["x"],
						"y"												=> $position["pixel"]["y"],
					];

					SignaturePosition::create($signature_position);
				}
			}
		});
	}

	private function save_image(string $data, int $variation_id)
	{
		if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
			$data = substr($data, strpos($data, ',') + 1);
			$type = strtolower($type[1]); // jpg, png, gif

			if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
				throw new \Exception('invalid image type');
			}

			$data = str_replace(' ', '+', $data);
			$data = base64_decode($data);

			if ($data === false) throw new \Exception('base64_decode failed');
		} else {
			throw new \Exception('did not match data URI with image data');
		}

		$random_str = Str::random(40);
		$full_name = "{$variation_id}_{$random_str}.{$type}";

		Storage::disk('public')->put($full_name, $data);

		return $full_name;
	}

	/**
	 *  verify whether the incoming store request is valid for storing 
	 *  in the DB
	 * 
	 */
	private function verify_store_request(Request $request): bool
	{
		if (
			isset($request->user_id) &&
			isset($request->document_name) &&

			isset($request->field_hierarchy) &&
			count($request->field_hierarchy) > 0 &&

			isset($request->document_template) &&
			isset($request->signatories)
		) {
			return true;
		}

		return false;
	}

	/**
	 *  fill out custom user document
	 *  @method: POST
	 */
	public function start_custom_document(Request $request, int $variation_id)
	{
		$variation = DocumentVariation::where("id", $variation_id)
			->with("fieldGroups.fields")
			->with("document")
			->first();

		$template_images = TemplateImage::where("document_variation_id", $variation_id)
			->get();

		$data = [
			'document_variation_id'		=> $variation_id,
			'document_name'						=> $variation->document_name,
			'document_field_groups'		=> $variation->fieldGroups,
			'document_slug'						=> $variation->document->slug,
			'template_images'					=> $template_images,
		];

		return view('documents.make', $data);
	}
}
