<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropUserMigrationsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('user_documents');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::create('user_documents', function (Blueprint $table) {
			$table->id();
			$table->integer('user_id');
			$table->integer('document_id');
			$table->longText('document_data');
			$table->integer('status')->default(1);
			$table->softDeletes();
			$table->timestamps();
		});
	}
}
