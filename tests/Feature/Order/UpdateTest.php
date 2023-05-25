<?php

namespace Tests\Feature\Order;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    use RefreshDatabase;

    public function testOrderIsUpdatedByAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $order = Order::where('id', 6)->firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->patch(route('orders.update', $order), ['status' => 'Completed']);

        $response->assertRedirectToRoute('orders.index');
        $this->assertDatabaseHas('orders', [
            'id' => 6, 'status' => 'Completed'
        ]);
    }

    public function testOrderIsNotUpdatedByNotAdmin(): void
    {
        $this->seed();

        $user = User::where('id', 2)->first();

        $order = Order::where('id', 6)->firstOrFail();

        $response = $this
            ->actingAs($user)
            ->patch(route('orders.update', $order), ['status' => 'Completed']);

        $response->assertStatus(403);
    }

    public function testOrderIsNotUpdatedByGuest(): void
    {
        $this->seed();

        $order = Order::where('id', 7)->firstOrFail();

        $response = $this
            ->patch(route('orders.update', $order), ['status' => 'Completed']);

        $response->assertStatus(403);
    }
}
