@extends('layouts.main')
@section('content')
    <div class="w-60">
      <div class="card" style="margin-bottom:1rem; min-width:fit-content;">
        <div class="card-header">
            @hasrole('Admin')
                <h3>List of Orders</h3>
            @else
                <h3>Your Orders</h3>
            @endhasrole
        </div>
        <div style="padding: 1rem 0.5rem 0 0.5rem">
          <table class="table table-hover">
            <thead>
                <tr class="text-center" >
                    <th scope="col" style="width:22%">Creation Date</th>
                    <th scope="col" style="width:25%">Created By</th>
                    <th scope="col">Items</th>
                    <th scope="col">Price</th>
                    <th scope="col" style="width:27%">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 0; @endphp
                @foreach ($orders as $order)
                    @php $class = $counter % 2 === 0 ? 'table-active' : 'table-default'; @endphp
                    <tr class="{{ $class }} text-center" onclick="if (!event.target.closest('a')) { window.location='{{ route('orders.show', $order) }}'; }" style="cursor: pointer; vertical-align:middle;">
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->created_by ? $order->created_by->name : 'guest' }}</td>
                        <td>{{ $order->products()->count() }}</td>
                        <td>{{ number_format($order->products()->selectRaw('SUM(order_product.price * order_product.quantity) as total_price')->pluck('total_price')->first(), 2) }} $
                        </td>
                        <td>
                            <div class="d-flex justify-content-between" >
                                {{ $order->status }}
                                @unlessrole('Admin')
                                  @if ($order->status === 'Awaiting Confirmation')
                                    <div class="button-group d-flex">
                                        <a class="btn btn-outline-danger btn-sm" href="{{ route('orders.destroy', $order) }}" data-confirm="Are you sure?" data-method="delete" rel="nofollow">X</a>
                                    </div>
                                  @endif
                                @endunlessrole
                            </div>
                        </td>
                    </tr>
                    @php $counter++; @endphp
                @endforeach
            </tbody>
          </table>
          {{ $orders->links() }}
        </div>
      </div>
    </div>
@endsection