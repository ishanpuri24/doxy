<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignatureRequestTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('signature_request', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger("user_id");
			$table->foreign("user_id")->references("id")->on("users");			

			$table->unsignedBigInteger("user_document_id");
			$table->foreign("user_document_id")->references("id")->on("user_document");			

			$table->unsignedBigInteger("user_contacts_id");
			$table->foreign("user_contacts_id")->references("id")->on("user_contacts");			

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('signature_request');
	}
}
