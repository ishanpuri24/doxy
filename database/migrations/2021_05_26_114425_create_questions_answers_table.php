<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsAnswersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('question_answer', function (Blueprint $table) {
      $table->id();

      $table->unsignedBigInteger("document_id");
      $table->foreign("document_id")->references("id")->on("document");

      $table->string("question");
      $table->text("answer");

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
    Schema::dropIfExists('question_answer');
  }
}
