<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoriesAreRendered(): void
    {
        $this->seed();

        $category = Category::firstOrFail();

        $response = $this
            ->get(route('category.index'));

        $response->assertSee($category->name);
    }

    public function testCreateFormIsRendered(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
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
