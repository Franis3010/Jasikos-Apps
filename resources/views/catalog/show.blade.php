@extends('layouts.landingpages.app')
@section('title', 'Design Details | ' . $design->title)

@section('content')
    @php
        $designer = $design->designer;
        $designerName = $designer->display_name ?? ($designer->user->name ?? 'Designer');
        $avg = $designer->ratings()->avg('stars') ?? 0;
        $cnt = $designer->ratings()->count();
    @endphp

    {{-- ===== Title & meta ===== --}}
    <section class="mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="h3 mb-1 fw-semibold">{{ $design->title }}</h1>
                <div class="text-muted small">
                    by <a href="{{ route('public.designer', $designer->id) }}"
                        class="text-decoration-none">{{ $designerName }}</a>
                    <span class="mx-2">•</span>
                    @if ($cnt > 0)
                        Rating {{ number_format($avg, 1) }}/5 ({{ $cnt }})
                    @else
                        No ratings yet
                    @endif
                </div>
            </div>

            {{-- kategori chips --}}
            <div class="d-flex flex-wrap gap-2">
                @forelse($design->categories as $c)
                    <span class="badge rounded-pill px-3 py-2 bg-light text-dark border">{{ $c->name }}</span>
                @empty
                    <span class="badge rounded-pill px-3 py-2 bg-light text-dark border">Uncategorized</span>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ===== Hero cover (besar) ===== --}}
    <section class="mb-4">
        <div class="rounded-4 overflow-hidden position-relative shadow-sm">
            @if ($design->thumbnail)
                <img src="{{ asset('storage/' . $design->thumbnail) }}" alt="{{ $design->title }}" class="w-100 hero-cover">
            @else
                <div class="ratio ratio-16x9 bg-light"></div>
            @endif
        </div>
    </section>

    {{-- ===== Content: kiri galeri, kanan detail ===== --}}
    <section class="section-thick-top pt-4">
        <div class="row g-4">
            {{-- KIRI: Galeri gambar/video --}}
            <div class="col-lg-7">
                @if (($design->media ?? collect())->isNotEmpty())
                    <div class="row g-3">
                        @foreach ($design->media as $m)
                            <div class="col-6">
                                @if ($m->type === 'image')
                                    <a href="{{ asset('storage/' . $m->path) }}"
                                        class="d-block rounded-4 overflow-hidden gallery-item" target="_blank"
                                        rel="noopener">
                                        <img src="{{ asset('storage/' . $m->path) }}" class="w-100 h-100 object-cover"
                                            alt="Media {{ $loop->iteration }}">
                                    </a>
                                @else
                                    <div class="rounded-4 overflow-hidden gallery-item">
                                        <video src="{{ asset('storage/' . $m->path) }}" class="w-100" controls
                                            playsinline></video>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-muted small">No additional media.</div>
                @endif
            </div>

            {{-- KANAN: Detail + CTA (sticky di desktop) --}}
            <div class="col-lg-5">
                <div class="detail-card p-4 rounded-4 border bg-white shadow-sm sticky-lg-top" style="top: 92px;">
                    <div class="d-flex align-items-baseline justify-content-between mb-3">
                        <div class="h4 m-0">Rp {{ number_format($design->price, 0, ',', '.') }}</div>
                    </div>

                    <div class="mb-3 text-muted small">
                        Designer:
                        <a href="{{ route('public.designer', $designer->id) }}"
                            class="text-decoration-none fw-semibold">{{ $designerName }}</a>
                    </div>

                    <div class="mb-4 prose-like">
                        {!! nl2br(e($design->description)) !!}
                    </div>

                    {{-- CTA --}}
                    {{-- CTA --}}
                    @auth
                        @if (auth()->user()->role === 'customer')
                            {{-- WA Button --}}
                            @php
                                $waNumber = $design->designer->user->whatsapp ?? null;
                                $waDigits = $waNumber ? preg_replace('/\D/', '', $waNumber) : null;
                                $message = "Halo kak {$designerName}, saya mau konsultasi dulu tentang desain *{$design->title}* sebelum order.";
                                $waLink = $waDigits ? "https://wa.me/{$waDigits}?text=" . urlencode($message) : null;
                            @endphp

                            @if ($waLink)
                                <a href="{{ $waLink }}" target="_blank" rel="noopener"
                                    class="btn btn-outline-success rounded-pill py-2 mb-2 w-100">
                                    <i class="bi bi-whatsapp me-2"></i> Chat Designer via WhatsApp
                                </a>
                            @endif

                            {{-- Add to cart button --}}
                            <form method="POST" action="{{ route('customer.cart.store', $design) }}" class="d-grid gap-2">
                                @csrf
                                <button class="btn btn-dark rounded-pill py-2">
                                    <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill w-100 py-2">
                                Log in as Customer to purchase
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill w-100 py-2">
                            Log in as Customer to purchase
                        </a>
                    @endauth

                    {{-- link balik --}}
                    <div class="mt-3 text-center">
                        <a href="{{ route('designs.index') }}" class="text-decoration-none small">← Back to Catalog</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* hero cover */
        .hero-cover {
            aspect-ratio: 16/9;
            object-fit: cover;
        }

        /* garis pemisah elegan */
        .section-thick-top {
            border-top: 1.5px solid rgba(0, 0, 0, .85);
        }

        /* kartu detail */
        .detail-card {
            border-width: 1.2px;
        }

        /* galeri */
        .gallery-item {
            background: #f5f5f5;
        }

        .gallery-item img {
            transition: transform .35s ease;
            display: block;
        }

        .gallery-item:hover img {
            transform: scale(1.03);
        }

        /* util */
        .object-cover {
            object-fit: cover;
            aspect-ratio: 4/3;
        }

        /* paragraf rapi untuk deskripsi */
        .prose-like {
            line-height: 1.65;
        }

        .prose-like p {
            margin-bottom: .75rem;
        }
    </style>
@endpush
