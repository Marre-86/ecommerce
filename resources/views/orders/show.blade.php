@extends('layouts.main')
@section('content')
    <div class="w-80">
        <div class="card text-white bg-info mb-3" style="width: {{ auth()->user()->hasRole('Admin') ? '24rem' : '18rem' }}; float:left; margin-top:2rem">
            <div class="card-header">Order #{{ $order->id }}</div>
            <div class="card-body">
                <p class="card-text"><span style="color:#495057">Created By: </span>
                    {{ $order->created_by ? $order->created_by->name : 'guest' }}</p>
                <p class="card-text"><span style="color:#495057">Creation Date: </span>
                    {{ $order->created_at }}</p>
                <p class="card-text" style="float:left; margin-right:1rem"><span style="color:#495057">Status: </span>
                  @hasrole('Admin')
                    <form action="{{ route('orders.update', $order) }}" method="post">
                            @method('PATCH')           
                            @csrf                            
                            <select class="form-select" style="width:fit-content; float:left; margin-top:-0.5rem" name="status">
                                <option {{ ($order->status === 'Awaiting Confirmation' ) ? 'selected' : '' }}>Awaiting Confirmation</option>
                                <option {{ ($order->status === 'Order Confirmed' ) ? 'selected' : '' }}>Order Confirmed</option>
                                <option {{ ($order->status === 'Shipped' ) ? 'selected' : '' }}>Shipped</option>
                                <option {{ ($order->status === 'Awaiting Pickup' ) ? 'selected' : '' }}>Awaiting Pickup</option>
                                <option {{ ($order->status === 'Completed' ) ? 'selected' : '' }}>Completed</option>
                                <option {{ ($order->status === 'Cancelled' ) ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="btn btn-secondary btn-sm" style="margin-left:0.5rem">
                                update
                            </button>
                    </form></p>
                  @else
                    {{ $order->status }}</p>
                  @endhasrole
                <p class="card-text" style="clear:both"><span style="color:#495057">Contact Phone: </span>
                    {{ $order->phone ? $order->phone : '' }}</p>
            </div>
        </div>
        @if ($order->description)
        <div class="card border-info mb-3" style="width: 23rem;  float:left; margin:2rem 0 0 1rem;">
            <div class="card-header">Description</div>
            <div class="card-body">
                <p class="card-text">{{ $order->description }}</p>
            </div>
        </div>
        @endif


        <div class="card" style="margin-bottom:1rem; min-width:fit-content;clear:both">
            <div class="card-header">
                <h5 style="clear:both;">List of Products in the Order</h5>
            </div>
            <div style="padding: 1rem 0.5rem 0 0.5rem">

        
        <table class="table table-hover">
            <thead>
                <tr class="text-center" style="vertical-align: middle">
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total Price</th>
                </tr>
            </thead>
            <tbody>
                        @foreach ($order->products as $product)
                    <tr class="table-secondary text-center" style="vertical-align: middle">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->getCategoryNameWithAllParents() }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td style="white-space: nowrap;">{{ number_format($product->pivot->price, 2) }} $</td>
                        <td style="white-space: nowrap;">{{ number_format($product->pivot->quantity * $product->pivot->price, 2) }} $</td>
                    </tr>
                         @endforeach
                    <tr class="table-active text-center" style="vertical-align: middle; font-weight: bold">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total Cost:</td>
                        <td style="white-space: nowrap;">{{ number_format($order->products()->selectRaw('SUM(order_product.price * order_product.quantity) as total_price')->pluck('total_price')->first(), 2) }} $</td>
                    </tr>
            </tbody>
        </table>
        </div></div>
    </div>
@endsection