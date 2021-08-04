<?php

namespace App\Http\Controllers;

use App\Models\Signatory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

use App\Models\SignatureRequest;
use App\Models\User;
use App\Models\UserContact;

class SignatureRequestController extends Controller
{

	/**
	 *  list all signature requests by a user
	 *  @method: GET
	 */
	public function index(Request $request, string $user_id)
	{
		$signature_requests = SignatureRequest::where("user_id", $user_id)->get();
		return $signature_requests;
	}

	/**
	 *  create a new signature request
	 *  @method: POST
	 */
	public function store(Request $request)
	{
		$body = \json_decode($request->getContent(), true);

		if (
			!isset($body['user_id']) ||
			!isset($body['user_document_id']) ||
			!isset($body['user_contacts_id'])
		) {
			return Response::make('', 400);
		}

		$signature_request = SignatureRequest::create([
			"user_id"							=> $body['user_id'],
			"user_document_id"		=> $body['user_document_id'],
			"user_contacts_id"		=> $body['user_contacts_id'],
		]);

		return $signature_request->id;
	}

	/**
	 *  list all signature requests recieved by a user
	 *  @method: GET
	*/
	public function index_requested_signatures(Request $request, string $user_id)
	{
		$user = User::where('id', $user_id)->first();		
		$results = [];

		$all_signature_requests = SignatureRequest::with("user_contact")
			->with("user_document.variation.document")
			->with("requested_by")
			->get();

		foreach ($all_signature_requests as &$signature_request) {
			$contact_id = $signature_request->user_contacts_id;
			$contact = UserContact::where("id", $contact_id)->first();

			if ($contact->contact_email === $user->email) {
				array_push($results, $signature_request);
			}
		}

		return $results;
	}

	/**
	 *  mark a signature request as signed
	 *  @method: POST
	*/
	public function mark_request_signed(Request $request)
	{
		if (!isset($request->signature_request_id)) {
			return Response::make('', 400);
		}

		SignatureRequest::where("id", $request->signature_request_id)
			->update(["is_signed" => true]);
	}
}
