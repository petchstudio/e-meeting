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
        DB::table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@dusit.com',
            'password' => bcrypt('1234'),
            'prefix' => '',
            'firstname' => 'ผู้ดูแลระบบ',
            'lastname' => 'ประชุมออนไลน์',
            'position' => 'ผู้ดูแล',
            'belong_to' => 'มหาวิทยาลัยสวนดุสิต',
            'type' => 'admin',
        ]);
    }
}
