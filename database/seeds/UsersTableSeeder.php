<?php

use Illuminate\Database\Seeder;
// use Faker\Generator as Faker;

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
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => bcrypt('password'),
            'address' => Str::random(10).' street '. Str::random(12),
            'phone' =>Int::random(11),
        ]);
    }
}
