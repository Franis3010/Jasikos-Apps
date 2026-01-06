@extends('layouts.landingpages.app')
@section('title', setting('about_hero_title', 'About Jasikos'))

@section('content')
    <section class="py-5 text-center">
        <h1 class="fw-bold mb-2">{{ setting('about_hero_title', 'About Jasikos') }}</h1>
        <p class="text-muted lead mb-0">{{ setting('about_hero_sub', 'We help you turn ideas into production-ready cosplay designs—clean, precise, and elegant.') }}</p>
    </section>

    <section class="py-5 section-thick-top">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                {!! setting('about_body_html', '<p>Write the About content in Admin &gt; Site Content.</p>') !!}
            </div>
            <div class="col-lg-6">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="about-card p-4 h-100">
                            <div class="h2 fw-bold mb-1">{{ setting('about_stat_1_n', '150+') }}</div>
                            <div class="text-muted">{{ setting('about_stat_1_l', 'Projects completed') }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="about-card p-4 h-100">
                            <div class="h2 fw-bold mb-1">{{ setting('about_stat_2_n', '4.9/5') }}</div>
                            <div class="text-muted">{{ setting('about_stat_2_l', 'Average designer rating') }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="about-card p-4 h-100">
                            <div class="fw-semibold mb-1">{{ setting('about_service_1_t', 'Key Service') }}</div>
                            <div class="text-muted small">{{ setting('about_service_1_d', '2D/3D concepts, patterns, and print-ready files.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 section-thick-top">
        <h3 class="fw-semibold mb-4">What we do</h3>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="service-card p-4 h-100">
                    <h5 class="mb-2">{{ setting('about_service_1_t', 'Ready-to-Use Designs') }}</h5>
                    <p class="text-muted small mb-0">
                        {{ setting('about_service_1_d', 'A catalog of designs you can purchase instantly—practical and fast.') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card p-4 h-100">
                    <h5 class="mb-2">{{ setting('about_service_2_t', 'Custom Request') }}</h5>
                    <p class="text-muted small mb-0">{{ setting('about_service_2_d', 'Designs created from your brief.') }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card p-4 h-100">
                    <h5 class="mb-2">{{ setting('about_service_3_t', 'Production Support') }}</h5>
                    <p class="text-muted small mb-0">
                        {{ setting('about_service_3_d', 'Final files with detailed specifications.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 section-thick-top">
        <div class="cta-panel d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h4 class="mb-1">Ready to start a project?</h4>
                <div class="text-muted">Tell us what you need—we’ll reply with an estimate and workflow.</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('designs.index') }}" class="btn btn-outline-dark rounded-pill px-4">Browse Catalog</a>
                <a href="https://wa.me/{{ setting('about_whatsapp', '628xxxx') }}" target="_blank" rel="noopener"
                    class="btn btn-dark rounded-pill px-4">Contact via WhatsApp</a>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Elegant top divider + vertical rhythm */
        .section-thick-top {
            border-top: 1.5px solid rgba(0, 0, 0, .85)
        }

        /* Small cards */
        .about-card,
        .service-card {
            border: 1.2px solid #000;
            border-radius: 1rem;
            background: #fff;
            transition: transform .18s ease, box-shadow .18s ease
        }

        .about-card:hover,
        .service-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, .06)
        }

        /* CTA panel */
        .cta-panel {
            border: 1.5px solid #000;
            border-radius: 1rem;
            padding: 1.5rem 1.75rem;
            background: #fff
        }
    </style>
@endpush
