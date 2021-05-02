<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // men
        Product::create([
            'product_name' => 'Shirt',
            'cate_id' => 1
        ]);

        Product::create([
            'product_name' => 'Sock',
            'cate_id' => 1
        ]);

        Product::create([
            'product_name' => 'Trousor',
            'cate_id' => 1
        ]);

        // wowmen
        Product::create([
            'product_name' => 'Shirt',
            'cate_id' => 2
        ]);

        Product::create([
            'product_name' => 'Sock',
            'cate_id' => 2
        ]);

        Product::create([
            'product_name' => 'Skirt',
            'cate_id' => 2
        ]);

        // kid

        Product::create([
            'product_name' => 'Pillow',
            'cate_id' => 3
        ]);

        Product::create([
            'product_name' => 'Shirt',
            'cate_id' => 3
        ]);

        // other
        Product::create([
            'product_name' => 'Muskito',
            'cate_id' => 4
        ]);

    }
}
