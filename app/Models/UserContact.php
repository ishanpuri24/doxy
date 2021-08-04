<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserContact extends Model
{
	use HasFactory, SoftDeletes;

	protected $fillable = [
		"user_id",
		"contact_name",
		"contact_email",
		"contact_mobile_number",
		"contact_address",
		"description",
	];


	/**
	 *  hidden fields
	 *  @var array 
	 */
	protected $hidden = [
		"created_at",
		"deleted_at",
		"updated_at",
		"status",
	];


	static public function userContacts($where, $filters = [])
	{
		$contacts = self::where($where);

		if (isset($filters['sort_by'])) {
			$contacts = $contacts->orderBy($filters['sort_by'], $filters['sort_order'] ? $filters['sort_order'] : 'asc');
		}

		return $contacts->get();
	}

	static public function updateUserContact($data)
	{
		if (isset($data['id']) && $data['id']) {
			$contact = self::find($data['id']);
		}

		if (!isset($contact) || !$contact) {
			$contact = new UserContact();
		}

		$contact->user_id = $data['user_id'];
		$contact->contact_name = $data['contact_name'];
		$contact->contact_email = $data['contact_email'];
		$contact->contact_address = $data['contact_address'];
		$contact->contact_mobile_number = $data['contact_mobile_number'];
		$contact->description = $data['description'];

		return $contact->save() ? $contact : false;
	}

	static public function deleteContact($id)
	{
		return self::find($id)->delete();
	}
}
