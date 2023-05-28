<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testOrdersAreRenderedForAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $order = Order::where('id', 7)->firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->get(route('orders.index'));

        $response->assertSee($order->status);
    }

    public function testOwnOrdersAreRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::where('id', 2)->first();

        $order = Order::where('id', 6)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->get(route('orders.index'));

        $response->assertSee($order->status);
    }

    public function testOrdersOfOthersAreNotRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::where('id', 2)->first();

        $order = Order::where('id', 2)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->get(route('orders.index'));

        $response->assertDontSee($order->status);
    }

    public function testOrdersAreNotRenderedForGuest(): void
    {
        $this->seed();

        $order = Order::where('id', 7)->firstOrFail();

        $response = $this
            ->get(route('orders.index'));

        $response->assertStatus(403);
    }
}
