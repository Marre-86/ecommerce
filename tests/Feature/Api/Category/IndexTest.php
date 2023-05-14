<?php

namespace Tests\Feature\Api\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Database\Seeders\CategoriesTableSeeder;

class IndexTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use ValidatesOpenApiSpec;
    use RefreshDatabase;


    public function testGetCategoriesTree(): void
    {
        $this->seed(CategoriesTableSeeder::class);

        $response = $this->get('/api/v1/listing-categories/tree');

        $response
            ->assertStatus(200)
            ->assertSee('{"data":[{"id":1,"name":"Women","parent_id":null,"grandparent_id":null,"children":[{"id":4,"name":"Dresses",', false);   // phpcs:ignore
    }
}
