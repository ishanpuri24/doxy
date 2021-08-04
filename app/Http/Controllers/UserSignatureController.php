<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Models\UserSignature;

class UserSignatureController extends Controller
{
	/**
	 *  get user signatures by user id
	 *  @method: GET
	 */
	public function index(Request $request, string $user_id)
	{
		$signature = UserSignature::where("user_id", (int) $user_id)->first();
		return $signature === null ? [] : $signature;
	}

	/**
	 *  create a new user signature
	 */
	private function store(int $user_id, string $encoding)
	{
		UserSignature::create([
			"user_id"						=> $user_id,
			"signature_image"		=> $encoding,
		]);
	}

	/**
	 *  update an existing signature record
	 */
	private function update(int $user_id, string $encoding)
	{
		UserSignature::where("user_id", $user_id)
			->update(["signature_image" => $encoding]);
	}

	/**
	 *  check if signatures exist in db for a user
	 */
	private function signature_exists(int $user_id): bool
	{
		return UserSignature::where("user_id", $user_id)->exists();
	}

	/**
	 *  if signatures for a user don't exist in table, create new
	 *  otherwise, update existing signatures
	 * 
	 *  @method: POST
	 */
	public function create_or_update_signatures(Request $request)
	{
		$body = \json_decode($request->getContent());

		$user_id = $body->user_id;
		$encoding = $body->signature_image;

		if (!isset($user_id) || !isset($encoding)) {
			return Response::make('', 400);
		}

		$exists = $this->signature_exists($user_id);

		// create new record
		if (!$exists) {
			$this->store($user_id, $encoding);
			return Response::make('', 200);
		}

		// update existing record
		$this->update($user_id, $encoding);
		return Response::make('', 200);
	}
}
