<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\UserContact;
use App\Models\UserDocument;
use App\Models\User;

class SignatureRequest extends Model
{
	use HasFactory;

	/**
	 *  declare model table
	 *  @var string
	 */
	protected $table = "signature_request";

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
		"user_document_id",
		"user_contacts_id",
		"is_signed",
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		"is_signed"		 => "boolean",
	];

	/**
	 *  define relation with contact
	 * 
	 */
	public function user_contact()
	{
		return $this->hasOne(UserContact::class, "id", "user_contacts_id");
	}

	/**
	 *  define relation with user_document
	 * 
	 */
	public function user_document()
	{
		return $this->hasOne(UserDocument::class, "id", "user_document_id");
	}

	/**
	 *  define relation with user
	 * 
	 */
	public function requested_by()
	{
		return $this->hasOne(User::class, "id", "user_id");
	}
}
