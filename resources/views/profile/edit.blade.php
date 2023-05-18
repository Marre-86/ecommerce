@extends('layouts.main')
@section('content')
    <div class="col-md-3" style="float:left">
        <div class="card">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>
    <div class="col-md-3" style="float:left; margin-left:2em">
        <div class="card">
            @include('profile.partials.update-password-form')
        </div>
    </div>
    <div class="col-md-3" style="float:left; margin-left:2em">
        <div class="card">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection
