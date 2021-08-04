<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Document;
use App\Models\DocumentField;
use App\Models\DocumentFieldGroup;
use App\Models\TemplateImage;
use App\Models\Signatory;
use App\Models\UserDocument;

class DocumentVariation extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = 'document_variation';

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
		'document_id',
		'state',
		'user_id',
		'document_name',
	];

	/**
	 *  define relationship with document
	 * 
	 */
	public function document()
	{
		return $this->belongsTo(Document::class);
	}

	/**
	 *  define relationship with document_field
	 * 
	 */
	public function fields()
	{
		return $this->hasMany(DocumentField::class);
	}

	/**
	 *  define relationship with document_field_group
	 * 
	 */
	public function fieldGroups()
	{
		return $this->hasMany(DocumentFieldGroup::class);
	}

	/**
	 *  define relationship with template_image
	 * 
	 */
	public function templateImages()
	{
		return $this->hasMany(TemplateImage::class);
	}

	/**
	 *  define relationship with signatory
	 * 
	 */
	public function signatories()
	{
		return $this->hasMany(Signatory::class);
	}

	/**
	 *  define relationship with user documents
	 * 
	*/
	public function user_documents()
	{
		return $this->hasMany(UserDocument::class);
	}
}
