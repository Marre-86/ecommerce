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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $order = new Order();

        $data = $this->validate($request, [
            'phone' => 'nullable|min:5|max:16|regex:/^([0-9\-\+])*$/',
            'description' => 'nullable']);
        $order->fill($data);
        $order->status = 'Awaiting Confirmation';
        if (Auth::check()) {
            $order->created_by_id = intval(Auth::id());
        }
        $order->save();

        \Cart::clear();

        flash('Order has been successfully created!')->success();
        return redirect()->route('prodlist');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
