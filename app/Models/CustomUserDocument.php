<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomUserDocument extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = "custom_user_document";

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
		"user_id",
		"name",
		"template_images",
		"fields",
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		"template_images" => "array",
		"fields"					=> "array",
	];
}
