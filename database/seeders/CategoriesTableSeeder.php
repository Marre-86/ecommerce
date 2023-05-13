<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();

        Category::create([
            'name' => 'Women',
        ]);

        Category::create([
            'name' => 'Men',
        ]);

        Category::create([
            'name' => 'Children',
        ]);
        
        Category::create([
            'name' => 'Dresses',
            'parent_id' => 1,
        ]);

        Category::create([
            'name' => 'Shoes',
            'parent_id' => 1,
        ]);

        Category::create([
            'name' => 'High heels',
            'parent_id' => 5,
            'grandparent_id' => 1
        ]);

        Category::create([
            'name' => 'Mules',
            'parent_id' => 5,
            'grandparent_id' => 1
        ]);

        Category::create([
            'name' => 'Slingbacks',
            'parent_id' => 5,
            'grandparent_id' => 1
        ]);

        Category::create([
            'name' => 'Winklepickers',
            'parent_id' => 5,
            'grandparent_id' => 1
        ]);

        Category::create([
            'name' => 'Shoes',
            'parent_id' => 2,
        ]);

    }
}
