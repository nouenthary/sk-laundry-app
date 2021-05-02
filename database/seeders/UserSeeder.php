<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'admin',
            'password' => bcrypt('12345678'),
            'role_id' => 1
        ]);
        
        User::create([
            'username' => 'thary',
            'password' => bcrypt('12345678'),
            'role_id' => 1
        ]);

        User::create([
            'username' => 'long',
            'password' => bcrypt('12345678'),
            'role_id' => 2
        ]);

        User::create([
            'username' => 'nita',
            'password' => bcrypt('12345678'),
            'role_id' => 4
        ]);

    }
}
