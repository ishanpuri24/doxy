<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneratedDocumentTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('generated_document', function (Blueprint $table) {
			$table->softDeletes();
			$table->id();

			$table->unsignedBigInteger('document_id');
			$table->foreign('document_id')->references('id')->on('document');

			$table->unsignedBigInteger('document_variation_id');
			$table->foreign('document_variation_id')->references('id')->on('document_variation');

			$table->longText('document_fields_data');       // store fields data in form of json
			$table->integer('publish_status')->default(0);  // publish document on completion

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
		Schema::dropIfExists('generated_document');
	}
}
