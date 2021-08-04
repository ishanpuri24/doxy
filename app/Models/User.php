<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserDocument;
use App\Models\CustomUserDocument;

class User extends Authenticatable
{
	use HasFactory, Notifiable, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'deleted_at',
		'created_at',
		'updated_at',
		'email_verified_at',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	static public function updateUser($data)
	{
		$user = self::find($data['id']);
		if ($user) {
			$user->name = $data['name'];
			$user->mobile_number = $data['mobile_number'];

			return $user->save() ? true : false;
		}

		return false;
	}

	/**
	 *  define relationship with user document
	 * 
	 */
	public function documents()
	{
		return $this->hasMany(UserDocument::class);
	}

	/**
	 *  define relationship with custom user document
	 * 
	 */
	public function custom_documents()
	{
		return $this->hasMany(CustomUserDocument::class);
	}
}
