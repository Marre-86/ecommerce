@extends('layouts.main')
@section('content')
    <div class="cart">
        <h2>Your Cart</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col" style="text-align:center; width:60%">Name</th>
                    <th scope="col" style="text-align:center">Quantity</th>
                    <th scope="col">Price</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                <tr class="table-active" style="vertical-align:middle;">
                    <th scope="row">{{ $item->name }}</th>
                    <td>
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $item->id}}" >
                            <input type="number" min="0" max="10"  name="quantity" value="{{ $item->quantity }}" 
                                    class="form-control form-control-sm" style="float:left; width:3.2rem;"/>
                            <button type="submit" class="btn btn-outline-success btn-sm" style="margin-left:0.5rem">
                                update
                            </button>
                        </form>
                    </td>
                    <td>{{ $item->price }} $</td>
                    <td>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" name="id">
                            <button class="btn btn-outline-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        <table>
        <div style="float:left" >
            <p class="text-primary">Total Price: <b>${{ Cart::getTotal() }}</b></p>
        </div>
        @if (\Cart::getContent()->count() > 1)
        <div style="float:right; margin-top: -8px; margin-right:14px;" >
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button class="btn btn-outline-danger btn-sm" data-confirm="Are you sure?">Remove all</button>
            </form>
        </div>
        @endif

        <div style="clear:both">
            @include('components.make-order-form')
        </div>

    </div>
@endsection