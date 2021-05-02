<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_name' => 'Admin'
        ]);

        Role::create([
            'role_name' => 'Sale'
        ]);

        Role::create([
            'role_name' => 'Delivery'
        ]);

        Role::create([
            'role_name' => 'Account'
        ]);

        Role::create([
            'role_name' => 'Agent'
        ]);
    }
}
