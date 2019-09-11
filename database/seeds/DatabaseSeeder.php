<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'felipe',
            'email' => 'felipe@gmail.com',
            'password' => Hash::make('felipe123'),
            'isSuper' => True,
            'isUser' => True,
            'api_token' => str_random(255),
        ]);
    }
}
