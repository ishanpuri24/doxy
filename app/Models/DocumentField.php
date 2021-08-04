<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DocumentFieldGroup;
use App\Models\FieldPosition;

class DocumentField extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = "document_field";

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
		"field_name",
		"field_slug",
		"html_input_type",
		"document_field_group_id",
		"wrap_text",
		"line_length",
		"line_height",
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		"wrap_text" => "boolean",
	];


	/**
	 *  define relationship with document_field_group
	 * 
	 */
	public function group()
	{
		return $this->belongsTo(DocumentFieldGroup::class);
	}

	/**
	 *  define relationship with field_position
	 * 
	 */
	public function position()
	{
		return $this->hasMany(FieldPosition::class);
	}
}
