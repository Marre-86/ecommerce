<?php

namespace Tests\Feature\Api\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Illuminate\Testing\Fluent\AssertableJson;

class UpdateItemTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;
    use ValidatesOpenApiSpec;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testUpdateItemWhenAuthorized(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $itemToAdd = [
            'id' => 2,
            'quantity' => 10
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAdd);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->patchJson('/api/v1/cart', ['id' => 2, 'quantity' => 13]);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 1, fn (AssertableJson $json) =>
                        $json->where('id', 2)
                            ->where('quantity', 13)
                            ->etc())
                    ->etc())
            ->assertStatus(200);
    }

    public function testFailsWhenItemIsNotInTheCart(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $itemToAdd = [
            'id' => 2,
            'quantity' => 10
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAdd);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->patchJson('/api/v1/cart', ['id' => 3, 'quantity' => 13]);

        $response->assertJson([
            'data' => [
                'error' => 'Product with requested id is not found in the Cart',
            ],
        ])->assertStatus(400);
    }

    public function testFailsWhenNewQuantityIsNotSpecified(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $itemToAdd = [
            'id' => 2,
            'quantity' => 10
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAdd);

        // отключаем валидацию реквеста, поскольку смысл теста - именно проверить не соответсующий API реквест
        $this->withoutRequestValidation();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->patchJson('/api/v1/cart', ['id' => 2]);

        $response->assertJson([
            'data' => [
                'error' => 'New quantity of updated product should be specified',
            ],
        ])->assertStatus(400);
    }

    public function testFailsWhenItemIdIsNotSpecified(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $itemToAdd = [
            'id' => 2,
            'quantity' => 10
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAdd);

        // отключаем валидацию реквеста, поскольку смысл теста - именно проверить не соответсующий API реквест
        $this->withoutRequestValidation();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->patchJson('/api/v1/cart', ['quantity' => 13]);

        $response->assertJson([
            'data' => [
                'error' => 'ID of the updated product should be specified',
            ],
        ])->assertStatus(400);
    }

    public function testFailsWhenNotAuthorized(): void
    {

        $itemToAdd = [
            'id' => 2,
            'quantity' => 10
        ];

        $response = $this->patchJson('/api/v1/cart', $itemToAdd);

        $response
            ->assertStatus(401);
    }
}
