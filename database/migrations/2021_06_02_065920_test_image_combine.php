<?php

use Illuminate\Database\Migrations\Migration;
use Codedge\Fpdf\Fpdf\Fpdf;

class TestImageCombine extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$images = ["00.png", "01.png", "02.png"];

		$image_locations = array_map(function (string $image) {
			return public_path("sample/{$image}");
		}, $images);

		$pdf = $this->generate_pdf($image_locations);

		dd("stop");
	}

	private function generate_pdf(Array $images): Fpdf
	{
		$fpdf = new Fpdf;

		foreach ($images as &$image) {
			$details = $this->get_image_size($image);

			$fpdf->AddPage('P', [$details->width, $details->height]);	
			$fpdf->Image($image, 0, 0, $details->width, $details->height);
		}

		return $fpdf;
		// $fpdf->Output('F', public_path("sample/out.pdf"));
	}


	/**
	 *  return image size in MM @ DPI 96
	 * 
	*/
	private function get_image_size(string $image_path): stdClass
	{
		$details = \getimagesize($image_path);
		return (object) [
			"height"	=> $this->pixels_to_mm($details[1]),
			"width"		=> $this->pixels_to_mm($details[0]),
		];
	}

	private function pixels_to_mm(int $pixels): float
	{
		$pixel_in_inch = 96; // dpi
		$mm_in_inch = 25.4;

		return ($pixels / $pixel_in_inch) * $mm_in_inch;
	}
}
