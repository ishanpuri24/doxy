<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatorIdToDocumentVariationTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('document_variation', function (Blueprint $table) {
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
		Schema::table('document_variation', function (Blueprint $table) {
			$table->dropColumn("user_id");
		});
	}
}
