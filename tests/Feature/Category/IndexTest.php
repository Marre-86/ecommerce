<?php

namespace Tests\Feature\Category;

use App\Models\Category;
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

        $response = $this
            ->get(route('category.index'));

        $response->assertSee('<option value="">Select Parent Category</option>', $escaped = false);
    }
}
