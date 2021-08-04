<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DocumentVariation;

class TemplateImage extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = "template_image";

	/**
	 *  hidden fields
	 *  @var array 
	 */
	protected $hidden = [
		"created_at",
		"updated_at",
	];

	/**
	 *  declare accessible model fields
	 *  @var array
	 */
	protected $fillable = [
		"document_variation_id",
		"page",
		"location",
	];

	/**
	 *  define relationship with document_variation
	 * 
	 */
	public function variation() 
	{
		return $this->belongsTo(DocumentVariation::class);
	}
}
