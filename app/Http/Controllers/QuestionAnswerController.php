<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Models\QuestionAnswer;

class QuestionAnswerController extends Controller
{
	/**
	 *  get all questions and answers
	 *  @method: GET
	 */
	public function index()
	{
		$all_questions = QuestionAnswer::all();
		return $all_questions;
	}

	/**
	 *  create an entry: questions and answers
	 *  @method: POST
	 */
	public function store(Request $request)
	{
		if (
			!isset($request->document_id) ||
			!isset($request->question) ||
			!isset($request->answer)
		) {
			return Response::make("", 400);
		}

		try {
			$qa = QuestionAnswer::create([
				"document_id"			=> $request->document_id,
				"question"				=> $request->question,
				"answer"					=> $request->answer,
			]);
		} catch (\Exception $_) {
			return Response::json([
				"message"	=> "Failed to add entry to questions and answers"
			], 400);
		}

		return [
			"question_answer_id"	=> $qa->id
		];
	}

	/**
	 *  edit an entry: questions and answers
	 *  @method: PUT
	 */
	public function edit(Request $request)
	{
		if (
			!isset($request->id) ||
			!isset($request->document_id) ||
			!isset($request->question) ||
			!isset($request->answer)
		) {
			return Response::make("", 400);
		}

		QuestionAnswer::where("id", $request->id)
			->update([
				"document_id"		=> $request->document_id,
				"question"			=> $request->question,
				"answer"				=> $request->answer,
			]);
	}

	/**
	 *  delete a record: question and answer
	 *  @method: DELETE
	 */
	public function destroy(Request $request)
	{
		if (!isset($request->id)) {
			return Response::make('', 400);
		}

		$qa = QuestionAnswer::find($request->id);
		$qa->delete();
	}
}
