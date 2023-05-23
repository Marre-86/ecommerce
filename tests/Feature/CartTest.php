<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testEmptyCartIsRedirected(): void
    {
        $this->seed();

        $response = $this
            ->get(route('cart.list'));

        $response->assertRedirect('/products');
    }

    public function testCartIsRenderedWhenProductAdded(): void
    {
        $this->seed();

        $product = [ 'id' => 9, 'name' => 'Slocyclub Flat Mules', 'price' => 33.99, 'quantity' => 1];

        $response = $this
            ->followingRedirects()
            ->post(route('cart.store', $product));

        $response->assertSee('<p class="text-primary">Total Price: <b>$33.99</b></p>', $escaped = false);
    }

    public function testCartIsUpdated(): void
    {
        $this->seed();

        $product = [ 'id' => '9', 'name' => 'Slocyclub Flat Mules', 'price' => 33.99, 'quantity' => 1];

        $this->post(route('cart.store', $product));

        $updatedQuantity = [ 'id' => 9, 'quantity' => 3];

        $response = $this
            ->followingRedirects()
            ->post(route('cart.update', $updatedQuantity));

        $response->assertSee('<p class="text-primary">Total Price: <b>$101.97</b></p>', $escaped = false);
    }
    public function testItemIsRemovedFromTheCart(): void
    {
        $this->seed();

        $product1 = [ 'id' => '9', 'name' => 'Slocyclub Flat Mules', 'price' => 33.99, 'quantity' => 1];
        $product2 = [ 'id' => '15', 'name' => 'Dress the Population Women\'s Dress', 'price' => 248, 'quantity' => 1];

        $this->post(route('cart.store', $product1));
        $this->post(route('cart.store', $product2));

        $this->assertEquals(2, (\Cart::getContent()->count()));

        $response = $this
            ->followingRedirects()
            ->post(route('cart.remove', ['id' => 9]));

        $this->assertEquals(1, (\Cart::getContent()->count()));
        $response->assertSee('<p class="text-primary">Total Price: <b>$248</b></p>', $escaped = false);
    }
    public function testAllItemsAreRemovedFromTheCart(): void
    {
        $this->seed();

        $product1 = [ 'id' => '9', 'name' => 'Slocyclub Flat Mules', 'price' => 33.99, 'quantity' => 1];
        $product2 = [ 'id' => '15', 'name' => 'Dress the Population Women\'s Dress', 'price' => 248, 'quantity' => 1];

        $this->post(route('cart.store', $product1));
        $this->post(route('cart.store', $product2));

        $response = $this
            ->post(route('cart.clear'));

        $this->assertEquals(0, (\Cart::getContent()->count()));
        $response->assertRedirect('/products');
    }
}
