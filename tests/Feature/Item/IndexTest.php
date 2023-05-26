<?php

namespace Tests\Feature\Item;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testItemsAreRenderedForAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $item = Product::orderBy('id', 'desc')->first();

        $response = $this
            ->actingAs($admin)
            ->get(route('items.index'));

        $response->assertOk();
        $response->assertSee($item->name);
    }

    public function testItemsAreNotRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('items.index'));

        $response->assertStatus(403);
    }

    public function testItemsAreNotRenderedForGuest(): void
    {
        $this->seed();

        $response = $this
            ->get(route('items.index'));

        $response->assertStatus(403);
    }
}
