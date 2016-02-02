<?php

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        $adminRole = new Role;
        $adminRole->name = 'admin';
        $adminRole->description = 'Administrative user';
        $adminRole->save();

        $userRole = new Role;
        $userRole->name = 'user';
        $userRole->description = 'Regular user';
        $userRole->save();

    }
}
