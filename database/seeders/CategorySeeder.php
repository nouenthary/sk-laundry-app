<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 

        // 1
        Category::create([
            'category_name' => 'Men',            
        ]);

        // 2
        Category::create([
            'category_name' => 'Women',            
        ]);

        // 3
        Category::create([
            'category_name' => 'Kid',            
        ]);
        
        // 4
        Category::create([
            'category_name' => 'Other',            
        ]);
    }
}
