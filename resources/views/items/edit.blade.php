@extends('layouts.main')
@section('content')
    <div class="w-60">
      <div class="card" style="margin-bottom:1rem; min-width:28rem;">
        <div class="card-header">
            <h3>Edit Item</h3>
        </div>

        <div class="card-body">
            {{ Form::model($item, ['route' => ['items.update', $item], 'method' => 'PATCH', 'files' => true]) }}
                @include('items.form')
                <div class="mt-2">
                    {{ Form::submit('Update Item', ['class' => 'btn btn-primary']) }}
                </div>
            {{ Form::close() }}
        </div>

      </div>
    </div>
@endsection