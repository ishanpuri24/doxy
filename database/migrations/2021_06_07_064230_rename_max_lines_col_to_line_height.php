<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMaxLinesColToLineHeight extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('document_field', function (Blueprint $table) {
			$table->renameColumn("max_lines", "line_height");
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
			$table->renameColumn("line_height", "max_lines");
		});
	}
}
