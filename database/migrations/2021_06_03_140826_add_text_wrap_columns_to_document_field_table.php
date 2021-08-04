<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextWrapColumnsToDocumentFieldTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('document_field', function (Blueprint $table) {
			$table->integer("wrap_text")->default(0);
			$table->integer("line_length")->nullable();
			$table->integer("max_lines")->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('document_field', function (Blueprint $table) {
			$table->dropColumn("wrap_text");
			$table->dropColumn("line_length");
			$table->dropColumn("max_lines");
		});
	}
}
