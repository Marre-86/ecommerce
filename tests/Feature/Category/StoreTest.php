<?php

namespace Tests\Feature\Category;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryIsStoredIntoDatabase(): void
    {
        $this->seed();

        $response = $this
            ->post(route('category.store'), ['name' => 'valerra', 'parent_id' => '4']);

        $this->assertDatabaseHas('categories', [
            'name' => 'valerra', 'parent_id' => 4, 'grandparent_id' => 1
        ]);
    }
}
