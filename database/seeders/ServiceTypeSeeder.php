<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceType;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceType::create([
            'service_name' =>  'Washing'
        ]);

        ServiceType::create([
            'service_name' => 'Washing & Iron'
        ]);

        ServiceType::create([
            'service_name' =>  'Dry'
        ]);

        ServiceType::create([
            'service_name' => 'Dry & Clean'
        ]);
    }
}
