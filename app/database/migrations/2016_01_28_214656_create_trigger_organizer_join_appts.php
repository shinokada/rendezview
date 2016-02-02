<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTriggerOrganizerJoinAppts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::unprepared('
	    CREATE TRIGGER `organizer_join_appts` AFTER INSERT ON `rv_appts` FOR EACH ROW
	    BEGIN
	    INSERT INTO rv_attendees (appt_id, user_id) VALUES (NEW.id, NEW.user_id);
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
		DB::unprepared('DROP TRIGGER `organizer_join_appts`');
	}

}
