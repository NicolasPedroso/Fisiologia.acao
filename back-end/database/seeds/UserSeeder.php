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
            'email' => 'admin@fisiologia.com',
            'password' => bcrypt('secret'),
            'address' => "Endereço do admin",
            'phone' => "(00) 44112-23344",
            'image' => "",
            'admin' => true,
            'name' => "Admin",
        ]);

        DB::table('users')->insert([
            'email' => 'user@fisiologia.com',
            'password' => bcrypt('secret'),
            'address' => "endereço do usuário",
            'phone' => "(00) 12345-6789",
            'image' => "",
            'admin' => false,
            'name' => "Usuário",
        ]);
    }
}
