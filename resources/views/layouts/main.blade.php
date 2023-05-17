<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="csrf-param" content="_token" />

        <title>{{ config('app.name') }}</title>
                <!-- Scripts -->
                @vite(['resources/js/app.js', 'resources/scss/app.scss', 'resources/css/app.css'])
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
                
    </head>
    <body class="container-fluid">
        <div id="app">
            <header class="fixed w-full"  style="position: relative; margin-bottom:1em">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-xxl">
                        <a href="/">
                            <img href="/" src="/pics/manul-shop-logo-sm.png" alt="logo" style="width:6rem;">
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarColor01">
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#">Home
                                        <span class="visually-hidden">(current)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Features</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Separated link</a>
                                    </div>
                                </li>
                            </ul>

                            @if (Route::has('login'))
                                <div class="flex items-center lg:order-2">
                                    @auth
                                        <div class="btn-group dropstart" role="group">
                                            <button id="btnGroupDrop1" type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}</button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="">
                                                <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a>
                                                <a class="dropdown-item" href="{{ route('logout') }}"  data-method="post" rel="nofollow">{{ __('Log Out') }}</a>
                                            </div>
                                        </div>                                        
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                            Log In
                                        </a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}" class="btn btn-outline-primary">
                                                Sign Up
                                            </a>
                                        @endif
                                    @endauth
                                </div>
                            @endif

                        </div>
                    </div>
                </nav>
            </header>

            <div x-data="{ showMessage: true }" x-show="showMessage" x-init="setTimeout(() => showMessage = false, 2500)">
                @if (session()->has('flash_notification'))               
                    <div style="z-index: 3; position: absolute; top: 10%; left: 40%;  width: 30%; text-align: center">
                        @include('flash::message')
                    </div>
                @endif
            </div>

            <div class="container-xxl">
                @yield('content')
            </div>

        </div>
    </body>
</html>