<?php

namespace Tests\Feature\Api\Cart;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Illuminate\Testing\Fluent\AssertableJson;

class IndexTest extends TestCase
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

    public function testShowsCartWhenAuthorized(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
        // check that empty cart is returned to User1
        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->get('/api/v1/cart');

        $response->assertJson([
            'message' => 'Cart is empty.'
        ])->assertStatus(200);

        // check that after adding an item the Cart with this item is returned to User1
        $itemToAdd = [
            'id' => 4,
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAdd);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->get('/api/v1/cart');

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 1, fn (AssertableJson $json) =>
                        $json->where('id', 4)
                            ->where('name', 'DREAM PAIRS Women\'s High Stilettos Heels')
                            ->etc())
                    ->etc())
            ->assertStatus(200);

        // check that for User2 still the empty Cart is returned
        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token2#'
        ])->get('/api/v1/cart');

        $response->assertJson([
            'message' => 'Cart is empty.'
        ])->assertStatus(200);
    }

    public function testFailsWhenNotAuthorized(): void
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json'  // didn't get it why doesn't work without this header (like in other tests)
        ])->get('/api/v1/cart');

        $response->assertStatus(401);
    }
}
