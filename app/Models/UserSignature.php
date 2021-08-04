<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSignature extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = "user_signature";

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
		"signature_image",
	];
}
