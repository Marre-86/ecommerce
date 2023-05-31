<?php

namespace Tests\Feature\Api\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Illuminate\Testing\Fluent\AssertableJson;

class RemoveItemTest extends TestCase
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

    public function testRemoveItemWhenAuthorized(): void
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
        ])->deleteJson('/api/v1/cart', ['id' => 2]);

        $response->assertJson([
            'message' => 'Product has been deleted from the cart successfully. Updated cart is returned'
        ])->assertStatus(200);
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
        ])->deleteJson('/api/v1/cart');

        $response->assertJson([
            'data' => [
                'error' => 'ID of the removed product should be specified',
            ],
        ])->assertStatus(400);
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
        ])->deleteJson('/api/v1/cart', ['id' => 3]);

        $response->assertJson([
            'data' => [
                'error' => 'Product with requested id is not found in the Cart',
            ],
        ])->assertStatus(400);
    }

    public function testFailsWhenNotAuthorized(): void
    {

        $itemToAdd = [
            'id' => 2,
        ];

        $response = $this->deleteJson('/api/v1/cart', $itemToAdd);

        $response
            ->assertStatus(401);
    }
}
