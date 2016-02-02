<?php

// use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApptsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('appts', function($table)
		{
			$table->increments('id');
			$table->string('title', 255);
			$table->dateTime('start');
			$table->dateTime('end');
			$table->integer('room');
			$table->string('description', 255);
			$table->string('status');
			$table->integer('approval')->default(0);
			$table->integer('user_id');
			$table->string('created_by');
			$table->string('updated_by');
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
		Schema::drop('appts');
	}

}
