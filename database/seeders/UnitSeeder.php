<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::create([
            'unit_type' => 'Kg' 
        ]);

        Unit::create([
            'unit_type' => 'Pcs' 
        ]);
    }
}
