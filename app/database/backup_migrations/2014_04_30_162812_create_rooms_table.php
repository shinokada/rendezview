<?php

use Illuminate\Database\Migrations\Migration;

class CreateRoomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Creates the users table
        Schema::create('rooms', function($table)
        {
            $table->increments('id');
            $table->integer('room_admin_id');
            $table->string('room_name');
            $table->string('room_location');
            $table->string('room_capacity');
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
		Schema::drop('rooms');
	}

}
