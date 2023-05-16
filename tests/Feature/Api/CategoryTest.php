<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Category;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Database\Seeders\CategoriesTableSeeder;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class CategoryTest extends TestCase
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
            ->assertSee('{"success":true,"data":[{"id":1,"name":"Women","parent_id":null,"grandparent_id":null,"children":[{"id":4,"name":"Dresses",', false);   // phpcs:ignore
    }

    public function testAddCategoryWhenAuthorized(): void
    {
        $this->seed(CategoriesTableSeeder::class);

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $newCategory = [
            'name' => 'Rainboots',
            'parent_id' => 10
        ];

        $response = $this->postJson('/api/v1/category', $newCategory);

        $response
            ->assertStatus(201)
            ->assertJsonFragment($newCategory);
    }

    public function testFailsAddCategoryWhenNotAuthorized(): void
    {
        $this->seed(CategoriesTableSeeder::class);

        $newCategory = [
            'name' => 'Rainboots',
            'parent_id' => 10
        ];

        $response = $this->postJson('/api/v1/category', $newCategory);

        $response
            ->assertStatus(401);
    }

    public function testFailsWhenAddCategoryWithoutName(): void
    {
        $this->seed(CategoriesTableSeeder::class);

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $newCategory = [
            'parent_id' => 10
        ];

        // отключаем валидацию реквеста, поскольку смысл теста - именно проверить не соответсующий API реквест
        $this->withoutRequestValidation();

        $response = $this->postJson('/api/v1/category', $newCategory);

        $response
            ->assertStatus(400)
            ->assertJsonFragment(['error' => 'Bad request. Probably not enough of required fields']);
    }
}
