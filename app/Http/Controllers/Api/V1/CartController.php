<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends BaseController
{
    public function cartList(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');

        \Cart::session(substr($authorizationHeader, 7));

        $cartItems = \Cart::getContent()->sort();

        if ($cartItems->isEmpty()) {
            return $this->sendResponse($cartItems, 'Cart is empty.');
        }

        return $this->sendResponse($cartItems, 'Cart content retrieved successfully.');
    }

    public function addToCart(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$request->has('id')) {
            return $this->sendError('Bad request.', ['error' => 'ID of the product should be specified'], 400);
        }

        try {
            $item = Product::findOrFail($request->input('id'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return $this->sendError('Bad request.', ['error' => 'The product with requested id doesn\'t exist'], 400);   // phpcs:ignore
        }

        \Cart::session(substr($authorizationHeader, 7));

        \Cart::add([
            'id' => $item->id,
            'name' => $item->name,
            'price' => $item->price,
            'quantity' => $request->input('quantity') ?? 1,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);

        $cartItems = \Cart::getContent()->sort();

        return $this->sendResponse($cartItems, 'Product has been added to cart successfully.');
    }

    public function updateCart(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');
        \Cart::session(substr($authorizationHeader, 7));

        if (!$request->has('id')) {
            return $this->sendError('Bad request.', ['error' => 'ID of the updated product should be specified'], 400);
        }

        $updatedItem = \Cart::get($request->input('id'));
        if ($updatedItem === null) {
            return $this->sendError('Bad request.', ['error' => 'Product with requested id is not found in the Cart'], 400);   // phpcs:ignore
        }

        if (!$request->has('quantity')) {
            return $this->sendError('Bad request.', ['error' => 'New quantity of updated product should be specified'], 400);    // phpcs:ignore
        }

        if ($request->input('quantity') === 0) {
            \Cart::remove($updatedItem->id);
        } else {
            \Cart::update(
                $updatedItem->id,
                [
                    'quantity' => [
                        'relative' => false,
                        'value' => $request->input('quantity')
                    ],
                ]
            );
        }

        $cartItems = \Cart::getContent()->sort();

        return $this->sendResponse($cartItems, 'Product has been updated in the cart successfully. Updated cart is returned');   // phpcs:ignore
    }

    public function removeProduct(Product $item, Request $request)
    {
        $authorizationHeader = $request->header('Authorization');
        \Cart::session(substr($authorizationHeader, 7));

        $removedItem = \Cart::get($item->id);
        if ($removedItem === null) {
            return $this->sendError('Bad request.', ['error' => 'Product with requested id is not found in the Cart'], 400);   // phpcs:ignore
        }

        \Cart::remove($removedItem->id);

        $cartItems = \Cart::getContent()->sort();

        return $this->sendResponse($cartItems, 'Product has been deleted from the cart successfully. Updated cart is returned');   // phpcs:ignore
    }
}
