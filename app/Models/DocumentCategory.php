<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Document;

class DocumentCategory extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = 'document_category';

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
		'name',
		'parent_category_id',
	];

	/**
	 *  set relationship with document_category
	 * 
	*/
	public function documents()
	{
		return $this->hasMany(Document::class);
	}
}
