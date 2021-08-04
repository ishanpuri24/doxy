<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDocumentTemplateColumnDocumentVariationTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table("document_variation", function (Blueprint $table) {
			$table->dropColumn("document_template");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table("document_variation", function (Blueprint $table) {
			$table->string('document_template');
		});
	}
}
