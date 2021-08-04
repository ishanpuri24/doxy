<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_field', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('document_variation_id');
            $table->foreign('document_variation_id')->references('id')->on('document_variation');

            $table->string('field_name');   // should not be unique with the table

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_field');
    }
}
