@extends('layouts.landingpages.app')
@section('title', 'Designer Profile')

@section('content')
    @php
        $name = $designer->display_name ?? ($designer->user->name ?? 'Designer');
        $bio = trim((string) $designer->bio);
        $avg = $designer->ratings_avg_stars ?? ($designer->ratings()->avg('stars') ?? 0);
        $cnt = $designer->ratings_count ?? $designer->ratings()->count();
        $total = $designer->designs->count();
        $avatar = $designer->user->avatar ?? null;
        $wa = $designer->user->whatsapp ?? null;
    @endphp

    {{-- ===== HERO / HEADER ===== --}}
    <section class="mb-4">
        <div class="p-3 p-md-4 border rounded-4 bg-white shadow-sm">
            <div class="d-flex align-items-center gap-3">
                <div class="flex-shrink-0">
                    @if ($avatar)
                        <img src="{{ asset('storage/' . $avatar) }}" alt="{{ $name }}" class="rounded-circle"
                            style="width:72px;height:72px;object-fit:cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                            style="width:72px;height:72px;">
                            <i class="fa-regular fa-user text-muted"></i>
                        </div>
                    @endif
                </div>

                <div class="flex-grow-1">
                    <h1 class="h4 mb-1 fw-semibold">{{ $name }}</h1>
                    <div class="text-muted small">Jasikos Designer</div>

                    <div class="d-flex flex-wrap gap-2 mt-2">
                        <span class="badge rounded-pill bg-dark-subtle text-dark border">
                            @if ($cnt > 0)
                                Rating {{ number_format($avg, 1) }}/5 ({{ $cnt }})
                            @else
                                No ratings yet
                            @endif
                        </span>
                        <span class="badge rounded-pill bg-light text-dark border">
                            {{ $total }} designs
                        </span>
                    </div>
                </div>

                @if ($wa)
                    <div class="d-none d-md-block">
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $wa) }}" target="_blank" rel="noopener"
                            class="btn btn-dark rounded-pill px-4 d-inline-flex align-items-center gap-2">
                            <i class="fa-brands fa-whatsapp"></i> Contact
                        </a>
                    </div>
                @endif
            </div>

            @if ($wa)
                <div class="mt-3 d-md-none">
                    <a href="https://wa.me/{{ preg_replace('/\D/', '', $wa) }}" target="_blank" rel="noopener"
                        class="btn btn-dark w-100 rounded-pill">Contact via WhatsApp</a>
                </div>
            @endif

            @if ($bio)
                <hr class="my-3">
                <div class="text-body-tertiary small">{!! nl2br(e($bio)) !!}</div>
            @endif
        </div>
    </section>

    {{-- ===== DESIGNS GRID (2 columns) ===== --}}
    <section class="section-thick-top pt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 section-title">Designs by {{ $name }}</h4>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            @forelse($designer->designs as $d)
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

                        {{-- meta OUTSIDE the card, appears on hover --}}
                        <div class="tile-meta">
                            <div class="fw-semibold">{{ $d->title }}</div>
                            <div class="text-muted small">Rp {{ number_format($d->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-muted">No published designs yet.</div>
            @endforelse
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
            font-size: clamp(1.25rem, .9vw+1.1rem, 2rem);
            line-height: 1.2
        }

        /* elegant tile hover (consistent with home/catalog) */
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
            max-height: 80px;
            opacity: 1;
            margin-top: .5rem;
        }
    </style>
@endpush
