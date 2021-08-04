<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use \stdClass;
use Codedge\Fpdf\Fpdf\Fpdf;

use App\Models\DocumentVariation;
use App\Models\TemplateImage;
use App\Models\UserSignature;
use \Exception;
use Symfony\Component\Process\Process;

class PDFController extends Controller
{
	/**
	 *  generate document preview images using the filled data provided
	 *  by the user 
	 *  @method: POST
	 */
	public function generate_preview(Request $request)
	{
		$variation_id = $request->document_variation_id;
		$filled_data = $request->filled_data;
		$current_previews = $request->current_previews;

		/**
		 *  delete previous previews. care is taken to not delete original template
		 *  images
		 */
		$this->delete_under_process_images($current_previews);
		$under_process_images = $this->generate_images_from_filled_data($variation_id, $filled_data);

		return $under_process_images;
	}


	/**
	 *  apply filled data to document_variation_id's template and produce the 
	 *  preview images
	 */
	private function generate_images_from_filled_data(int $variation_id, array $filled_data): array
	{
		$variation = DocumentVariation::where("id", $variation_id)
			->with("fields.position")
			->first();

		$template_images = TemplateImage::where("document_variation_id", $variation_id)
			->orderBy("page")
			->get();

		$under_process_images = $this->copy_to_under_process($template_images->toarray());
		$organized_data = $this->organize_filled_data($variation->toarray(), $filled_data);

		$this->write_data_on_images($under_process_images, $organized_data);
		return $under_process_images;
	}


	/**
	 *  step 1: copy sample template images into temporary 
	 *  directory for intermediate processing
	 */
	private function copy_to_under_process(array $template_images): array
	{
		return array_map(function ($image): stdClass {
			$random_str = Str::random(30);
			$new_location = "/storage/under_process/{$random_str}.png";

			File::copy(
				public_path("/storage/{$image["location"]}"),
				public_path($new_location)
			);

			return (object) [
				"page"				=> $image["page"],
				"location"		=> $new_location,
			];
		}, $template_images);
	}

	/**
	 *  delete processed template images after processing in completed
	 * 
	 */
	private function delete_under_process_images(array $images): void
	{
		foreach ($images as &$image) {
			$image = ($image instanceof stdClass)
				? (array) $image
				: $image;

			$file_path = "";

			if (substr($image["location"], 0, 14) === "under_process/") {
				$file_path = public_path("/storage/" . $image["location"]);
			} else if (substr($image["location"], 0, 23) === "/storage/under_process/") {
				$file_path = public_path($image["location"]);
			} else {
				return;
			}

			if (!File::exists($file_path)) {
				throw new \Exception("File does not exist: {$file_path}");
			}

			File::delete($file_path);
		}
	}

	/**
	 *  combine field positions & page data with user-filled data to ease next 
	 *  steps
	 */
	private function organize_filled_data(array $variation, array $filled_data): array
	{
		$results = [];

		foreach ($variation["fields"] as &$field) {
			foreach ($field["position"] as &$position) {

				$slug = $field["field_slug"];
				$field_data = $filled_data[$slug];

				if (isset($field_data)) {
					if ($field["html_input_type"] === "checkbox" && $field_data === false) {
						continue;
					}

					$page_num = $position["page"];

					$results[$page_num][] = [
						"field_slug"				=> $slug,
						"html_input_type"		=> $field["html_input_type"],
						"filled"						=> $field_data,
						"x"									=> $position["x"],
						"y"									=> $position["y"],
						"wrap_text"					=> $field["wrap_text"],
						"line_length"				=> $field["line_length"],
						"line_height"				=> $field["line_height"],
					];
				}
			}
		}

		return $results;
	}

	/**
	 *  write organized data on template images
	 * 
	 */
	private function write_data_on_images(array $template_images, array $organized_data): void
	{
		foreach ($template_images as &$t_image) {
			$current_page = $t_image->page;
			$path = public_path($t_image->location);

			$image = Image::make($path);

			foreach ($organized_data as $page => &$fields) {
				if ($page === $current_page) {
					foreach ($fields as &$field) {
						if ($field["html_input_type"] === "checkbox") {
							ProcessImage::draw_checkbox($image, $field["x"], $field["y"]);
						} else {
							ProcessImage::draw_text($image, $field["filled"], $field["y"], $field["y"], [
								"wrap_text"			=> $field["wrap_text"],
								"line_height"		=> $field["line_height"],
							]);
						}
					}
				}
			}

			$image->save($path);
		}
	}


	/**
	 *  generate PDF file from provided document_variation_id and filled_data
	 *  @method: POST
	 */
	public function generate_pdf(Request $request)
	{
		$variation_id = $request->variation_id;
		$filled_data = $request->filled_data;

		$under_process_images = $this->generate_images_from_filled_data($variation_id, $filled_data);
		$images = array_map(function ($image) {
			return public_path($image->location);
		}, $under_process_images);

		$pdf = ProcessPDF::generate_pdf($images);
		$this->delete_under_process_images($under_process_images);

		return $pdf->Output("I");
	}
}

