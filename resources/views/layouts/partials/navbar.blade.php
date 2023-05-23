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
                                    <a class="nav-link {{ (Route::current()->getName() == 'category.index') ? 'active' : '' }}" href="{{ route('category.index') }}">Manager Cat
                                        <span class="visually-hidden">(current)</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ (Route::current()->getName() == 'prodlist') ? 'active' : '' }}" href="{{ route('prodlist') }}">Products</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Categories</a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        @foreach ($categories as $category)
                                            <li>
                                                <a class="dropdown-item" {{ $category->products->isNotEmpty() ? 'href=products?filter[category_id]=' . $category->id : 'href=#' }}>{{ $category->children->isNotEmpty() ? $category->name . html_entity_decode(" &raquo;") : $category->name }}</a>
                                                @if ($category->children->isNotEmpty())
                                                    <ul class="dropdown-menu dropdown-submenu">
                                                        @foreach ($category->children as $child)
                                                            <li>
                                                                <a class="dropdown-item" {{ $child->products->isNotEmpty() ? 'href=products?filter[category_id]=' . $child->id : 'href=#' }}>{{ $child->children->isNotEmpty() ? $child->name . html_entity_decode(" &raquo;") : $child->name }}</a>
                                                                @if ($child->children->isNotEmpty())
                                                                    <ul class="dropdown-menu dropdown-submenu">
                                                                        @foreach ($child->children as $grandchild)
                                                                            <li>
                                                                                <a class="dropdown-item" {{ $grandchild->products->isNotEmpty() ? 'href=products?filter[category_id]=' . $grandchild->id : 'href=#' }}>{{ $grandchild->name }}</a>
                                                                            </li>
                                                                            @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                            @if  (\Cart::getContent()->isNotEmpty())
                                <a href="/cart" style="margin-right:1rem">
                                <button type="button" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                    </svg>
                                    Cart ({{ \Cart::getContent()->count() }})
                                </button></a>
                            @endif

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