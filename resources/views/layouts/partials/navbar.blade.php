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