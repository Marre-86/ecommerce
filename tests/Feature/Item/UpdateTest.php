<?php

namespace Tests\Feature\Item;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;

class UpdateTest extends TestCase
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

    public function testItemIsUpdatedInTheDatabase(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $item = Product::where('category_id', 7)->first();

        $paramsForUpdate = [
            'name' => 'Ubuntu Windows',
            'category_id' => 4,
            'price' => 99.04
        ];

        $response = $this
            ->actingAs($admin)
            ->patch(route('items.update', $item), $paramsForUpdate);

        $response->assertRedirectToRoute('items.index');

        $itemUpdated = Product::where('id', $item->id)->first();

        $this->assertEquals($paramsForUpdate['name'], $itemUpdated->name);
        $this->assertEquals($paramsForUpdate['category_id'], $itemUpdated->category_id);
        $this->assertEquals($paramsForUpdate['price'], $itemUpdated->price);
    }

    public function testItemDeclinedWhenInvalidInput(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $item = Product::where('category_id', 7)->first();

        $paramsForUpdate = [
            'name' => 'Ub',
        ];

        $response = $this
            ->actingAs($admin)
            ->patch(route('items.update', $item), $paramsForUpdate);

        $response->assertInvalid(['name', 'category_id', 'price']);
        $this->assertDatabaseMissing('products', $paramsForUpdate);
    }

    public function testForbiddenForNotAdmin(): void
    {
        $this->seed();

        $user = User::factory()->create();

        $item = Product::where('category_id', 7)->first();

        $paramsForUpdate = [
            'name' => 'Ubuntu Windows',
            'category_id' => 4,
            'price' => 99.04
        ];

        $response = $this
            ->actingAs($user)
            ->patch(route('items.update', $item), $paramsForUpdate);

        $response->assertStatus(403);
    }

    public function testForbiddenForGuest(): void
    {
        $this->seed();

        $item = Product::where('category_id', 7)->first();

        $paramsForUpdate = [
            'name' => 'Ubuntu Windows',
            'category_id' => 4,
            'price' => 99.04
        ];

        $response = $this
            ->patch(route('items.update', $item), $paramsForUpdate);

        $response->assertStatus(403);
    }
}
