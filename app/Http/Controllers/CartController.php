<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cartList()
    {

        $cartItems = \Cart::getContent()->sort();

        $itemsToAttachToOrder = [];
        foreach ($cartItems as $cartItem) {
            $itemToAttachToOrderId = $cartItem->id;
            $itemToAttachToOrderData = ['quantity' => $cartItem->quantity, 'price' => $cartItem->price,];
            $itemsToAttachToOrder[$itemToAttachToOrderId] = $itemToAttachToOrderData;
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('prodlist');
        }
        return view('cart', ['cartItems' => $cartItems, 'itemsToAttachToOrder' => $itemsToAttachToOrder]);
    }


    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);

        flash('Product is added to cart successfully!')->success();
        return redirect()->route('cart.list');
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        return redirect()->route('prodlist');
    }
}
