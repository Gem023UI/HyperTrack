<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}"><i class="fas fa-home me-1"></i> Home</a>
                            </li>
                            <!-- Orders Navigation Link -->
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('orders.index') }}"><i class="fas fa-shopping-bag me-1"></i> My Orders</a>
                            </li>
                            @if(auth()->user()->is_admin)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Admin Dashboard</a>
                                </li>
                                <!-- Admin Orders Management Link -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.orders') }}"><i class="fas fa-clipboard-list me-1"></i> Manage Orders</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Cart Button -->
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('cart.index') }}">
                                    <i class="fas fa-shopping-cart me-1"></i> Cart
                                </a>
                            </li>
                        @endauth

                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i> {{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i> {{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/'.Auth::user()->profile_picture) }}" 
                                             class="rounded-circle me-2" 
                                             width="32" 
                                             height="32"
                                             alt="Profile Picture">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-2" 
                                             style="width: 32px; height: 32px;">
                                            <span class="text-white small">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.show') }}">
                                        <i class="fas fa-user-circle me-2"></i> View Profile
                                    </a>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-cog me-2"></i> Edit Profile
                                    </a>
                                    <!-- Orders Option in Dropdown -->
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-shopping-bag me-2"></i> My Orders
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>