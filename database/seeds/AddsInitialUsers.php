<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddsInitialUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\User();
        $user->password = Hash::make('test');
        $user->email = 'super-admin@example.com';
        $user->name = 'super admin';
        $user->save();

        $user = new App\User();
        $user->password = Hash::make('test');
        $user->email = 'admin@example.com';
        $user->name = 'admin';
        $user->save();

        $user = new App\User();
        $user->password = Hash::make('test');
        $user->email = 'user@example.com';
        $user->name = 'user';
        $user->save();
    }
}
