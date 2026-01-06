{{-- resources/views/layouts/landingpages/header.blade.php --}}
@php
    $isCatalog = request()->routeIs('designs.*');
    $q = request('q');
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

    // Fallback: kalau $headerCategories belum dipass dari controller/composer, ambil semua kategori
    $headerCategories = $headerCategories ?? \App\Models\Category::select('name', 'slug')->orderBy('name')->get();
@endphp

<div id="nav-wrap" class="sticky-top py-3 bg-transparent">
    <div class="container-fluid px-3 px-md-4">
        {{-- default: flat --}}
        <nav id="mainNav"
            class="navbar navbar-expand-lg navbar-light bg-white border-0 shadow-none rounded-0 transition-nav">

            {{-- Brand (left) --}}
            <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo" height="28" onerror="this.remove()">
                <span>Jasikos</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain"
                aria-controls="navMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navMain">

                {{-- MENU (left of search) --}}
                {{-- MENU (left of search) --}}
                <ul class="navbar-nav align-items-lg-center gap-lg-1 me-3">
                    {{-- Home (desktop only) --}}
                    <li class="nav-item d-none d-xl-block">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ $isCatalog ? 'active' : '' }}"
                            @if ($isCatalog) aria-current="page" @endif
                            href="{{ route('designs.index') }}">Catalog</a>
                    </li>

                    {{-- ⬇️ PERBAIKI BAGIAN INI --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ $isCatalog && request('category') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>

                        <div class="dropdown-menu p-3 dropdown-cats">
                            <div class="d-flex flex-wrap gap-2 cats-wrap">
                                <a href="{{ route('designs.index') }}"
                                    class="btn btn-outline-dark btn-sm rounded-pill {{ request('category') ? '' : 'active' }}">
                                    View All
                                </a>
                                @foreach ($headerCategories as $c)
                                    <a href="{{ route('designs.index', ['category' => $c->slug]) }}"
                                        class="btn btn-outline-dark btn-sm rounded-pill {{ request('category') === $c->slug ? 'active' : '' }}">
                                        {{ $c->name }}
                                    </a>
                                @endforeach
                            </div>

                            {{-- <div class="mt-2 pt-2 border-top">
                                <a class="small text-decoration-none" href="{{ route('designs.index') }}">View all</a>
                            </div> --}}
                        </div>
                    </li>
                    {{-- ⬆️ PENTING: JANGAN ADA </div> EKSTRA DI SINI --}}

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                            href="{{ url('/about') }}">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#" target="_blank" rel="noopener">Contact</a>
                    </li>
                </ul>

                {{-- SEARCH (desktop) --}}
                <form class="d-none d-lg-flex me-3" method="GET" action="{{ route('designs.index') }}"
                    role="search">
                    <input class="form-control form-control-sm me-2" type="search" name="q"
                        value="{{ $q }}" placeholder="Search designs...">
                    <button class="btn btn-outline-dark btn-sm" type="submit">Search</button>
                </form>

                {{-- ACTIONS (right) --}}
                <ul class="navbar-nav align-items-lg-center ms-lg-2">
                    @auth
                        @if ($role === 'customer')
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-secondary btn-sm position-relative btn-nav"
                                    href="{{ route('customer.cart.index') }}" aria-label="Cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    @if ($cartCount > 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $cartCount }}</span>
                                    @endif
                                </a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="btn btn-dark btn-sm rounded-pill btn-nav"
                                    href="{{ route('customer.custom-requests.create') }}">Custom Request</a>
                            </li>
                        @endif

                        <li class="nav-item me-2">
                            <a class="btn btn-outline-dark btn-sm rounded-pill btn-nav"
                                href="{{ $dash }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button class="btn btn-link nav-link">Log out</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-dark btn-sm rounded-pill btn-nav"
                                href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-dark btn-sm rounded-pill btn-nav" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth

                    {{-- SEARCH (mobile) --}}
                    <li class="nav-item d-lg-none mt-3 w-100">
                        <form class="d-flex" method="GET" action="{{ route('designs.index') }}" role="search">
                            <input class="form-control me-2" type="search" name="q" value="{{ $q }}"
                                placeholder="Search designs...">
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                        </form>
                    </li>
                </ul>

            </div> {{-- /#navMain --}}
        </nav>
    </div>
</div>

<style>
    :root {
        --nav-pill-max: 1080px;
    }

    .transition-nav {
        transition: border-radius .28s ease, box-shadow .28s ease, max-width .28s ease, padding .28s ease, border-color .28s ease;
    }

    /* tighter container padding */
    #nav-wrap .container-fluid {
        padding-left: .75rem;
        padding-right: .75rem;
    }

    @media (min-width:768px) {
        #nav-wrap .container-fluid {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }

    /* tidy nav buttons */
    .btn-nav {
        padding: .35rem .75rem;
        font-weight: 600;
    }

    /* on scroll → floating pill */
    #nav-wrap.scrolled #mainNav {
        max-width: var(--nav-pill-max);
        margin-left: auto;
        margin-right: auto;
        border-radius: 26px !important;
        border: 1px solid rgba(0, 0, 0, .06) !important;
        box-shadow: 0 .75rem 1.5rem rgba(0, 0, 0, .06);
        padding-left: .85rem;
        padding-right: .85rem;
    }

    /* keep brand visible */
    #nav-wrap.scrolled .navbar-brand {
        opacity: 1;
        width: auto;
        margin-right: .5rem;
    }

    /* compact link padding when scrolled */
    #nav-wrap.scrolled .navbar-nav .nav-link {
        padding-left: .6rem;
        padding-right: .6rem;
    }

    /* ===== tambahan kecil agar dropdown kategori nyaman di mobile ===== */
    @media (max-width: 991.98px) {

        /* < lg */
        .navbar .dropdown-menu {
            position: static;
        }

        /* biar lebar mengikuti container di dalam collapse */
        .dropdown-cats {
            min-width: 100%;
            max-width: 100%;
        }
    }
</style>

<script>
    (function() {
        const wrap = document.getElementById('nav-wrap');
        if (!wrap) return;
        const THRESHOLD = 20;
        const onScroll = () => {
            const y = window.scrollY || document.documentElement.scrollTop || 0;
            if (y > THRESHOLD) wrap.classList.add('scrolled');
            else wrap.classList.remove('scrolled');
        };
        onScroll();
        window.addEventListener('scroll', onScroll, {
            passive: true
        });
    })();
</script>
