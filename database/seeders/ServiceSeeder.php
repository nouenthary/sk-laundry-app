<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::create([
            'service_name' => 'Washing',
            'price' => '1500',
            'user_id' => '1',
            'unit_type' => 'Kg',
            'unit' => '1',
            'type'=>'Customer'
        ]);

        Service::create([
            'service_name' => 'Washing & Iron',
            'price' => '2000',
            'user_id' => '1',
            'unit_type' => 'Pcs',
            'unit' => '1',
            'type'=>'Customer'
        ]);

        Service::create([
            'service_name' => 'Washing',
            'price' => '1500',
            'user_id' => '1',
            'unit_type' => 'Kg',
            'unit' => '1',
            'type'=>'Agent'
        ]);

        Service::create([
            'service_name' => 'Washing & Iron',
            'price' => '1000',
            'user_id' => '1',
            'unit_type' => 'Pcs',
            'unit' => '1',
            'type'=>'Agent'
        ]);
    }
}
