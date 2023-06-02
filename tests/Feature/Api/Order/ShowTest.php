<?php

namespace Tests\Feature\Api\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Laravel\Sanctum\Sanctum;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Illuminate\Testing\Fluent\AssertableJson;

class ShowTest extends TestCase
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

    public function testReturnsOrderOfAuthorizedUser(): void
    {
        Sanctum::actingAs(
            User::where('name', 'John Persimonn')->first(),
            ['*']
        );

        $response = $this->get('/api/v1/orders/3');

        $order = Order::where('id', 3)->first();

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 9)
                    ->has('data.products', $order->products->count(), fn (AssertableJson $json) =>
                        $json->where('id', $order->products->first()['id'])
                        ->etc())
                ->etc())
            ->assertStatus(200);
    }

    public function testReturnsErrorWhenOtherUserOrderIsRequested(): void
    {
        Sanctum::actingAs(
            User::where('name', 'John Persimonn')->first(),
            ['*']
        );

        $response = $this->get('/api/v1/orders/1');

        $response
            ->assertJson(['success' => false,
                          'data' => ['error' => 'You don\'t have access to this order']
                        ])
            ->assertStatus(403);
    }

    public function testFailsWhenNotAuthorized(): void
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/orders/3');

        $response->assertStatus(401);
    }
}
