<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\DocumentVariation;
use App\Models\DocumentFieldGroup;
use App\Models\DocumentField;
use App\Models\FieldPosition;

use App\Models\TemplateImage;

use App\Models\Signatory;
use App\Models\SignaturePosition;

class DocumentVariationsController extends Controller
{
	/**
	 *  return a list of all document variations
	 *  @method: GET
	 */
	public function index()
	{
		// in custom-user-documents, state is null
		$all_variations = DocumentVariation::whereNotNull('state')->with('document')
			->get();

		return $all_variations;
	}

	/**
	 *  create new document variation
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
				"document_id"					=> $request->document_id,
				"state"								=> $request->state,
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
					$image_id = [];

					foreach ($saved_images as &$item) {
						if ($item["page"] === $position["page"]) {
							$image_id = $item;
						}
					}

					$signature_position = [
						"signatory_id"						=> $document_signatory->id,
						"template_image_id"				=> $image_id["image_id"],
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
			isset($request->document_id) &&
			isset($request->state) &&

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
	 *  edit document variation
	 *  @method: PUT
	 */
	public function edit(Request $request)
	{
		if (
			!isset($request->variation_id) ||
			!isset($request->document_id) ||
			!isset($request->document_template) ||
			!isset($request->state)
		) {
			return Response::make("", 400);
		}

		DocumentVariation::where("id", $request->variation_id)
			->update([
				"document_id"					=> $request->document_id,
				"document_template"		=> $request->document_template,
				"state"								=> $request->state,
			]);
	}

	/**
	 *  delete all traces of a document variation
	 *  @method: DELETE
	 */
	public function destroy(Request $request)
	{
		if (!isset($request->document_variation_id)) {
			return Response::make('', 400);
		}

		$variation = DocumentVariation::find($request->document_variation_id);
		if (!isset($variation)) {
			return Response::json([
				"message"	=> "Document variation with the provided ID not found",
			], 404);
		}

		DB::transaction(function () use ($variation) {
			$fields = DocumentField::where("document_variation_id", $variation->id)->get();

			/**
			 *  delete fields and their positions
			 */
			foreach ($fields as $field) {
				FieldPosition::where("document_field_id", $field->id)->delete();
				$field->delete();
			}

			/**
			 * delete document field groups
			 */
			DocumentFieldGroup::where("document_variation_id", $variation->id)->delete();

			/**
			 *  signatories
			 */
			$document_signatories = Signatory::where("document_variation_id", $variation->id)->get();
			foreach ($document_signatories as $signatory) {
				SignaturePosition::where("signatory_id", $signatory->id)->delete();
				$signatory->delete();
			}

			/**
			 *  template images
			 */
			$template_images = TemplateImage::where("document_variation_id", $variation->id)->get();
			foreach ($template_images as $image) {
				Storage::delete($image->location);
				$image->delete();
			}

			$variation->delete();
		});
	}
}
