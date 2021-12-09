<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('bases')->insert([
			['name' => '東京'],
			['name' => '福岡'],
			['name' => '佐賀'],
		]);
	}
}
