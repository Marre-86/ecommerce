<?php

namespace Tests\Feature\Item;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testItemIsDeletedFromTheDatabase(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $item = Product::where('category_id', 7)->first();

        $response = $this
            ->actingAs($admin)
            ->delete(route('items.destroy', $item));

        $response->assertRedirectToRoute('items.index');
        $this->assertDatabaseMissing('products', ['id' => $item->id]);
    }

    public function testForbiddenForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $item = Product::where('category_id', 7)->first();

        $response = $this
            ->actingAs($user)
            ->delete(route('items.destroy', $item));

        $response->assertStatus(403);
    }

    public function testForbiddenForGuest(): void
    {
        $this->seed();

        $item = Product::where('category_id', 7)->first();

        $response = $this
            ->delete(route('items.destroy', $item));

        $response->assertStatus(403);
    }
}
