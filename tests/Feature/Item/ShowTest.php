<?php

namespace Tests\Feature\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use RefreshDatabase;

    public function testItemIsRenderedForAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $item = Product::first();

        $response = $this
            ->actingAs($admin)
            ->get(route('items.show', $item));

        $response->assertOk();
        $response->assertSee($item->name);
    }

    public function testItemIsNotRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $item = Product::first();

        $response = $this
            ->actingAs($user)
            ->get(route('items.index', $item));

        $response->assertStatus(403);
    }

    public function testItemIsNotRenderedForGuest(): void
    {
        $this->seed();

        $item = Product::first();

        $response = $this
            ->get(route('items.index', $item));

        $response->assertStatus(403);
    }
}
