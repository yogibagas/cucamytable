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
        DB::table('users')->insert([
            'name' => "admin",
            'username'=>"admin",
            'email' => "yogibagasd@gmail.com",
            'password' => bcrypt('valent123'),
            'role'=>"0",
            'gender'=>"1",
            'country_id'=>100,
        ]);
    }
}
