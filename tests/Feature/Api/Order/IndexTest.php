<?php

namespace Tests\Feature\Api\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
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

    public function testReturnsOrdersOfAuthorizedUser(): void
    {
        Sanctum::actingAs(
            User::where('name', 'John Persimonn')->first(),
            ['*']
        );

        $response = $this->get('/api/v1/orders');

        $response
            ->assertJson(fn (AssertableJson $json) =>
                $json->has('data', 3, fn (AssertableJson $json) =>
                        $json->where('id', 3)
                            ->where('status', 'Shipped')
                            ->etc())
                    ->etc())
            ->assertStatus(200);
    }

    public function testReturnsEmptyListToNewUser(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->get('/api/v1/orders');

        $response
            ->assertJson(['message' => 'You don\'t have any orders.'])
            ->assertStatus(200);
    }

    public function testFailsWhenNotAuthorized(): void
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->get('/api/v1/orders');

        $response->assertStatus(401);
    }
}
