<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$user = new App\Models\User();
		$user->lastname = 'Agent';
		$user->firstname = 'Aberme';
		$user->email = 'aberme@mail.com';
		$user->password = bcrypt('secret');
		$user->save();
	}
}
