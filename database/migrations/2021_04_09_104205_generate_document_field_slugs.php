<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

use App\Models\DocumentField;

class GenerateDocumentFieldSlugs extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('document_field', function (Blueprint $table) {
			$table->string('field_slug');
		});

		$all_fields = DocumentField::all();

		foreach ($all_fields as &$field) {
			$field->field_slug = Str::slug($field->field_name, '-');
			$field->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('document_field', function (Blueprint $table) {
			$table->dropColumn('field_slug');
		});
	}
}
