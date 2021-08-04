<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class GeneratedDocument extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = 'generated_document';

	/**
	 *  hidden fields
	 *  @var array 
	*/
	protected $hidden = [
		'created_at',
		'updated_at',
		'deleted_at',
	];

	/**
	 *  declare accessible model fields
	 *  @var array
	 */
	protected $fillable = [
		'document_id',
		'document_variation_id',
		'document_fields_data',
		'publish_status',
	];
}
