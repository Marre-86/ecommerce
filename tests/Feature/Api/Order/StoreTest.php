<?php

namespace Tests\Feature\Api\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Laravel\Sanctum\Sanctum;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Illuminate\Testing\Fluent\AssertableJson;

class StoreTest extends TestCase
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

    public function testStoresOrderOfAuthorizedUser(): void
    {
        Sanctum::actingAs(
            User::where('name', 'John Persimonn')->first(),
            ['*']
        );

        $itemToAddToCart = [
            'id' => 2,
            'quantity' => 7
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAddToCart);

        $orderData = [
            'phone' => '+21324777',
            'description' => 'Leave the package at the front door'
        ];

        $response = $this->postJson('/api/v1/orders', $orderData);

        $response->assertJson([
            'data' => [
                'phone' => '+21324777',
                'description' => 'Leave the package at the front door',
                'items' => 1,
                'price' => '602.84',
            ],
        ])->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'phone' => '+21324777', 'description' => 'Leave the package at the front door',
            'status' => 'Awaiting Confirmation'
        ]);

        $this->assertDatabaseHas('order_product', [
            'product_id' => 2, 'quantity' => 7, 'price' => 86.12
        ]);
    }

    public function testComplainsThatCartIsEmpty(): void
    {
        Sanctum::actingAs(
            User::where('name', 'John Persimonn')->first(),
            ['*']
        );

        $orderData = [
            'phone' => '+21324777',
            'description' => 'Leave the package at the front door'
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/orders', $orderData);

        $response->assertJson([
            'data' => [
                'error' => 'The cart is empty'
            ],
        ])->assertStatus(400);

        $this->assertDatabaseMissing('orders', [
            'phone' => '+21324777', 'description' => 'Leave the package at the front door'
        ]);
    }

    public function testComplainsAtInvalidPhone(): void
    {
        Sanctum::actingAs(
            User::where('name', 'John Persimonn')->first(),
            ['*']
        );
            //  Retrieve the error message from language files
        $expectedErrorMessage = __('validation.regex', ['attribute' => 'phone']);

        $itemToAddToCart = [
            'id' => 2,
            'quantity' => 7
        ];

        $this->withHeaders([
            'Authorization' => 'Bearer #token#'
        ])->postJson('/api/v1/cart', $itemToAddToCart);

        $orderData = [
            'phone' => '+2132s777',
            'description' => 'Leave the package at the front door'
        ];

        $response = $this->postJson('/api/v1/orders', $orderData);

        $response->assertJson([
            'data' => [
                'phone' => [ $expectedErrorMessage ]
            ],
        ])->assertStatus(400);

        $this->assertDatabaseMissing('orders', [
            'phone' => '+2132s777', 'description' => 'Leave the package at the front door'
        ]);
    }

    public function testFailsWhenNotAuthorized(): void
    {
        $orderData = [
            'phone' => '+21323777',
            'description' => 'Leave the package at the front door'
        ];

        $response = $this->postJson('/api/v1/orders', $orderData);

        $response->assertStatus(401);
    }
}
