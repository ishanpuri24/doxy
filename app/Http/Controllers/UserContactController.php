<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserContact;

class UserContactController extends Controller
{
	/**
	 *  list all user contacts
	 *  @method: GET
	*/
	public function index(Request $request, string $user_id)
	{
		$all_contacts = UserContact::where("user_id", $user_id)->get();		
		return $all_contacts;
	}
}
