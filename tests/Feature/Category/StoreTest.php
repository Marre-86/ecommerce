<?php

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryIsStoredIntoDatabaseWhenSentByAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this
            ->actingAs($admin)
            ->post(route('category.store'), ['name' => 'valerra', 'parent_id' => '4']);

        $this->assertDatabaseHas('categories', [
            'name' => 'valerra', 'parent_id' => 4, 'grandparent_id' => 1
        ]);
    }

    public function testCategoryCannotBeSentByNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('category.store'), ['name' => 'valerra', 'parent_id' => '4']);

        $this->assertDatabaseMissing('categories', [
            'name' => 'valerra', 'parent_id' => 4, 'grandparent_id' => 1
        ]);

        $response->assertStatus(403);
    }

    public function testCategoryCannotBeSentByGuest(): void
    {
        $this->seed();

        $response = $this
            ->post(route('category.store'), ['name' => 'valerra', 'parent_id' => '4']);

        $this->assertDatabaseMissing('categories', [
            'name' => 'valerra', 'parent_id' => 4, 'grandparent_id' => 1
        ]);

        $response->assertStatus(403);
    }
}
