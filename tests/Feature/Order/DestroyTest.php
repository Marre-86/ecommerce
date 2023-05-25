<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderIsDeletedFromDatabase(): void
    {
        $this->seed();

        $user = User::where('id', 2)->first();

        $order = Order::where('id', 3)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->delete(route('orders.destroy', $order));

        $response->assertSessionHas('flash_notification.0.message', 'Order has been successfully deleted!');
        $this->assertDatabaseMissing('orders', ['phone' => '0378 612 723']);
    }

    public function testOrderOfAnotherCreatorIsNotDeletedFromDatabase(): void
    {
        $this->seed();

        $user = User::where('id', 2)->first();

        $order = Order::where('id', 1)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->delete(route('orders.destroy', $order));

        $this->assertDatabaseHas('orders', ['id' => 1]);
    }

    public function testOrderWithLateStatusIsNotDeletedFromDatabase(): void
    {
        $this->seed();

        $user = User::where('id', 2)->first();

        $order = Order::where('id', 5)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->delete(route('orders.destroy', $order));

        $this->assertDatabaseHas('orders', ['id' => 5]);
    }
}
