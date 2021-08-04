<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DocumentField;

class FieldPosition extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = "field_position";

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
		"document_field_id",
		"page",
		"x",
		"y",
	];

	/**
	 *  define relationship with document variation
	 * 
	*/
	public function field() {
		return $this->belongsTo(DocumentField::class);
	}	
}
