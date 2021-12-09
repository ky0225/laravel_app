<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('organizations')->insert([
			['name' => '開発'],
			['name' => '管理'],
			['name' => '総務'],
		]);
	}
}
