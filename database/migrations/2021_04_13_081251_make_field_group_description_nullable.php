<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFieldGroupDescriptionNullable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('document_field_group', function (Blueprint $table) {
			$table->string('group_description')->nullable(true)->change();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('document_field_group', function (Blueprint $table) {
			$table->string('group_description')->nullable(false)->change();
		});
	}
}
