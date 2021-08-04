<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateForeignRelationDocumentFieldGroup extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('document_field_group', function (Blueprint $table) {
			$table->dropForeign(['document_variation_id']);
			// $table->foreign('document_variation_id')
			// 	->references('id')
			// 	->on('document_variation');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}
