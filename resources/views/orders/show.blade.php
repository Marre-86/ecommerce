@extends('layouts.main')
@section('content')
    <div class="w-60">
        <div class="card text-white bg-info mb-3" style="width: 24rem; float:left; margin-top:2rem">
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

        <h5 style="clear:both;">List of Products in the Order</h5>
        
        <table class="table table-hover">
            <thead>
                <tr class="text-center" >
                    <th scope="col" style="width:22%">Creation Date</th>
                    <th scope="col" style="width:25%">Created By</th>
                    <th scope="col">Items</th>
                    <th scope="col">Price</th>
                    <th scope="col" style="width:25%">Status</th>
                </tr>
            </thead>
            <tbody>
                        <?php /*    @php $counter = 0; @endphp
                        @foreach ($orders as $order)
                         @php $class = $counter % 2 === 0 ? 'table-active' : 'table-default'; @endphp  */ ?> 
                    <tr class="<?php /* {{ $class }}*/ ?>  text-center" onclick="window.location='{{ route('orders.show', $order) }}';" style="cursor: pointer; vertical-align:middle;">
                        <td></td>
                        <td></td>
                        <td>3</td>
                        <td>99$</td>
                        <td></td>
                    </tr>
                    <?php /*      @php $counter++; @endphp
                         @endforeach */ ?> 
            </tbody>
        </table>
    </div>
@endsection