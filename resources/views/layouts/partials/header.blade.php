<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom mb-3">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">Jasikos</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            {{-- Left: primary nav --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                        href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('designs.*') ? 'active' : '' }}"
                        href="{{ route('designs.index') }}">Catalog</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                        href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                        href="{{ url('/contact') }}">Contact</a></li>
            </ul>

            {{-- Middle: search (optional) --}}
            <form class="d-flex me-2" method="GET" action="{{ route('designs.index') }}">
                <input class="form-control" type="search" name="q" placeholder="Cari desain..."
                    value="{{ request('q') }}">
            </form>

            {{-- Right: auth-aware --}}
            @guest
                <div class="d-flex gap-2">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                </div>
            @else
                @if (auth()->user()->role === 'customer')
                    <a href="{{ route('customer.cart.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                        <i class="fas fa-shopping-cart"></i> Cart
                    </a>
                @endif

                <div class="dropdown">
                    <button class="btn btn-light border dropdown-toggle btn-sm" data-bs-toggle="dropdown">
                        {{ auth()->user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @if (auth()->user()->role === 'designer')
                            <li><a class="dropdown-item" href="{{ route('designer.dashboard') }}">Designer Dashboard</a>
                            </li>
                        @elseif(auth()->user()->role === 'customer')
                            <li><a class="dropdown-item" href="{{ route('customer.dashboard') }}">Customer Dashboard</a>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/request-custom') }}">Request Custom</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.orders.index') }}">Orders</a></li>
                        @elseif(auth()->user()->role === 'admin')
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Admin</a></li>
                        @endif
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</nav>
