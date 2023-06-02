<?php

namespace Tests\Feature\Api\Order;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Laravel\Sanctum\Sanctum;
use Kirschbaum\OpenApiValidator\ValidatesOpenApiSpec;
use Illuminate\Testing\Fluent\AssertableJson;

class DestroyTest extends TestCase
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

    public function testDeletesOrderOfAuthorizedUser(): void
    {
        Sanctum::actingAs(
            User::where('name', 'John Persimonn')->first(),
            ['*']
        );

        $response = $this->deleteJson('/api/v1/orders/6');

        $response
            ->assertJson(['success' => true,
                          'data' => [],
                          'message' => 'Order has been successfully deleted.'
                        ])
            ->assertStatus(200);
    }

    public function testReturnsErrorWhenOtherUserOrderIsRequested(): void
    {
        Sanctum::actingAs(
            User::where('name', 'John Persimonn')->first(),
            ['*']
        );

        $response = $this->deleteJson('/api/v1/orders/1');

        $response
            ->assertJson(['success' => false,
                          'data' => ['error' => 'You don\'t have access to this order']
                        ])
            ->assertStatus(403);
    }

    public function testFailsWhenNotAuthorized(): void
    {

        $response = $this->deleteJson('/api/v1/orders/3');

        $response->assertStatus(401);
    }
}
