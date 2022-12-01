<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'user_ref' => 'FY53818VSHS',
                'fname' => 'Danny',
                'lname' => 'Sivyolo',
                'email' => 'dansivyolo@gmail.com',
                'password' => Hash::make('123456')
            ],
            [
                'user_ref' => 'FY53818VSKJ',
                'fname' => 'David',
                'lname' => 'Lungere',
                'email' => 'luda@gmail.com',
                'password' => Hash::make('123456')
            ],
            [
                'user_ref' => 'F353818VSLK',
                'fname' => 'Chris',
                'lname' => 'Akili',
                'email' => 'akl@gmail.com',
                'password' => Hash::make('123456')
            ],
        ]);
    }
}
