<?php

use Illuminate\Database\Migrations\Migration;
use Intervention\Image\Facades\Image;

class TestImageClass extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$image_path = public_path('sample.png');
		$img = Image::make($image_path);

		$this->draw_text($img, 'This is an example', 152, 356);

		$long_text = "Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam totam laudantium eius vel adipisci nemo nisi excepturi. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ullam totam laudantium eius vel adipisci nemo nisi excepturi";
		$this->draw_text($img, $long_text, 160, 795, true);

		$this->draw_checkbox($img, 701, 515);

		$img->save(public_path('out.png'));
		dd("stop");
	}

	/**
	 *  draw text on image
	 * 
	*/
	private function draw_text($image, string $text, int $x, int $y, bool $wrap = false): void
	{
		$max_length = 65;

		if ($wrap) {
			$this->draw_wrapped_text($image, $text, $x, $y, $max_length);
		} else {
			$this->draw_simple_text($image, $text, $x, $y);
		}	
	}

	private function draw_simple_text(&$image, string $text, int $x, int $y): void
	{
		$image->text($text, $x, $y, function ($font) {
			$this->set_font($font);
		});
	}

	private function draw_wrapped_text(&$image, string $text, int $x, int $y, int $max_length): void
	{	
		$line_height = 23;
		$lines = str_split($text, $max_length);
		
		foreach ($lines as &$line) {
			$this->draw_simple_text($image, $line, $x, $y);
			$y += $line_height;	
		}
	}

	private function draw_checkbox(&$image, int $x, int $y): void 
	{
		$check = 'x';
		$image->text($check, $x, $y, function ($font) {
			$this->set_font($font, true, "center");
		});
	}

	private function set_font($font, bool $bold = false, string $align = "left")
	{
		$font_family = ($bold) ? 'fonts/document/Roboto-Bold.ttf' : 'fonts/document/Roboto-Regular.ttf';

		$font->file(public_path($font_family));
		$font->size(14);
		$font->color('#000000');
		$font->align($align);
		$font->valign('middle');
	}
}
