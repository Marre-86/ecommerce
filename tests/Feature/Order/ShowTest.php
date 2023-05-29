<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderOfGuestIsRenderedForAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $order = Order::where('id', 7)->firstOrFail();
        $orderTotalPrice = number_format($order->products()->selectRaw('SUM(order_product.price * order_product.quantity) as total_price')->pluck('total_price')->first(), 2);   // phpcs:ignore

        $response = $this
            ->actingAs($admin)
            ->get(route('orders.show', $order));

        $response->assertOk();
        $response->assertSee($order->description);
        $response->assertSee('<td style="white-space: nowrap;">' . $orderTotalPrice . ' $</td>', false);
    }

    public function testOrderIsNotRenderedForGuest(): void
    {
        $this->seed();

        $order = Order::where('id', 7)->firstOrFail();

        $response = $this
            ->get(route('orders.show', $order));

        $response->assertStatus(403);
    }

    public function testOrderOfOthersIsNotRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $order = Order::where('id', 7)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->get(route('orders.show', $order));

        $response->assertStatus(403);
    }

    public function testOwnOrderIsRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::where('id', 2)->first();

        $order = Order::where('id', 6)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->get(route('orders.show', $order));

            $response->assertOk();
            $response->assertSee($order->description);
    }
}
