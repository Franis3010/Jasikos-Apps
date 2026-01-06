@extends('layouts.landingpages.app')
@section('title', 'Design Catalog')

@section('content')
    @php
        $currentCat = $catSlug;
    @endphp

    {{-- ===== Filter Bar ===== --}}
    <section class="mb-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-3 p-md-4">
                <form method="GET" class="row g-2 align-items-center">
                    <div class="col-12 col-md-6">
                        <input type="text" name="q" class="form-control" placeholder="Search design title…"
                            value="{{ $q }}">
                    </div>
                    <div class="col-8 col-md-4">
                        <select name="sort" class="form-select">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Lowest Price</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Highest Price
                            </option>
                        </select>
                    </div>
                    <div class="col-4 col-md-2">
                        <button class="btn btn-dark w-100 rounded-pill">Filter</button>
                    </div>
                    {{-- preserve category on submit --}}
                    @if ($currentCat)
                        <input type="hidden" name="category" value="{{ $currentCat }}">
                    @endif
                </form>

                {{-- category rail (chip links) --}}
                <div class="mt-3 cat-rail position-relative">
                    <div class="cat-rail-scroller d-flex flex-nowrap gap-2 overflow-auto pb-1">
                        <a href="{{ route('designs.index', array_filter(['q' => $q, 'sort' => $sort])) }}"
                            class="btn rounded-pill cat-chip {{ $currentCat ? '' : 'active' }}">All</a>

                        @foreach ($categories as $c)
                            <a href="{{ route('designs.index', array_filter(['q' => $q, 'sort' => $sort, 'category' => $c->slug])) }}"
                                class="btn rounded-pill cat-chip {{ $currentCat === $c->slug ? 'active' : '' }}">
                                {{ $c->name }}
                            </a>
                        @endforeach
                    </div>
                    <div class="cat-fade cat-fade--left d-none d-md-block"></div>
                    <div class="cat-fade cat-fade--right d-none d-md-block"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Grid (2 columns, elegant) ===== --}}
    <section class="section-thick-top py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 section-title">Design Catalog</h4>
            @if ($currentCat)
                <a href="{{ route('designs.index') }}" class="small text-decoration-none">Reset</a>
            @endif
        </div>

        {{-- 1 column on mobile, 2 columns from md to xl --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 g-4 g-lg-5">
            @forelse($designs as $d)
                <div class="col">
                    <div class="tile-wrap h-100">
                        <a href="{{ route('designs.show', $d->slug) }}" class="d-block text-decoration-none text-reset">
                            <div class="tile rounded-4 overflow-hidden ratio ratio-16x9 bg-light position-relative">
                                @if ($d->thumbnail)
                                    <img src="{{ asset('storage/' . $d->thumbnail) }}" class="w-100 h-100"
                                        style="object-fit:cover" alt="{{ $d->title }}">
                                @endif
                            </div>
                        </a>
                        {{-- meta outside the card, appears on hover --}}
                        <div class="tile-meta">
                            <div class="fw-semibold">{{ $d->title }}</div>
                            <div class="text-muted small">
                                {{ $d->designer->display_name ?? ($d->designer->user->name ?? '-') }}
                            </div>
                            <div class="mt-1">Rp {{ number_format($d->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-muted">No results found.</div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $designs->withQueryString()->links() }}
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .section-thick-top {
            border-top: 1.5px solid rgba(0, 0, 0, .85)
        }

        .section-title {
            font-weight: 700;
            letter-spacing: .2px;
            font-size: clamp(1.25rem, .9vw + 1.1rem, 2rem);
            line-height: 1.2
        }

        /* Category rail (consistent with home) */
        .cat-rail {
            position: relative
        }

        .cat-rail-scroller {
            scroll-snap-type: x proximity;
            -webkit-overflow-scrolling: touch
        }

        .cat-rail-scroller>* {
            scroll-snap-align: start
        }

        .cat-chip {
            background: #fff;
            border: 1px solid #e5e7eb;
            color: #111;
            padding: .45rem .85rem;
            font-size: .9rem;
            line-height: 1;
        }

        .cat-chip:hover {
            background: #111;
            color: #fff;
            border-color: #111
        }

        .cat-chip.active {
            background: #111;
            color: #fff;
            border-color: #111
        }

        .cat-fade {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 42px;
            pointer-events: none
        }

        .cat-fade--left {
            left: 0;
            background: linear-gradient(90deg, #fff, rgba(255, 255, 255, 0))
        }

        .cat-fade--right {
            right: 0;
            background: linear-gradient(270deg, #fff, rgba(255, 255, 255, 0))
        }

        .cat-rail-scroller::-webkit-scrollbar {
            height: 6px
        }

        .cat-rail-scroller::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px
        }

        /* Elegant tile hover */
        .tile img {
            transition: transform .45s ease;
        }

        .tile-wrap:hover .tile img {
            transform: scale(1.03);
        }

        .tile-meta {
            max-height: 0;
            opacity: 0;
            overflow: hidden;
            margin-top: 0;
            transition: max-height .25s ease, opacity .25s ease, margin-top .25s ease;
        }

        .tile-wrap:hover .tile-meta {
            max-height: 120px;
            opacity: 1;
            margin-top: .5rem;
        }
    </style>
@endpush
