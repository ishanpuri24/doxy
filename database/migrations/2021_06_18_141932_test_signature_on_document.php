<?php

use Illuminate\Database\Migrations\Migration;
use Intervention\Image\Facades\Image;

class TestSignatureOnDocument extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$base_image_path = public_path("storage/base.png");
		$sign_image_path = public_path("storage/sign.png");
		$save_path = public_path("storage/out.png");

		draw_signatures($base_image_path, $sign_image_path, $save_path);

		dd();
	}
}
