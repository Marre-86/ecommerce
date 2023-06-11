<?php

namespace Tests\Feature\Item;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake();

        $this->app->bind('filesystem', function ($app) {
            return Storage::disk('test_disk');
        });
    }

    public function testItemIsDeletedFromTheDatabase(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $item = Product::find(24);

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

        $item = Product::find(24);

        $response = $this
            ->actingAs($user)
            ->delete(route('items.destroy', $item));

        $response->assertStatus(403);
    }

    public function testForbiddenForGuest(): void
    {
        $this->seed();

        $item = Product::find(24);

        $response = $this
            ->delete(route('items.destroy', $item));

        $response->assertStatus(403);
    }

    public function testItemThatWasOrderedCannotBeDeleted(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $item = Product::has('orders')->first();

        $response = $this
            ->actingAs($admin)
            ->delete(route('items.destroy', $item));

        $response->assertRedirectToRoute('items.index');
        $response->assertSessionHas('flash_notification.0.message', 'Item can\'t be deleted because it has been ordered at least once!');   //   phpcs:ignore
        $this->assertDatabaseHas('products', ['id' => $item->id]);
    }
}
