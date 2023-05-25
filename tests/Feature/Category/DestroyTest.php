<?php

namespace Tests\Feature\Category;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\CategoriesTableSeeder;
use Database\Seeders\ProductsShortTableSeeder;
use Database\Seeders\RoleAndPermissionSeeder;

class DestroyTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryIsDeletedFromDatabase(): void
    {
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductsShortTableSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $category = Category::where('name', 'Children')->firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->delete(route('category.destroy', $category));

        $response->assertSessionHas('flash_notification.0.message', 'The category has been deleted');
        $this->assertDatabaseMissing('categories', ['name' => 'Children']);
    }

    public function testCategoryIsNotDeletedFromDatabaseWhenRequestedByNotAdmin(): void
    {
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductsShortTableSeeder::class);

        $admin = User::factory()->create();

        $category = Category::where('name', 'Children')->firstOrFail();

        $response = $this
            ->delete(route('category.destroy', $category));

        $response->assertStatus(403);
        $this->assertDatabaseHas('categories', ['name' => 'Children']);
    }

    public function testCategoryWithProductsIsNotDeletedFromDatabase(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $category = Category::where('name', 'Slingbacks')->firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->delete(route('category.destroy', $category));

        $response->assertSessionHas('flash_notification.0.message', 'Impossible! There are some products belonging to this category');   // phpcs:ignore
        $this->assertDatabaseHas('categories', ['name' => 'Slingbacks']);
    }

    public function testNestedBranchIsDeletedFromDatabase(): void
    {
        $this->seed(RoleAndPermissionSeeder::class);
        $this->seed(CategoriesTableSeeder::class);
        $this->seed(ProductsShortTableSeeder::class);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $category = Category::where('name', 'Men')->firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->delete(route('category.destroy', $category));

        $response->assertSessionHas('flash_notification.0.message', 'The category has been deleted');
        $this->assertDatabaseMissing('categories', ['name' => 'Men']);
        $this->assertDatabaseMissing('categories', ['id' => 10]);
        $this->assertDatabaseMissing('categories', ['name' => 'Valenki']);
    }

    public function testNestedBranchWithProductsIsNotDeletedFromDatabase(): void
    {
        $this->seed();

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $category = Category::where('name', 'Women')->firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->delete(route('category.destroy', $category));

        $response->assertSessionHas('flash_notification.0.message', 'Impossible! There are some products belonging to this branch of categories');   // phpcs:ignore
        $this->assertDatabaseHas('categories', ['name' => 'Women']);
    }

    // for the case where only grandchild has a product and blocks deleting
    public function testNestedBranchWithProductsIsNotDeletedFromDatabase2(): void
    {
        $this->seed(RoleAndPermissionSeeder::class);

        Category::create(['name' => 'Women']);
        Category::create(['name' => 'Shoes', 'parent_id' => 1,]);
        Category::create(['name' => 'High heels', 'parent_id' => 2, 'grandparent_id' => 1]);
        Product::create(['name' => 'Some shoes', 'price' => 1234, 'category_id' => 3]);

        $admin = User::factory()->create();
        $admin->assignRole('Admin');

        $category = Category::where('name', 'Women')->firstOrFail();

        $response = $this
            ->actingAs($admin)
            ->delete(route('category.destroy', $category));

        $response->assertSessionHas('flash_notification.0.message', 'Impossible! There are some products belonging to this branch of categories');   // phpcs:ignore
        $this->assertDatabaseHas('categories', ['name' => 'Women']);
    }
}
