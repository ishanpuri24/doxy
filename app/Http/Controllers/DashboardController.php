<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
	/**
	 *  return dashboard main view
	 *  @method: GET
	 */
	public function index()
	{
		$user = Auth::user();
		
		return view("dashboard", [
			"auth_user" => $user,
		]);
	}

	/**
	 *  start document template creation process
	 *  @method: GET
	 */
	public function create_document_template()
	{
		$all_documents = Document::all();

		return view("create_document_template", [
			"documents"	=> $all_documents,
		]);
	}
}
