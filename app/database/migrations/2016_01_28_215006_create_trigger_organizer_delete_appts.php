<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTriggerOrganizerDeleteAppts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::unprepared('
	    CREATE TRIGGER `organizer_delete_appts` AFTER DELETE ON `rv_appts` FOR EACH ROW
	    BEGIN
	    DELETE FROM rv_attendees WHERE appt_id = OLD.id;
	    END
    ');
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::unprepared('DROP TRIGGER `organizer_delete_appts`');
	}

}
