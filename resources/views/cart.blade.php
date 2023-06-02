@extends('layouts.main')
@section('content')
    <div class="w-60">
      <div class="card" style="margin-bottom:1rem; min-width:fit-content;">
        <div class="card-header">
            <h3>Your Cart</h3>
        </div>
        @guest            
            <div class="alert alert-dismissible alert-secondary">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                We recommend you to  <a href="/register" class="alert-link">register</a> on this app in order to get access to the history of your orders.
            </div>
        @endguest
        <div style="padding: 1rem 0.5rem 0 0.5rem">

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
                <tr class="table-primary" style="vertical-align:middle;">
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
          </table>
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

          <div style="clear:both; margin-bottom:1rem;">
            @include('components.make-order-form')
          </div>
        </div>
      </div>
    </div>
@endsection