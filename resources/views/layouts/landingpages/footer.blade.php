{{-- resources/views/layouts/landingpages/footer.blade.php --}}
<footer class="footer-dark text-white mt-5">
    <div class="container py-5 py-md-6">
        {{-- Top area --}}
        <div class="row g-4 g-lg-5 align-items-start">
            {{-- Brand + blurb --}}
            <div class="col-lg-4">
                <a href="{{ route('home') }}"
                    class="d-inline-flex align-items-center gap-2 mb-3 text-white text-decoration-none">
                    <img src="{{ asset('logo.png') }}" alt="Logo" height="28" onerror="this.remove()">
                    <strong>{{ config('app.name', 'Jasikos') }}</strong>
                </a>
                <p class="text-white-50 mb-3">
                    {{ setting('home_about_blurb', 'We help cosplayers & brands turn ideas into production-ready visuals—clean, precise, and ready to use.') }}
                </p>

                <a href="{{ url('/about') }}" class="footer-link me-3">About</a>
                <a href="#" class="footer-link" target="_blank" rel="noopener">Contact</a>
            </div>

            {{-- Link columns --}}
            <div class="col-lg-5">
                <div class="row g-4">
                    <div class="col-6 col-md-5">
                        <div class="text-white-50 small mb-2">Explore</div>
                        <ul class="list-unstyled m-0">
                            <li class="mb-2"><a class="footer-link" href="{{ route('designs.index') }}">Catalog</a>
                            </li>
                            <li class="mb-2"><a class="footer-link"
                                    href="{{ route('designs.index') }}?category=">Categories</a></li>
                            <li class="mb-2"><a class="footer-link" href="{{ url('/about') }}">About</a></li>
                        </ul>
                    </div>
                    <div class="col-6 col-md-7">
                        <div class="text-white-50 small mb-2">Support</div>
                        <ul class="list-unstyled m-0">
                            @auth
                                @if (auth()->user()->role === 'customer')
                                    <li class="mb-2"><a class="footer-link"
                                            href="{{ route('customer.custom-requests.create') }}">Custom Request</a></li>
                                @endif
                            @else
                                <li class="mb-2"><a class="footer-link" href="{{ route('login') }}">Login</a></li>
                                <li class="mb-2"><a class="footer-link" href="{{ route('register') }}">Register</a></li>
                            @endauth
                            <li class="mb-2"><a class="footer-link" href="#">Terms & Conditions</a></li>
                            <li class="mb-2"><a class="footer-link" href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- CTA + Social --}}
            <div class="col-lg-3">
                <a href="#" class="btn btn-gold w-100 mb-3">
                    Start a project
                    <i class="fa-solid fa-arrow-up-right ms-2"></i>
                </a>
            </div>
        </div>

        {{-- Divider --}}
        <hr class="footer-hr my-4 my-md-5">

        {{-- Bottom bar --}}
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
            <div class="small text-white-50">
                &copy; {{ now()->year }} {{ config('app.name', 'Jasikos') }}. All rights reserved.
            </div>
            <div class="small text-white-50">
                Built for creators. <span class="text-white">Stay inspired.</span>
            </div>
        </div>
    </div>
</footer>

{{-- Inline styles (biar pasti kepake) --}}
<style>
    .footer-dark {
        background: #0E0E10;
        /* hitam elegan */
    }

    .footer-hr {
        border: 0;
        border-top: 1px solid rgba(255, 255, 255, .12);
    }

    /* Micro-interaction underline */
    .footer-link {
        color: rgba(255, 255, 255, .8);
        text-decoration: none;
        position: relative;
        transition: color .2s ease;
    }

    .footer-link:hover {
        color: #fff;
    }

    .footer-link::after {
        content: "";
        position: absolute;
        left: 0;
        right: auto;
        bottom: -2px;
        height: 1px;
        width: 0;
        background: currentColor;
        transition: width .25s ease;
    }

    .footer-link:hover::after {
        width: 100%;
    }

    /* Gold CTA */
    .btn-gold {
        --gold: #FFD700;
        background: var(--gold);
        color: #1A1A1A;
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 999px;
        font-weight: 600;
        padding: .65rem 1rem;
        box-shadow: 0 .65rem 1.25rem rgba(0, 0, 0, .25);
        transition: transform .12s ease, box-shadow .2s ease, background-color .2s ease;
    }

    .btn-gold:hover {
        transform: translateY(-1px);
        box-shadow: 0 .9rem 1.6rem rgba(0, 0, 0, .28);
        background: #ffe24d;
    }

    @media (max-width: 575.98px) {
        .btn-gold {
            padding: .6rem .9rem;
        }
    }
</style>
