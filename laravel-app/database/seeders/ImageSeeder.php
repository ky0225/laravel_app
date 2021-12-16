<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('images')->insert([
			[
				'filename' => 'sample1.png',
				'title' => 'サンプル1',
			],
			[
				'filename' => 'sample2.png',
				'title' => 'サンプル2',
			],
			[
				'filename' => 'sample3.png',
				'title' => 'サンプル3',
			],
			[
				'filename' => 'sample4.png',
				'title' => 'サンプル4',
			],
			[
				'filename' => 'sample5.png',
				'title' => 'サンプル5',
			],
		]);
	}
}
