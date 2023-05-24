@extends('layouts.main')
@section('content')
    <div class="w-60">
        <h2>List of Orders</h2>
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
                @php $counter = 0; @endphp
                @foreach ($orders as $order)
                    @php $class = $counter % 2 === 0 ? 'table-active' : 'table-default'; @endphp
                    <tr class="{{ $class }} text-center" onclick="window.location='{{ route('orders.show', $order) }}';" style="cursor: pointer; vertical-align:middle;">
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->created_by ? $order->created_by->name : 'guest' }}</td>
                        <td>3</td>
                        <td>99$</td>
                        <td>{{ $order->status }}</td>
                    </tr>
                    @php $counter++; @endphp
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    </div>
@endsection