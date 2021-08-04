<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DocumentVariation;
use App\Models\SignaturePosition;

class Signatory extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = "signatory";

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
		"name",
	];

	/**
	 *  define relationship with document_variation
	 * 
	 */
	public function variation()
	{
		return $this->belongsTo(DocumentVariation::class);
	}

	/**
	 *  define relationship with signature_position
	 * 
	 */
	public function signature()
	{
		return $this->hasMany(SignaturePosition::class);
	}
}
