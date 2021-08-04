<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DocumentVariation;

class UserDocument extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = "user_document";

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
		"filled_data",
		"user_id",
		"shared_with",
	];

	/**
	 *  The attributes that should be cast.
	 *  @var array
	 */
	protected $casts = [
		"filled_data"		=> "array", 
		"shared_with"		=> "array",
	];

	/**
	 *  define relationship with document_variation
	 * 
	 */
	public function variation()
	{
		return $this->hasOne(DocumentVariation::class, "id", "document_variation_id");
	}
}
