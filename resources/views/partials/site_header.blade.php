{{-- resources/views/partials/site_header.blade.php --}}
@php
    // aman untuk guest
    $isCatalog = request()->routeIs('designs.*');
    $q = request('q');
@endphp

<div id="site-navbar-wrap" class="sticky-top py-3 bg-transparent">
    <div class="container">
        <nav id="site-navbar" class="navbar navbar-expand-lg navbar-light bg-white border shadow-sm rounded-4 px-3"
            aria-label="Main navigation">

            {{-- Brand --}}
            <a class="navbar-brand fw-semibold me-3" href="{{ route('home') }}">Jasikos</a>

            {{-- Toggler --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
                aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMain">
                {{-- Left menu --}}
                <ul class="navbar-nav me-3">
                    <li class="nav-item">
                        <a class="nav-link {{ $isCatalog ? 'active' : '' }}" href="{{ route('designs.index') }}"
                            @if ($isCatalog) aria-current="page" @endif>
                            Katalog
                        </a>
                    </li>

                    {{-- Dropdown Kategori --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ $isCatalog && request('category') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kategori
                        </a>
                        <ul class="dropdown-menu">
                            @foreach ($headerCategories ?? [] as $c)
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('designs.index', ['category' => $c->slug]) }}">
                                        {{ $c->name }}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('designs.index') }}">Lihat semua</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="https://wa.me/62895626141738" target="_blank"
                            rel="noopener">Contact</a>
                    </li>
                </ul>

                {{-- Search (desktop) --}}
                <form class="d-none d-lg-flex ms-auto me-3" method="GET" action="{{ route('designs.index') }}"
                    role="search">
                    <input class="form-control me-2" type="search" name="q" value="{{ $q }}"
                        placeholder="Cari desain..." />
                    <button class="btn btn-outline-primary" type="submit">Cari</button>
                </form>

                {{-- Right actions --}}
                <ul class="navbar-nav align-items-lg-center">
                    @auth
                        @php
                            $user = auth()->user();
                            $role = $user->role ?? null;

                            $dash =
                                $role === 'admin'
                                    ? route('admin.dashboard')
                                    : ($role === 'designer'
                                        ? route('designer.dashboard')
                                        : route('customer.dashboard'));

                            $cartCount =
                                $role === 'customer'
                                    ? optional(optional($user->customer)->cart)
                                            ->items()
                                            ->count() ?? 0
                                    : 0;
                        @endphp

                        @if ($role === 'customer')
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-secondary position-relative"
                                    href="{{ route('customer.cart.index') }}" aria-label="Keranjang">
                                    <i class="fas fa-shopping-cart"></i>
                                    @if ($cartCount > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ $cartCount }}
                                        </span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="btn btn-primary" href="{{ route('customer.custom-requests.create') }}">Buat
                                    Custom</a>
                            </li>
                        @endif

                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary" href="{{ $dash }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth

                    {{-- Search (mobile) --}}
                    <li class="nav-item d-lg-none mt-3">
                        <form class="d-flex" method="GET" action="{{ route('designs.index') }}" role="search">
                            <input class="form-control me-2" type="search" name="q" value="{{ $q }}"
                                placeholder="Cari desain..." />
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>

@push('lastScripts')
    <script>
        // Efek "rasa template": saat scroll, header jadi full (tanpa rounded),
        // saat di atas kembali rounded & ada border tipis.
        (function() {
            const nav = document.getElementById('site-navbar');
            const wrap = document.getElementById('site-navbar-wrap');
            if (!nav || !wrap) return;

            const onScroll = () => {
                const y = window.scrollY || document.documentElement.scrollTop;
                if (y > 2) {
                    nav.classList.remove('rounded-4');
                    nav.classList.add('rounded-0', 'border-0', 'border-bottom');
                    wrap.classList.add('bg-white'); // background solid saat turun
                } else {
                    nav.classList.add('rounded-4');
                    nav.classList.remove('rounded-0', 'border-bottom');
                    nav.classList.add('border'); // kembali ada border tipis
                    wrap.classList.remove('bg-white');
                }
            };
            onScroll();
            window.addEventListener('scroll', onScroll, {
                passive: true
            });
        })();
    </script>
@endpush
