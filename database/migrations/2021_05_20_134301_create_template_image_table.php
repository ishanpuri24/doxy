<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplateImageTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('template_image', function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger("document_variation_id");
			$table->foreign("document_variation_id")->references("id")->on("document_variation");

			$table->integer("page");
			$table->string("location");

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
		Schema::dropIfExists('template_image');
	}
}
