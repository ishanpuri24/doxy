<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CloneDataTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// DocumentTypes table has been removed since this migration
		$all_types = App\Models\DocumentType::all();
		// dd($all_types[0]->document_name);

		foreach ($all_types as &$type) {
			\App\Models\Document::create([
				'name'                  => $type->document_name,
				'document_category_id'  => 1    // Misc. 
			]);
		}
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
