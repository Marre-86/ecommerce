<?php

namespace Tests\Feature\Item;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditTest extends TestCase
{
    use RefreshDatabase;

    public function testEditFormIsRenderedForAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $item = Product::where('category_id', 7)->first();

        $response = $this
            ->actingAs($admin)
            ->get(route('items.edit', $item));

        $response->assertOk();
        $response->assertSee('<option value="7" selected>......Women/Shoes/Mules</option>', false);
    }

    public function testCreationFormIsNotRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $item = Product::where('category_id', 7)->first();

        $response = $this
            ->actingAs($user)
            ->get(route('items.edit', $item));

        $response->assertStatus(403);
    }

    public function testCreationFormIsNotRenderedForGuest(): void
    {
        $this->seed();

        $item = Product::where('category_id', 7)->first();

        $response = $this
            ->get(route('items.edit', $item));

        $response->assertStatus(403);
    }
}