/**
 *  there is no real need for this to be a class.
 *  This of it a simple namespace containing function 
 *  for writing on top of images
 */
class ProcessImage
{
	/**
	 *  draw text on image
	 * 
	 */
	public static function draw_text($image, string $text, int $x, int $y, array $options = []): void
	{
		$default_options = [
			"max_length"		=> 65,
			"wrap"					=> false,
			"line_height"		=> 23,
		];

		$options = \array_merge($default_options, $options);

		if ($options["wrap"]) {
			self::draw_wrapped_text($image, $text, $x, $y, $options);
		} else {
			self::draw_simple_text($image, $text, $x, $y);
		}
	}

	private static function draw_simple_text(&$image, string $text, int $x, int $y): void
	{
		$image->text($text, $x, $y, function ($font) {
			self::set_font($font);
		});
	}

	private static function draw_wrapped_text(&$image, string $text, int $x, int $y, array $options): void
	{
		$max_length = $options["max_length"];
		$line_height = $options["line_height"];

		$lines = str_split($text, $max_length);

		foreach ($lines as &$line) {
			self::draw_simple_text($image, $line, $x, $y);
			$y += $line_height;
		}
	}

	public static function draw_checkbox(&$image, int $x, int $y): void
	{
		$check = 'x';
		$image->text($check, $x, $y, function ($font) {
			self::set_font($font, [
				"bold"	=> true,
				"align"	=> "center"
			]);
		});
	}

	private static function set_font($font, array $options = [])
	{
		$default_options = [
			"bold"		=> false,
			"align"		=> "left"
		];

		$options = \array_merge($default_options, $options);
		$font_family = ($options["bold"])
			? 'fonts/document/Roboto-Bold.ttf'
			: 'fonts/document/Roboto-Regular.ttf';

		$font->file(public_path($font_family));
		$font->size(14);
		$font->color('#000000');
		$font->align($options["align"]);
		$font->valign('middle');
	}


	/**
	 *  draw signatures on template image
	 * 
	 */
	private static function draw_signatures(string $base, string $signature, string $save_path)
	{
		$base_image = Image::make($base);
		$sign_image = Image::make($signature);

		$sign_width = 150; // px

		$sign_image->resize($sign_width, null, function ($constraint) {
			$constraint->aspectRatio();
		});

		$sign_height = $sign_image->height();

		$x = 1075;
		$y = 1450;

		$insert_coordinates = self::calculate_image_center($sign_height, $sign_width, $x, $y);

		$base_image->insert(
			$sign_image,
			"top-left",
			$insert_coordinates->x,
			$insert_coordinates->y
		);

		$base_image->save($save_path);
	}


	/**
	 *  calculate insert co-ordinates for the signature image
	 * 
	 */
	private static function calculate_image_center(int $image_height, int $image_width, int $x, int $y): stdClass
	{
		return (object) [
			"x"		=> $x - ($image_width / 2),
			"y"		=> $y - ($image_height / 2),
		];
	}


	/**
	 *  convert base64 encoding to binary data
	 * 
	 */
	public static function base64_to_binary(string $data)
	{
		if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
			$data = substr($data, strpos($data, ',') + 1);
			$type = strtolower($type[1]); // jpg, png, gif

			if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
				throw new \Exception('invalid image type');
			}

			$data = str_replace(' ', '+', $data);
			$data = base64_decode($data);

			if ($data === false) throw new \Exception('base64_decode failed');
		} else {
			throw new \Exception('did not match data URI with image data');
		}

		return $data;
	}
}


/**
 *  there is no real need for this to be a class.
 *  This of it a simple namespace containing function 
 *  for converting images into PDF :map(image) -> page
 */
class ProcessPDF
{
	public static function generate_pdf(array $images): Fpdf
	{
		$fpdf = new Fpdf;

		foreach ($images as &$image) {
			$details = self::get_image_size($image);

			$fpdf->AddPage('P', [$details->width, $details->height]);
			$fpdf->Image($image, 0, 0, $details->width, $details->height);
		}

		return $fpdf;
	}


	/**
	 *  return image size in MM @ DPI 96
	 * 
	 */
	private static function get_image_size(string $image_path): stdClass
	{
		$details = \getimagesize($image_path);
		return (object) [
			"height"	=> self::pixels_to_mm($details[1]),
			"width"		=> self::pixels_to_mm($details[0]),
		];
	}

	private static function pixels_to_mm(int $pixels): float
	{
		$pixel_in_inch = 96; // dpi
		$mm_in_inch = 25.4;

		return ($pixels / $pixel_in_inch) * $mm_in_inch;
	}
}
