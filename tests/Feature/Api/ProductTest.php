<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Product;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Database\Seeders\ProductsTableSeeder;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use ValidatesOpenApiSpec;
    use RefreshDatabase;


    public function testGetProducts(): void
    {
        $this->seed();

        $response = $this->get('/api/v1/products');

        $response
            ->assertStatus(200)
            ->assertSee('{"success":true,"data":[{"id":1,"name":"ANRABESS Casual Loose', false);
    }
}
