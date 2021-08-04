<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
	/**
	 *  return complete list of documents
	 *  @method: GET
	 */
	public function index()
	{
		$all = Document::where("author_role", "admin")->get();
		return $all;
	}

	/**
	 *  create new document
	 *  @method: POST
	 */
	public function store(Request $request)
	{
		if (
			!isset($request->name) ||
			!isset($request->document_category_id)
		) {
			return Response::make("", 400);
		}

		$slug = Str::slug($request->name);

		try {
			$document = Document::create([
				"name"									=> $request->name,
				"document_category_id"	=> $request->document_category_id,
				"slug"									=> $slug,
			]);
		} catch (\Exception $_) {
			return Response::json([
				"message"	=> "Failed to add Document. Please make sure the Document Name is unique.",
			], 400);
		}

		return [
			"document_id"	=> $document->id,
		];
	}

	/**
	 *  edit existing document
	 *  @method: PUT
	 */
	public function edit(Request $request)
	{
		if (
			!isset($request->id) ||
			!isset($request->name) ||
			!isset($request->document_category_id)
		) {
			return Response::make("", 400);
		}

		Document::where("id", $request->id)
			->update([
				"name"									=> $request->name,
				"document_category_id"	=> $request->document_category_id,
				"slug"									=> Str::slug($request->name),
			]);
	}

	/**
	 *  delete a document
	 *  @method: DELETE
	*/
	public function destroy(Request $request)
	{
		if (!isset($request->id)) {
			return Response::make("", 400);
		}

		$document = Document::find($request->id);
		if (!isset($document)) {
			return Response::json([
				"message"	=> "Document with the provided ID was not found",
			], 404);
		}

		$document->delete();
	}


	/**
	 *  view containing the document will all fields filled out
	 *  @method: POST
	 */
	// public function preview_document(Request $request, $document_slug = null)
	// {
	// 	if (!isset($document_slug)) {
	// 		return redirect()->route('home');
	// 	}

	// 	$request_body = $request->all();
	// 	dd($request_body);

	// 	$pdf = Facade::setOptions(['isRemoteEnabled' => true])
	// 		->loadView("documents.document-templates.{$document_slug}", $request_body);

	// 	// return view("documents.document-templates.{$document_slug}", $request_body);	
	// 	return $pdf->stream('document.pdf');
	// }


	// --------------------------------------------------------------
	// 
	//  this is previous developer's code. here be demons
	// 
	// --------------------------------------------------------------
	public function list()
	{
		$data = [
			'pageTitle' => 'My Documents',
			'documents' => \App\Models\UserDocument::UserDocuments(['user_id' => Auth::user()->id])
		];

		return view('user.documents.list', $data);
	}

	public function sign($id = null)
	{
		$data = ['pageTitle' => 'Sign Documents'];

		return view('user.documents.sign.sign', $data);
	}
}
