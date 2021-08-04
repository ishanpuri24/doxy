<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentVariation;
use App\Models\TemplateImage;
use App\Models\User;
use App\Models\UserDocument;

class UserDocumentController extends Controller
{
	/**
	 *  list all user documents
	 * 
	 */
	public function index(Request $request, int $user_id)
	{
		$user_documents = UserDocument::where("user_id", $user_id)
			->with("variation.document")
			->get();

		return $user_documents;
	}


	/**
	 *  return all document categories
	 *  @method: GET
	 */
	public function list_categories()
	{
		$categories = DocumentCategory::with("documents")->get();
		$data = [
			'page_title' => 'Document Categories',
			'document_categories' => $categories,
		];

		return view('documents.types', $data);
	}


	/**
	 *  allow user to select document variation
	 *  @method: GET
	 */
	public function get_variation($document_slug)
	{
		$document = Document::where("slug", $document_slug)
			->with("variations", "question_answer")
			->first();

		return view("start_user_document", [
			"document"				=> $document
		]);
	}

	/**
	 *  start a user document
	 *  @method: POST
	 */
	public function start_user_document(Request $request, string $document_slug)
	{
		$document = Document::where(['slug' => $document_slug])
			->first();

		$variation = DocumentVariation::where("id", $request->variation)
			->with("fieldGroups.fields")
			->first();

		$template_images = TemplateImage::where("document_variation_id", $variation->id)
			->get();

		$data = [
			'document_variation_id'		=> $variation->id,
			'document_name'						=> $document->name,
			'document_field_groups'		=> $variation->fieldGroups,
			'document_slug'						=> $document->slug,
			'template_images'					=> $template_images,
		];

		return view('documents.make', $data);
	}

	/**
	 *  add new user_docment
	 *  @method: POST
	 */
	public function store(Request $request)
	{
		if (
			!isset($request->document_variation_id) ||
			!isset($request->filled_data)
		) {
			return Response::make('', 400);
		}

		$user_document = UserDocument::create([
			"document_variation_id"		=> $request->document_variation_id,
			"filled_data"							=> $request->filled_data,
		]);

		return [
			"user_document_id"	=> $user_document->id
		];
	}


	/**
	 *  update record in user_document table
	 *  @method: PUT
	 */
	public function update(Request $request)
	{
		if (
			!isset($request->user_document_id) ||
			!isset($request->document_variation_id) ||
			!isset($request->filled_data)
		) {
			return Response::make('', 400);
		}

		UserDocument::where("id", $request->user_document_id)
			->update([
				"document_variation_id"		=> $request->document_variation_id,
				"filled_data"							=> $request->filled_data,
			]);
	}

	/**
	 *  delete a user document
	 *  @method: DELETE 
	 */
	public function destroy(Request $request)
	{
		if (!isset($request->id)) {
			return Response::make('', 400);
		}

		$document = UserDocument::where("id", $request->id);
		if (!isset($document)) {
			return Response::json([
				"message"		=>	"Failed to find user document with id {$request->id}"
			], 400);
		}

		$document->delete();
	}

	/**
	 *  get a list of documents shared with a user
	 *  @method: GET
	 */
	public function get_documents_shared_with_user(Request $request, string $user_id)
	{
		$all_user_documents = UserDocument::with("variation.document")->get();
		$results = [];

		foreach ($all_user_documents as &$document) {
			if (in_array($user_id, $document->shared_with)) {
				array_push($results, $document);
			}
		}

		return $results;
	}

	/**
	 *  get a list of documents shared by user with other users
	 *  @method: GET
	 */
	public function get_documents_shared_by_user(Request $request, string $user_id)
	{
		$user_documents = UserDocument::where("user_id", $user_id)
			->with("variation.document")
			->get()
			->toArray();

		return array_filter($user_documents, function ($document) {
			return count($document["shared_with"]) > 0;
		});
	}

	/**
	 *  share a user document with a contact
	 *  @method: POST
	*/
	public function share_user_document_with_contacts(Request $request)
	{
		if (!isset($request->user_document_id) || !isset($request->shared_with)) {
			return Response::make('', 400);
		}

		UserDocument::where("id", $request->user_document_id)
			->update([ "shared_with" => \json_encode($request->shared_with) ]);
	}
}