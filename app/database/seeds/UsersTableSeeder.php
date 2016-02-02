<?php

class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        $users = array(
            array(
                'username'          => 'admin',
                'fullname'          => 'Administrator',
                'email'             => 'admin@example.org',
                'password'          => Hash::make('admin'),
                'confirmed'         => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at'        => new DateTime,
                'updated_at'        => new DateTime,
            ),
            array(
                'username'          => 'user',
                'fullname'          => 'User',
                'email'             => 'user@example.org',
                'password'          => Hash::make('user'),
                'confirmed'         => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at'        => new DateTime,
                'updated_at'        => new DateTime,
            )
        );

        DB::table('users')->insert( $users );

        $user = User::where('username','=','admin')->first();
        $adminRole = Role::where('name', '=', 'admin')->first();
        $user->attachRole( $adminRole );

        $user = User::where('username','=','user')->first();
        $userRole = Role::where('name', '=', 'user')->first();
        $user->attachRole( $userRole );
    }

}
