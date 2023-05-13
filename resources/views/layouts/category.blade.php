<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-param" content="_token" />

        <title>{{ config('app.name') }}</title>
                <!-- Scripts -->
                @vite(['resources/js/app.js', 'resources/scss/app.scss'])
    </head>
    <body class="container-fluid">
        <div id="app">
            <div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 2200)">
                @if (session()->has('flash_notification'))               
                    <div style="position: absolute; top: 45%; left: 40%;  width: 30%; text-align: center">
                        @include('flash::message')
                    </div>
                @endif
            </div>

            @yield('content')

        </div>
    </body>
</html>