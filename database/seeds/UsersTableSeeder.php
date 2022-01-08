<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = new App\User;
        $user->name = 'waleed';
        $user->email = 'w.hamdydeif@gmail.com';
        $user->password = Hash::make('secret');
        $user->save();
    }
}
