<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentVariationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_variation', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('document_id');
            $table->foreign('document_id')->references('id')->on('document');
          
            $table->string('document_template');    // create file using admin input
            $table->string('state')->nullable();    // null means same document for all states
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
        Schema::dropIfExists('document_variation');
    }
}
