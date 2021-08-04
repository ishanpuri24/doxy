<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\DocumentField;
use App\Models\DocumentVariation;

class DocumentFieldGroup extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = 'document_field_group';

	/**
	 *  hidden fields
	 *  @var array 
	 */
	protected $hidden = [
		'created_at',
		'updated_at',
	];

	/**
	 *  declare accessible model fields
	 *  @var array
	 */
	protected $fillable = [
		'document_variation_id',
		'group_name',
		'group_description',
	];

	/**
	 *  define relationship with document_field
	 * 
	*/
	public function fields() 
	{
		return $this->hasMany(DocumentField::class);
	}

	/**
	 *  define relationship with document_variation
	 * 
	*/
	public function variation()
	{
		return $this->belongsTo(DocumentVariation::class);
	}
}
