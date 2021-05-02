<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'type' => 'Customer'
        ]);

        Type::create([
            'type' => 'Agent'
        ]);

        Type::create([
            'type' => 'Contact'
        ]);

        Type::create([
            'type' => 'Online'
        ]);
    }
}
