<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user() === null) {
            abort(403);
        }
        if (Auth::user()->hasRole('Admin')) {
            $orders = Order::orderBy('id', 'desc')->paginate(5);
        } else {
            $orders = Order::where('created_by_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(5);
        }

        return view('orders.index', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new Order();

        $data = $this->validate($request, [
            'phone' => 'nullable|min:5|max:16|regex:/^([0-9\(\)\-\+\s])*$/',
            'description' => 'nullable|max:400']);
        $order->fill($data);
        $order->status = 'Awaiting Confirmation';
        if (Auth::check()) {
            $order->created_by_id = intval(Auth::id());
        }
        $order->save();

        \Cart::clear();

        $order->products()->attach($request->input('items'));

        flash('Order has been successfully created!')->success();

        if (Auth::user() === null) {
            return redirect()->route('prodlist');
        }

        return redirect()->route('orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $orderCreatorId = $order->created_by->id ?? 0;
        if ((Auth::user() === null) or ((Auth::id() !== $orderCreatorId) && (!Auth::user()->hasRole('Admin')))) {
            abort(403);
        }
        $order = Order::findOrFail($order->id);
        return view('orders.show', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $order->status = $request->input('status');
        $order->save();

        return redirect()->route('orders.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        if ((Auth::user() === null) or (Auth::id() !== $order->created_by->id) or ($order->status !== 'Awaiting Confirmation')) {   // phpcs:ignore
            abort(403);
        }
        $order = Order::findOrFail($order->id);
        $order->products()->detach();
        $order->delete();

        flash('Order has been successfully deleted!')->success();
        return redirect()->route('orders.index');
    }
}
