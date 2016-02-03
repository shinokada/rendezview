<?php

class PermissionsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('permissions')->delete();

        //Permission 1
        $manageUsers = new Permission;
        $manageUsers->name = 'manage_users';
        $manageUsers->display_name = 'Manage Users';
        $manageUsers->save();

        DB::table('permission_role')->delete();

        //Role ID 1 and 2 are admin and user respectively.
        $permissions = array(
            array(
                'role_id'      => 1,
                'permission_id' => 1
            ),
        );

        DB::table('permission_role')->insert( $permissions );
    }

}
