@extends('layouts.main')
@section('content')
    <div class="w-80">
      <div class="card" style="margin-bottom:1rem; min-width:fit-content;">
        <div class="card-header">
            <h3>Products</h3>
        </div>
        <div style="padding: 1rem 0.5rem 0 0.5rem">

          <div style="float:right; margin-bottom: 1rem">
            <a href="{{ route('items.create') }}">
                <button type="button" class="btn btn-success">Create Item</button>
            </a>
          </div>

          <table class="table table-hover">
            <thead>
                <tr class="text-center" >
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Category</th>
                    <th scope="col">Price</th>
                    <th scope="col">Weight</th>
                    <th scope="col">Length</th>
                    <th scope="col">Width</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @php $counter = 0; @endphp
                @foreach ($items as $item)
                    @php $class = $counter % 2 === 0 ? 'table-light' : 'table-default'; @endphp
                    <tr class="{{ $class }} text-center" onclick="if (!event.target.closest('a')) { window.location='{{ route('items.show', $item) }}'; }" style="cursor: pointer; vertical-align:middle;">
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->getCategoryNameWithAllParents() }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->weight }}</td>
                        <td>{{ $item->length }}</td>
                        <td>{{ $item->width }}</td>
                        <td>
                          <div class="button-group d-flex">
                            <a class="btn btn-outline-success btn-sm" href="{{ route('items.edit', $item) }}">edit</a>
                          </div>
                        </td>
                        <td>
                          <div class="button-group d-flex">
                            <a class="btn btn-outline-danger btn-sm" href="{{ route('items.destroy', $item) }}" data-confirm="Are you sure?" data-method="delete" rel="nofollow">X</a>
                          </div>
                        </td>
                    </tr>
                    @php $counter++; @endphp
                @endforeach
            </tbody>
          </table>
          {{ $items->links() }}
        </div>
      </div>
    </div>
@endsection