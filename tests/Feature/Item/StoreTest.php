<?php

namespace Tests\Feature\Item;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function testItemIsStoredIntoDatabase(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $data = [
            'name' => 'Ubuntu Windows',
            'category_id' => 4,
            'price' => 99.04
        ];

        $response = $this
            ->actingAs($admin)
            ->post(route('items.store', $data));

        $response->assertRedirectToRoute('items.index');
        $this->assertDatabaseHas('products', $data);
    }

    public function testItemDeclinedWhenNameIsTheSame(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $data1 = [
            'name' => 'Ubuntu Windows',
            'category_id' => 4,
            'price' => 99.04
        ];

        $this->actingAs($admin)
            ->post(route('items.store', $data1));

        $data2 = [
            'name' => 'Ubuntu Windows',
            'category_id' => 7,
            'price' => 14.04
        ];

        $response = $this
            ->actingAs($admin)
            ->post(route('items.store', $data2));

        $response->assertInvalid(['name']);
        $this->assertDatabaseMissing('products', $data2);
    }

    public function testItemDeclinedWhenInvalidInput(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $data = [
            'name' => 'Ub',
        ];

        $response = $this
            ->actingAs($admin)
            ->post(route('items.store', $data));

        $response->assertInvalid(['name', 'category_id', 'price']);
        $this->assertDatabaseMissing('products', $data);
    }

    public function testForbiddenForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $data = [
            'name' => 'Ubuntu Windows',
            'category_id' => 4,
            'price' => 99.04
        ];

        $response = $this
            ->actingAs($user)
            ->post(route('items.store', $data));

        $response->assertStatus(403);
        $this->assertDatabaseMissing('products', $data);
    }

    public function testForbiddenForGuest(): void
    {
        $this->seed();

        $data = [
            'name' => 'Ubuntu Windows',
            'category_id' => 4,
            'price' => 99.04
        ];

        $response = $this
            ->post(route('items.store', $data));

        $response->assertStatus(403);
        $this->assertDatabaseMissing('products', $data);
    }
}
