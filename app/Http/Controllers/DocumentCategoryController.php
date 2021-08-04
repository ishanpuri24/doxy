<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\DocumentCategory;

class DocumentCategoryController extends Controller
{
	/**
	 *  list all document categories
	 *  @method: GET
	 */
	public function index()
	{
		$categories = DocumentCategory::all();
		return $categories;
	}

	/**
	 *  create a new document category
	 *  @method: POST
	 */
	public function store(Request $request)
	{
		if (
			!isset($request->name) ||
			!isset($request->parent_category_id)
		) {
			return Response::make("", 400);
		}

		$category = DocumentCategory::create([
			"name"								=> $request->name,
			"parent_category_id"	=> $request->parent_category_id,
		]);

		return [
			"category_id" => $category->id,
		];
	}

	/**
	 *  edit an existing document category
	 *  @method: PUT
	 */
	public function edit(Request $request)
	{
		if (
			!isset($request->document_category_id) ||
			!isset($request->name) ||
			!isset($request->parent_category_id)
		) {
			return Response::make("", 400);
		}

		DocumentCategory::where("id", $request->document_category_id)
			->update([
				"name"								=>	$request->name,
				"parent_category_id"	=> $request->parent_category_id,
			]);
	}

	/**
	 *  delete a document category
	 *  @method: DELETE
	*/
	public function destroy(Request $request)
	{
		if (!isset($request->document_category_id)) {
			return Response::make('', 400);
		}

		$category = DocumentCategory::find($request->document_category_id);
		if (!isset($category)) {
			return Response::json([
				"message"	=> "Document Category with the provided id not found",
			], 404);
		}
		$category->delete();
	}
}
