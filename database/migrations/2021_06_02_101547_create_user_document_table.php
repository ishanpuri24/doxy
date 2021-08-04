<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDocumentTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_document', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger("document_variation_id");
			$table->foreign("document_variation_id")->references("id")->on("document_variation");

			$table->text("filled_data");
			$table->integer("is_complete");

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
		Schema::dropIfExists('user_document');
	}
}
