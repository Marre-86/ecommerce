<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::truncate();

        Product::create([
            'name' => 'ANRABESS Casual Loose Short Sleeve Long Dress',
            'description' => 'Split Maxi Summer Beach Dress with Pockets',
            'price' => 30.59,
            'weight' => 1,
            'category_id' => 4
        ]);

        Product::create([
            'name' => 'Vince Camuto Women\'s Hamden Slingback Pump',
            'price' => 86.12,
            'weight' => 2,
            'category_id' => 8
        ]);
    }
}
