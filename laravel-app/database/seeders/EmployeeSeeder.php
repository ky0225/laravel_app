<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('employees')->insert([
			[
				'organization_id' => '1',
				'base_id' => '1',
				'last_name' => 'Test',
				'first_name' => 'Alice',
				'email' => 'test1@test.com',
			],
			[
				'organization_id' => '2',
				'base_id' => '2',
				'last_name' => 'Test',
				'first_name' => 'Bob',
				'email' => 'test2@test.com',
			],			[
				'organization_id' => '3',
				'base_id' => '3',
				'last_name' => 'Test',
				'first_name' => 'Carol',
				'email' => 'test3@test.com',
			],
		]);
	}
}
