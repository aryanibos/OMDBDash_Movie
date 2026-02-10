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
            'name' => 'Aldmic User',
            'username' => 'aldmic',
            'password' => bcrypt('123abc123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
