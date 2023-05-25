<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoriesAreRenderedForAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $category = Category::firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->get(route('category.index'));

        $response->assertSee($category->name);
    }

    public function testCategoriesAreNotRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $category = Category::firstOrFail();

        $response = $this
            ->actingAs($user)
            ->get(route('category.index'));

        $response->assertStatus(403);
    }

    public function testCreateFormIsRendered(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this
            ->actingAs($admin)
            ->get(route('category.index'));

        $response->assertSee('<option value="">Select Parent Category</option>', $escaped = false);
    }

    public function testCreateFormIsNotRenderedForGuest(): void
    {
        $this->seed();

        $response = $this
            ->get(route('category.index'));

        $response->assertDontSee('<option value="">Select Parent Category</option>', $escaped = false);
    }
}
