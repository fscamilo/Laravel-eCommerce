<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
			array(
				'name' => 'Ringo',
				'email' => 'ringo@lec.co.uk',
				'password' => bcrypt('1234'),
				'role' => 'driver',
				'parent' => '0',
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'name' => 'Paul',
				'email' => 'paul@lec.co.uk',
				'password' => bcrypt('1234'),
				'role' => 'client',
				'parent' => '0',
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),
			array(
				'name' => 'John',
				'email' => 'john@lec.co.uk',
				'password' => bcrypt('1234'),
				'role' => 'administrator',
				'parent' => '0',
				'created_at'=>date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s')
			),

		];

		User::truncate();
		User::insert($users);
    }
}