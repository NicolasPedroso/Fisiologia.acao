<?php

use Illuminate\Database\Seeder;

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
            'email' => 'admin@ecomp.co',
            'password' => bcrypt('secret'),
            'address' => "casa",
            'phone' => "4411122",
            'image' => "teste.jpg",
            'admin' => true,
        ]);
    }
}
