<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function (Blueprint $table) {
			$table->id();
			$table->foreignId('organization_id')->constrained('organizations');
			$table->foreignId('base_id')->constrained('bases');
			$table->string('last_name');
			$table->string('first_name');
			$table->string('email')->unique('email');
			$table->foreignId('image')->nullable('true')->constrained('images');
			$table->softDeletes(); // ソフトデリートを保存する
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('employees');
	}
}
