<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTriggerAddUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::unprepared('
	    CREATE TRIGGER `add_user` AFTER INSERT ON `rv_users` FOR EACH ROW
	    BEGIN
			INSERT INTO rv_assigned_roles (id, user_id, role_id) VALUES (null, NEW.id, 2 );
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
		DB::unprepared('DROP TRIGGER `add_user`');
	}

}
