<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'App\Http\Controllers\IndexController@index')->name('home');


/**
 *  list all or make new document
*/ 
Route::get('make-documents/', 'App\Http\Controllers\UserDocumentController@list_categories')->name('documents.make');
Route::get('make-documents/{document_slug}', 'App\Http\Controllers\UserDocumentController@get_variation')->name("document.get_variation");
Route::post('make-documents/{document_slug}', 'App\Http\Controllers\UserDocumentController@start_user_document');

/**
 *  route protected behind authentication
 * 
*/
Route::middleware('auth')->group(function() {
	Route::any('my-profile', 'App\Http\Controllers\UserController@index')->name('user.profile');
	
	// DASHBOARD
	Route::get('dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');	
	Route::get('create-document-template', 'App\Http\Controllers\DashboardController@create_document_template')->name('create__document_template');	

	// DOCUMENTS
	Route::any('my-documents/{id?}', 'App\Http\Controllers\DocumentController@list')->name('user.documents');			// useless but leave in for now
	Route::any('sign-documents/{id?}', 'App\Http\Controllers\DocumentController@sign')->name('user.documents.sign');
	Route::get('custom-user-document/', 'App\Http\Controllers\CustomUserDocumentController@start_document');	

	// CONTACTS
	Route::any('my-contacts', 'App\Http\Controllers\UserController@contacts')->name('user.contacts');
	Route::any('my-contact/{id?}', 'App\Http\Controllers\UserController@contact')->name('user.contact');
	Route::any('my-contact/delete/{id}', 'App\Http\Controllers\UserController@deleteContact')->name('user.contact.delete');
	Route::any('my-contact/contact/{contact_id}', 'App\Http\Controllers\UserController@individual_contact')->name('user.contact.individual');

	// CUSTOM DOCUMENTS
	Route::get('custom-document/{variation_id}', [App\Http\Controllers\CustomUserDocumentController::class, 'start_custom_document']);
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');