<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentFieldGroupTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('document_field_group', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger('document_variation_id');
			$table->foreign('document_variation_id')->references('id')->on('document_field');

			$table->string('group_name');
			$table->string('group_description');
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
		Schema::dropIfExists('document_field_group');
	}
}
