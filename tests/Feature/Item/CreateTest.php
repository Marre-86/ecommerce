<?php

namespace Tests\Feature\Item;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateTest extends TestCase
{
    use RefreshDatabase;

    public function testCreationFormIsRenderedForAdmin(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $response = $this
            ->actingAs($admin)
            ->get(route('items.create'));

        $response->assertOk();
        $response->assertSee('<option value="9">......Women/Shoes/Winklepickers</option>', false);
    }

    public function testCreationFormIsNotRenderedForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('items.create'));

        $response->assertStatus(403);
    }

    public function testCreationFormIsNotRenderedForGuest(): void
    {
        $this->seed();

        $response = $this
            ->get(route('items.create'));

        $response->assertStatus(403);
    }
}
