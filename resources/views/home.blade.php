@extends('layouts.landingpages.app')
@section('title', 'Beranda')

@section('content')
    @php
        $slides = ($latest ?? collect())->take(3);
    @endphp

    {{-- ========== HERO ========== --}}
    <section class="mb-4">
        <div class="rounded-4 overflow-hidden position-relative hero hero--compact">
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4500"
                data-bs-pause="hover">

                {{-- Indicators (bottom-right, small dots) --}}
                <div class="carousel-indicators">
                    @foreach ($slides as $i => $s)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}"
                            class="{{ $i === 0 ? 'active' : '' }}" aria-current="{{ $i === 0 ? 'true' : 'false' }}"
                            aria-label="Slide {{ $i + 1 }}"></button>
                    @endforeach
                </div>

                <div class="carousel-inner">
                    @forelse($slides as $i => $d)
                        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                            @if ($d->thumbnail)
                                <img src="{{ asset('storage/' . $d->thumbnail) }}" class="d-block w-100"
                                    style="height:var(--hero-h);object-fit:cover;object-position:center;"
                                    alt="{{ $d->title }}" loading="lazy">
                            @else
                                <div class="bg-light w-100" style="height:var(--hero-h)"></div>
                            @endif

                            {{-- Soft overlay --}}
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="background:linear-gradient(180deg,rgba(0,0,0,.12) 0%,rgba(0,0,0,.3) 60%,rgba(0,0,0,.55) 100%);">
                            </div>

                            {{-- Caption (bottom-left) --}}
                            <div class="carousel-caption text-start hero-caption-compact">
                                <div class="container-fluid px-3 px-md-4">
                                    <div class="col-xl-5 col-lg-6">
                                        <span class="hero-chip mb-2">
                                            {{ $d->designer->display_name ?? ($d->designer->user->name ?? 'Designer') }}
                                        </span>
                                        <h2 class="hero-title-compact mb-2">{{ $d->title }}</h2>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('designs.show', $d->slug) }}"
                                                class="btn btn-dark btn-sm rounded-pill px-3">
                                                View Details
                                            </a>
                                            <a href="{{ route('designs.index') }}"
                                                class="btn btn-outline-light btn-sm rounded-pill px-3 border-2">
                                                Browse Catalog
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="carousel-item active">
                            <div class="bg-light w-100" style="height:var(--hero-h)"></div>
                            <div class="carousel-caption text-start hero-caption-compact">
                                <div class="container-fluid px-3 px-md-4">
                                    <div class="col-xl-5 col-lg-6">
                                        <span class="hero-chip mb-2">Jasikos</span>
                                        <h2 class="hero-title-compact mb-2">Cosplay Design Services</h2>
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('designs.index') }}"
                                                class="btn btn-dark btn-sm rounded-pill px-3">Browse Catalog</a>
                                            <a href="{{ route('login') }}"
                                                class="btn btn-outline-light btn-sm rounded-pill px-3 border-2">Request
                                                Custom</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"
                    aria-label="Previous">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"
                    aria-label="Next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </section>

    {{-- ===== ABOUT BLURB (right-aligned) ===== --}}
    <section class="py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 d-none d-lg-block"></div>
            <div class="col-lg-6">
                <div class="text-center text-md-end">
                    <div class="about-blurb fw-semibold lh-sm">
                        {{ setting('home_about_blurb', 'We help cosplayers & brands turn ideas into production-ready visuals—clean, precise, and ready to use.') }}
                    </div>


                    <div class="mt-3">
                        <a href="{{ url('/about') }}"
                            class="btn btn-dark rounded-pill px-4 d-inline-flex align-items-center gap-2">
                            ABOUT
                            <i class="fa-solid fa-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- ========== KATEGORI ========== --}}
    {{-- ========== KATEGORI (chip rail elegan) ========== --}}
    @php($currentCat = request('category'))
    <section class="section-thick-top py-6">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0 section-title">Browse categories</h5>
            {{-- <a href="{{ route('designs.index') }}" class="small text-decoration-none">See all</a> --}}
        </div>

        <div class="cat-rail position-relative">
            <div class="cat-rail-scroller d-flex flex-nowrap gap-2 overflow-auto pb-1">
                <a href="{{ route('designs.index') }}"
                    class="btn rounded-pill cat-chip {{ request('category') ? '' : 'active' }}">All</a>
                @foreach ($categories as $c)
                    <a href="{{ route('designs.index', ['category' => $c->slug]) }}"
                        class="btn rounded-pill cat-chip {{ request('category') === $c->slug ? 'active' : '' }}">
                        {{ $c->name }}
                    </a>
                @endforeach
            </div>
            <div class="cat-fade cat-fade--left d-none d-md-block"></div>
            <div class="cat-fade cat-fade--right d-none d-md-block"></div>
        </div>
    </section>

    {{-- ========== DESAIN TERBARU ========== --}}
    <section class="section-thick-top py-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0 section-title">Latest Design</h4>
            {{-- <a href="{{ route('designs.index') }}" class="small text-decoration-none">Lihat semua</a> --}}
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @forelse ($latest as $d)
                @php($designer = $d->designer->display_name ?? ($d->designer->user->name ?? '-'))
                <div class="col">
                    <div class="tile-wrap">
                        <a href="{{ route('designs.show', $d->slug) }}" class="d-block text-decoration-none text-reset">
                            <div class="tile rounded-4 overflow-hidden ratio ratio-16x9 bg-light position-relative">
                                @if ($d->thumbnail)
                                    <img src="{{ asset('storage/' . $d->thumbnail) }}" class="w-100 h-100"
                                        style="object-fit:cover" alt="{{ $d->title }}">
                                @endif
                            </div>
                        </a>
                        {{-- META di LUAR card, muncul saat hover --}}
                        <div class="tile-meta">
                            <div class="fw-semibold">{{ $d->title }}</div>
                            <div class="text-muted small">{{ $designer }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-muted">No design yet.</div>
            @endforelse

            {{-- Tile abu-abu "Lihat Semua Desain" --}}
            <div class="col">
                <a href="{{ route('designs.index') }}" class="d-block text-decoration-none">
                    <div class="rounded-4 ratio ratio-16x9 cta-all">
                        <div class="d-flex align-items-center justify-content-center text-center w-100 h-100">
                            <span class="fw-semibold text-dark cta-label">
                                See all designs</span>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </section>
    {{-- ========== HOW IT WORKS ========== --}}
    <section class="section-thick-top py-6">
        <h4 class="mb-4">How It Works</h4>

        <div class="row gy-4">
            <div class="col-md-4">
                <div class="step-card h-100 p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="step-dot">1</span>
                        <h5 class="ms-2 mb-0">Choose / Request</h5>
                    </div>
                    <p class="text-muted mb-0 small">
                        Add a design to cart or submit a custom request to a designer.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="step-card h-100 p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="step-dot">2</span>
                        <h5 class="ms-2 mb-0">Payment</h5>
                    </div>
                    <p class="text-muted mb-0 small">
                        Pay via bank/QRIS and upload the proof. The designer will confirm.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="step-card h-100 p-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="step-dot">3</span>
                        <h5 class="ms-2 mb-0">Receive Files</h5>
                    </div>
                    <p class="text-muted mb-0 small">
                        Download files according to status (paid / delivered / completed).
                    </p>
                </div>
            </div>
        </div>
    </section>
    {{-- ========== CTA ========== --}}
    <section class="section-thick-top py-6 mt-2">
        <div class="cta-panel d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h4 class="mb-1">Have a specific brief?</h4>
                <div class="text-muted">Tell us what you need and our designers will send an offer.</div>
            </div>

            @auth
                @if (auth()->user()->role === 'customer')
                    <a class="btn btn-dark btn-lg rounded-pill px-4" href="{{ route('customer.custom-requests.create') }}">
                        Create Custom Request
                    </a>
                @else
                    <a class="btn btn-dark btn-lg rounded-pill px-4" href="{{ route('login') }}">
                        Create Custom Request
                    </a>
                @endif
            @else
                <a class="btn btn-dark btn-lg rounded-pill px-4" href="{{ route('login') }}">
                    Create Custom Request
                </a>
            @endauth
        </div>
    </section>


@endsection

@push('styles')
    <style>
        :root {
            /* DIBESARIN: tinggi hero */
            --hero-h: clamp(360px, 68vh, 760px);
            --hero-title-size: clamp(1.1rem, 1.1vw + 1rem, 1.85rem);
        }

        @media (min-width: 1200px) {
            :root {
                --hero-h: clamp(420px, 72vh, 820px);
            }
        }

        /* caption kiri-bawah */
        #heroCarousel .carousel-caption.hero-caption-compact {
            bottom: 8.5%;
        }

        .hero-title-compact {
            color: #fff;
            font-weight: 600;
            line-height: 1.15;
            font-size: var(--hero-title-size);
            letter-spacing: .2px;
            margin: 0;
            text-shadow: 0 1px 2px rgba(0, 0, 0, .35);
        }

        .hero-chip {
            display: inline-block;
            padding: .28rem .6rem;
            border-radius: 999px;
            color: #fff;
            font-size: .8rem;
            background: rgba(255, 255, 255, .15);
            border: 1px solid rgba(255, 255, 255, .25);
            backdrop-filter: blur(4px);
        }

        .hero-caption-compact .btn {
            box-shadow: 0 .3rem .8rem rgba(0, 0, 0, .12);
        }

        .hero-caption-compact .btn-outline-light {
            --bs-btn-hover-color: #000;
            --bs-btn-hover-bg: #fff;
        }

        /* INDICATORS PIN KE KANAN-BAWAH */
        #heroCarousel .carousel-indicators {
            position: absolute;
            left: auto;
            /* lepas center default */
            right: .85rem;
            /* geser ke kanan */
            bottom: .85rem;
            /* geser ke bawah */
            transform: none;
            /* hilangkan translateX(-50%) default */
            width: auto;
            /* supaya selebar konten */
            margin: 0;
            /* rapihin margin default */
            gap: .35rem;
            justify-content: flex-end;
            z-index: 3;
            /* pastikan di atas overlay */
        }

        #heroCarousel .carousel-indicators [data-bs-target] {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, .75);
            opacity: .6;
        }

        #heroCarousel .carousel-indicators .active {
            width: 10px;
            height: 10px;
            opacity: 1;
            background-color: #fff;
        }

        /* responsif */
        @media (max-width:575.98px) {
            #heroCarousel .carousel-caption.hero-caption-compact {
                bottom: 7.5%;
            }

            .hero-chip {
                font-size: .75rem;
                padding: .24rem .55rem;
            }
        }

        .about-blurb {
            font-size: clamp(1.25rem, 1.1vw + 1rem, 2rem);
            letter-spacing: .2px;
        }

        /* Rail */
        .cat-rail {
            position: relative;
        }

        .cat-rail-scroller {
            scroll-snap-type: x proximity;
            -webkit-overflow-scrolling: touch;
        }

        .cat-rail-scroller>* {
            scroll-snap-align: start;
        }

        /* Chip look */
        .cat-chip {
            --chip-bg: #fff;
            --chip-border: #e5e7eb;
            --chip-text: #111;
            --chip-bg-active: #111;
            --chip-text-active: #fff;

            background: var(--chip-bg);
            border: 1px solid var(--chip-border);
            color: var(--chip-text);
            padding: .45rem .85rem;
            font-size: .9rem;
            line-height: 1;
        }

        .cat-chip:hover {
            background: #111;
            color: #fff;
            border-color: #111;
        }

        .cat-chip.active {
            background: var(--chip-bg-active);
            color: var(--chip-text-active);
            border-color: var(--chip-bg-active);
        }

        /* Fade edges */
        .cat-fade {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 42px;
            pointer-events: none;
        }

        .cat-fade--left {
            left: 0;
            background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0));
        }

        .cat-fade--right {
            right: 0;
            background: linear-gradient(270deg, #fff, rgba(255, 255, 255, 0));
        }

        /* Tipis-in scrollbar (opsional) */
        .cat-rail-scroller::-webkit-scrollbar {
            height: 6px;
        }

        .cat-rail-scroller::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }

        /* Latar abu default card */
        /* efek zoom gambar */
        .tile img {
            transition: transform .45s ease;
        }

        .tile-wrap:hover .tile img {
            transform: scale(1.03);
        }

        /* meta di bawah card: hidden dulu, muncul halus saat hover */
        .tile-meta {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            margin-top: 0;
            transition: max-height .25s ease, opacity .25s ease, margin-top .25s ease;
        }

        .tile-wrap:hover .tile-meta {
            max-height: 80px;
            /* cukup untuk 2 baris */
            opacity: 1;
            margin-top: .5rem;
        }

        /* kartu abu-abu untuk CTA 'Lihat Semua Desain' */
        .cta-all {
            background: var(--bs-secondary-bg, #e9ecef);
            /* abu elegan (BS 5.3 aware) */
            transition: filter .2s ease, transform .2s ease;
        }

        .cta-all:hover {
            filter: brightness(.95);
            transform: translateY(-2px);
        }

        /* Jarak vertikal ekstra ala “py-6” */
        .py-6 {
            padding-top: 3.5rem !important;
            padding-bottom: 3.5rem !important;
        }

        /* Garis pemisah tebal & jarak lega di atas section */
        .section-thick-top {
            border-top: 3px solid #000 !important;
            margin-top: 2.25rem;
            /* jarak sebelum garis */
        }

        .cta-label {
            font-size: clamp(1.1rem, .7vw + 1rem, 1.5rem);
        }


        /* Kartu langkah: elegan, tegas */
        .step-card {
            border: 1.6px solid #000;
            border-radius: 1rem;
            transition: transform .18s ease, box-shadow .18s ease;
            background: #fff;
        }

        .step-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06);
        }

        /* Bulatan nomor */
        .step-dot {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #000;
            color: #fff;
            font-weight: 700;
            font-size: .95rem;
        }

        /* Panel CTA elegan */
        .cta-panel {
            border: 2px solid #000;
            border-radius: 1rem;
            padding: 1.5rem 1.75rem;
            background: #fff;
        }

        /* Responsif kecil: rapikan padding */
        @media (max-width: 575.98px) {
            .cta-panel {
                padding: 1.25rem 1.25rem;
            }
        }

        /* Tipisin separator & bingkai biar lebih elegan */
        .section-thick-top {
            border-top: 1.5px solid rgba(0, 0, 0, .85) !important;
        }

        .step-card {
            border-width: 1.2px;
        }

        .cta-panel {
            border-width: 1.5px;
        }

        .section-title {
            font-weight: 700;
            letter-spacing: .2px;
            font-size: clamp(1.25rem, 0.9vw + 1.1rem, 2rem);
            line-height: 1.2;
        }

        /* Tambah ruang antar judul & konten section */
        .section-thick-top .section-title {
            margin-bottom: .25rem;
        }
    </style>
@endpush
