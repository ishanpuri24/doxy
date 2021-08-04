<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentVariation;
use App\Models\DocumentCategory;
use App\Models\QuestionAnswer;

class Document extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = 'document';

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
		'name',
		'document_category_id',
		'slug',
		'author_role'
	];

	/**
	 *  set relationship with document_category
	 * 
	 */
	public function category()
	{
		return $this->belongsTo(DocumentCategory::class);
	}

	/**
	 *  set relationship with document_variation
	 * 
	 */
	public function variations()
	{
		return $this->hasMany(DocumentVariation::class);
	}

	/**
	 *  set relationship with question_answer
	 * 
	*/
	public function question_answer()
	{
		return $this->hasMany(QuestionAnswer::class);
	}
}
