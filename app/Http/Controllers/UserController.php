<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Session;
// use Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

use App\Models\UserContact;
use App\Models\User;

class UserController extends Controller
{
	public function index(Request $request)
	{
		if ($request->method() == 'GET')
		{
			$data = ['pageTitle' => 'My Profile'];

			return view('user.profile', $data);
		}
		else if ($request->method() == 'POST')
		{
			$request->validate([
				'name' => 'required|max:191',
				'mobile_number' => 'max:15'
			]);

			$params = $request->post();
			$update = \App\Models\User::updateUser([
				'id' => Auth::user()->id,
				'name' => $params['name'],
				'mobile_number' => $params['mobile_number']
			]);

			Session::flash('alert-class', 'danger');
			Session::flash('message', 'Unable to update your profile. Please try again.');
			if ($update)
			{
				Session::flash('alert-class', 'success');
				Session::flash('message', 'Your profile is updated successfully.');
			}

			return redirect()->route('user.profile');
		}
	}

	public function contacts()
	{
		$all_user_contacts = UserContact::userContacts(['user_id' => Auth::user()->id], [
			'sort_by' => 'created_at',
			'sort_order' => 'desc'
		]);

		foreach ($all_user_contacts as &$contact) {
			$co_document_count = $this->count_co_documents(Auth::user(), $contact->contact_email);
			$contact->doc_count = $co_document_count;
		}

		$data = [
			'pageTitle' => 'My Contacts',
			'contacts' => $all_user_contacts,
		];


		return view('user.contacts.list', $data);
	}

	private function count_co_documents($current_user, $another_user_email)
	{
		$current_user_documents = $current_user->documents()->get()->toArray();
		$another_user = User::where("email", $another_user_email)->first();

		$count = 0;
		if (!isset($another_user)) return $count;

		foreach ($current_user_documents as &$document) {
			if (isset($document["shared_with"]))
				if (in_array($another_user->id, $document["shared_with"])) {
				$count++;
			}
		}

		return $count;
	}

	public function contact(Request $request, $id=null)
	{
		if ($id)
		{
			$contact = UserContact::find($id);
			if ($contact && $contact->user_id != Auth::user()->id)
			{
				abort(404);
			}
		}

		if ($request->method() == 'GET')
		{
			if ($id)
			{
				if ($contact)
				{
					$data = [
						'pageTitle' => 'Update Contact',
						'contact' => $contact
					];

					return view('user.contacts.edit', $data);
				}

				abort(404);
			}

			$data = ['pageTitle' => '	'];
			
			return view('user.contacts.edit', $data);
		}
		elseif ($request->method() == 'POST')
		{
			$params = Validator::validate($request->all(), [
				'contact_address' => 'max:512',
				'contact_name' => 'required|max:255',
				'contact_email' => 'required|max:255',
				'contact_mobile_number' => 'required|max:15',
				'description' => 'required',
			]);

			$userContact = \App\Models\UserContact::updateUserContact([
				'id' => $id,
				'user_id' => Auth::user()->id,
				'contact_name' => $params['contact_name'],
				'contact_email' => $params['contact_email'],
				'contact_address' => $params['contact_address'],
				'contact_mobile_number' => $params['contact_mobile_number'],
				'description'						=> $params['description']
			]);

			if ($userContact)
			{
				Session::flash('alert-class', 'success');
				Session::flash('message', 'Your contact is saved successfully.');
				
				return redirect()->route('user.contacts', $userContact->id);
			}

			Session::flash('alert-class', 'danger');
			Session::flash('message', 'Unable to save your contact. Please try again.');

			return redirect()->back();
		}
	}

	public function deleteContact(Request $request, $id)
	{
		$contact = UserContact::find($id);
		if ($contact)
		{
			if ($contact->user_id != Auth::user()->id)
			{
				abort(404);
			}
		}
		else
		{
			abort(404);
		}

		$deleteContact = UserContact::deleteContact($id);
		if ($deleteContact)
		{
			Session::flash('alert-class', 'success');
			Session::flash('message', 'Your contact is deleted successfully.');
			
			return redirect()->route('user.contacts');
		}

		Session::flash('alert-class', 'danger');
		Session::flash('message', 'Unable to delete your contact. Please try again.');

		return redirect()->back();
	}



	public function individual_contact($contact_id) 
	{
		$user_contact = UserContact::find($contact_id);
		if (!isset($user_contact)) {
			abort(404);
		}

		return view("user.contacts.individual", [
			"pageTitle"	=> "Contact",
			"contact"		=> $user_contact,
		]);
	}
}
