<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);  
        $this->call(ServiceTypeSeeder::class);
        $this->call(ServiceSeeder::class);    
        $this->call(UnitSeeder::class);    
        $this->call(TypeSeeder::class);    
        
    }
}
