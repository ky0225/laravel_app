<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('users')->insert([
			[
				'name' => 'test1',
				'email' => 'test1@test.com',
				'password' => Hash::make('test0225'),
				'created_at' => '2021/1/1 11:11:11',
			],
			[
				'name' => 'test2',
				'email' => 'test2@test.com',
				'password' => Hash::make('test0225'),
				'created_at' => '2021/1/1 11:11:11',
			],
			[
				'name' => 'test3',
				'email' => 'test3@test.com',
				'password' => Hash::make('test0225'),
				'created_at' => '2021/1/1 11:11:11',
		],
		]);
	}
}