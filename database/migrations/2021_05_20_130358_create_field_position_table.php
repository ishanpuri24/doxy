<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldPositionTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("field_position", function (Blueprint $table) {
			$table->id();

			$table->unsignedBigInteger("document_field_id");
			$table->foreign("document_field_id")->references("id")->on("document_field");

			$table->integer("page");
			$table->integer("x");
			$table->integer("y");

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
		Schema::dropIfExists("field_position");
	}
}
