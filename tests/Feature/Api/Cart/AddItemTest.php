<?php

namespace Tests\Feature\Api\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Illuminate\Testing\Fluent\AssertableJson;

class AddItemTest extends TestCase
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

    public function testAddItemWhenAuthorized(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $itemToAdd = [
            'id' => 2,
            'quantity' => 10
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAdd);

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 1, fn (AssertableJson $json) =>
                        $json->where('id', 2)
                            ->where('name', 'Vince Camuto Women\'s Hamden Slingback Pump')
                            ->etc())
                    ->etc())
            ->assertStatus(200);
    }

    public function testAddItemFailsWhenItemNotFound(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $itemToAdd = [
            'id' => 99,
            'quantity' => 10
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAdd);

        $response->assertJson([
            'data' => [
                'error' => 'The product with requested id doesn\'t exist',
            ],
        ])->assertStatus(400);
    }

    public function testFailsWhenNotAuthorized(): void
    {

        $itemToAdd = [
            'id' => 2,
            'quantity' => 10
        ];

        $response = $this->postJson('/api/v1/cart', $itemToAdd);

        $response
            ->assertStatus(401);
    }
}
