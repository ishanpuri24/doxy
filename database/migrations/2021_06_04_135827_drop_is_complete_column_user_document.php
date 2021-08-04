<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIsCompleteColumnUserDocument extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("user_document", function (Blueprint $table) {
			$table->dropColumn("is_complete");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("user_document", function (Blueprint $table) {
			$table->integer("is_complete");
		});
	}
}
