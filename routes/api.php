<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 *  Dashboard Endpoints
 * 
 */

// Document
Route::get('/document', [\App\Http\Controllers\DocumentController::class, 'index'])->name('list_documents');
Route::post('/document', [\App\Http\Controllers\DocumentController::class, 'store'])->name('create_document');
Route::put('/document', [\App\Http\Controllers\DocumentController::class, 'edit'])->name('edit_document');
Route::delete('/document', [\App\Http\Controllers\DocumentController::class, 'destroy'])->name('delete_document');


// Document Categories
Route::get('/document/category', [\App\Http\Controllers\DocumentCategoryController::class, 'index'])->name('list_document_categories');
Route::post('/document/category', [\App\Http\Controllers\DocumentCategoryController::class, 'store'])->name('create_document_categories');
Route::put('/document/category', [\App\Http\Controllers\DocumentCategoryController::class, 'edit'])->name('edit_document_categories');
Route::delete('/document/category', [\App\Http\Controllers\DocumentCategoryController::class, 'destroy'])->name('delete_document_categories');


// Document Variations
Route::get('/document/variations', [\App\Http\Controllers\DocumentVariationsController::class, 'index'])->name('list_variations');
Route::post('/document/variations', [\App\Http\Controllers\DocumentVariationsController::class, 'store'])->name('create_variation');
Route::put('/document/variations', [\App\Http\Controllers\DocumentVariationsController::class, 'edit'])->name('edit_variation');
Route::delete('/document/variations', [\App\Http\Controllers\DocumentVariationsController::class, 'destroy'])->name('delete_variation');


// Document questions and answers
Route::get('/document/qa', [\App\Http\Controllers\QuestionAnswerController::class, 'index']);
Route::post('/document/qa', [\App\Http\Controllers\QuestionAnswerController::class, 'store']);
Route::put('/document/qa', [\App\Http\Controllers\QuestionAnswerController::class, 'edit']);
Route::delete('/document/qa', [\App\Http\Controllers\QuestionAnswerController::class, 'destroy']);


/**
 *  Public Facing Site Endpoints
 * 
 */

// User Documents
Route::get('/user-document/{user_id}', [\App\Http\Controllers\UserDocumentController::class, 'index']);
Route::delete('/user-document', [\App\Http\Controllers\UserDocumentController::class, 'destroy']);

Route::post('/user-document/preview', [\App\Http\Controllers\PDFController::class, 'generate_preview']);
Route::post('/user-document/pdf', [\App\Http\Controllers\PDFController::class, 'generate_pdf']);
Route::post('/user-document/save', [\App\Http\Controllers\UserDocumentController::class, 'store']);
Route::put('/user-document/save', [\App\Http\Controllers\UserDocumentController::class, 'update']);


// Custom User Documents
Route::get('/custom-user-documents/{user_id}', [\App\Http\Controllers\CustomUserDocumentController::class, "index"]);
Route::post('/custom-user-documents', [\App\Http\Controllers\CustomUserDocumentController::class, 'store']);


// User Signatures
Route::get('/user-signatures/{user_id}', [\App\Http\Controllers\UserSignatureController::class, 'index']);
Route::post('/user-signatures', [\App\Http\Controllers\UserSignatureController::class, 'create_or_update_signatures']);


// Shared documents
Route::get('/shared-documents/{user_id}', [\App\Http\Controllers\UserDocumentController::class, 'get_documents_shared_with_user']);
Route::get('/shared-documents/user/{user_id}', [\App\Http\Controllers\UserDocumentController::class, 'get_documents_shared_by_user']);
Route::post('/shared-documents/user/', [\App\Http\Controllers\UserDocumentController::class, 'share_user_document_with_contacts']);


// User Contacts
Route::get('/user-contacts/{user_id}', [\App\Http\Controllers\UserContactController::class, 'index']);


// Signature Requests
Route::get('/signature-request/{user_id}', [\App\Http\Controllers\SignatureRequestController::class, 'index']);
Route::post('/signature-request/', [\App\Http\Controllers\SignatureRequestController::class, 'store']);


// Requested Signatures
Route::get('/signature-request/user/{user_id}', [\App\Http\Controllers\SignatureRequestController::class, 'index_requested_signatures']);
Route::post('/signature-request/user/', [\App\Http\Controllers\SignatureRequestController::class, 'mark_request_signed']);