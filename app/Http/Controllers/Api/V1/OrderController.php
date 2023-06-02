<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends BaseController
{
    public function store(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');

        \Cart::session(substr($authorizationHeader, 7));

        $cartItems = \Cart::getContent()->sort();

        if ($cartItems->isEmpty()) {
            return $this->sendError('Bad request.', ['error' => 'The cart is empty'], 400);
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'nullable|min:5|max:16|regex:/^([0-9\(\)\-\+\s])*$/',
            'description' => 'nullable|max:400'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Bad request.', $validator->errors(), 400);
        }

        $input = $request->all();
        $order = new Order();
        $order->fill($input);
        $order->created_by_id = $request->user()->id;
        $order->status = 'Awaiting Confirmation';
        $order->save();

        $productData = $cartItems->mapWithKeys(function ($item) {
            return [$item['id'] => [
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]];
        })->toArray();

        $order->products()->attach($productData);

        $this->formatOrder($order);

        \Cart::clear();

        return $this->sendResponse($order, 'New order has been made successfully.');
    }

    public function index(Request $request)
    {
        if ($request->user()->orders->isEmpty()) {
            return $this->sendResponse([], 'You don\'t have any orders.');
        }

        $orders = Order::where('created_by_id', $request->user()->id)->get();

        $ordersWithoutUpdatedAt = $orders->map(function ($order) {
            $this->formatOrder($order);
            return $order;
        });

        return $this->sendResponse($ordersWithoutUpdatedAt, 'Orders retrieved successfully.');
    }

    public function show(Order $order, Request $request)
    {
        if ($request->user()->id !== $order->created_by_id) {
            return $this->sendError('Forbidden.', ['error' => 'You don\'t have access to this order'], 403);
        }

        $productsInTheOrder = $order->products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->getCategoryNameWithAllParents(),
                'quantity' => $product->pivot->quantity,
                'price' => number_format($product->pivot->price, 2),
                'total_price' => number_format($product->pivot->quantity * $product->pivot->price, 2),
            ];
        });

        $order->makeHidden('products');
        $this->formatOrder($order);
        $orderData = $order->toArray();
        $orderData['products'] = $productsInTheOrder;

        return $this->sendResponse($orderData, 'Order retrieved successfully.');
    }

    public function delete(Order $order, Request $request)
    {
        if ($request->user()->id !== $order->created_by_id) {
            return $this->sendError('Forbidden.', ['error' => 'You don\'t have access to this order'], 403);
        }
        if ($order->status !== 'Awaiting Confirmation') {
            return $this->sendError('Forbidden.', ['error' => 'Order deletion not allowed. The order has been confirmed and cannot be deleted.'], 403);    //   phpcs:ignore               
        }

        $order = Order::findOrFail($order->id);
        $order->products()->detach();
        $order->delete();

        return $this->sendResponse([], 'Order has been successfully deleted.');
    }

    private function formatOrder(Order $order)
    {
        $order['price'] = number_format($order->products()->selectRaw('SUM(order_product.price * order_product.quantity) as total_price')->pluck('total_price')->first(), 2);   //   phpcs:ignore
        $order['items'] = $order->products()->count();
        $order->makeHidden('updated_at');
    }
}
