@extends('layouts.main')
@section('content')
    <div class="w-60">
        <div class="card border-primary mb-3" style="max-width:30rem; float:left; margin-top:2rem">
            <div class="card-header">ID #{{ $item->id }}</div>
            <div class="card-body">
                <p class="card-text"><b>Name: </b>
                    {{ $item->name }}</p>
                <p class="card-text"><b>Category: </b>
                    {{ $item->getCategoryNameWithAllParents() }}</p>
                <p class="card-text"><b>Price: </b>
                    {{ $item->price }}</p>
                <p class="card-text"><b>Description: </b>
                    {{ $item->description }}</p>
                <p class="card-text"><b>Weight: </b>
                    {{ $item->weight }}</p>
                <p class="card-text"><b>Length: </b>
                    {{ $item->length }}</p>
                <p class="card-text"><b>Width: </b>
                    {{ $item->width }}</p>
                <p class="card-text"><span style="color:#495057"><b>Creation Date: </b></span>
                    {{ $item->created_at }}</p>
                <p class="card-text"><span style="color:#495057"><b>Update Date: </b></span>
                    {{ $item->updated_at }}</p>
            </div>
        </div>
        <div class="card" style="width: 17rem;  float:left; margin:2rem 0 0 1rem;">
            <div class="card-body">
                <img src="{{ asset('storage/images/'.$item->image) }}" class="img-card">
            </div>
        </div>
    </div>
@endsection