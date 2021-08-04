<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentSlugs extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('document', function (Blueprint $table) {
			$table->string('slug');
		});

		$all_documents = App\Models\Document::all();

		foreach ($all_documents as &$document) {
			$document->slug = Illuminate\Support\Str::slug($document->name, '-');
			$document->save();
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('document', function (Blueprint $table) {
			$table->dropColumn('slug');
		});
	}
}
