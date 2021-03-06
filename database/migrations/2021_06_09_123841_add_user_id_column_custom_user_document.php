<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdColumnCustomUserDocument extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("custom_user_document", function (Blueprint $table) {
			$table->unsignedBigInteger("user_id")->default(1);
			$table->foreign("user_id")->references("id")->on("users");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("custom_user_document", function (Blueprint $table) {
			$table->dropColumn("user_id");
		});
	}
}
