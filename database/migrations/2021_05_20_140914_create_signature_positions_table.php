<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignaturePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("signature_position", function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("signatory_id");
			$table->foreign("signatory_id")->references("id")->on("signatory");

			$table->unsignedBigInteger("template_image_id");
			$table->foreign("template_image_id")->references("id")->on("template_image");

            $table->integer("x");
            $table->integer("y");

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
        Schema::dropIfExists("signature_position");
    }
}
