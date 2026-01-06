<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <title>{{ config('app.name') . ' - ' . ($title ?? config('app.name')) }}</title> --}}
    <title>{{ $title ?? 'Aplikasi Pengelolaan Keuangan' }}</title>
    <!-- Favicon -->
    {{-- <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/logo rsd.png') }}"> --}}

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @stack('styles')
</head>

<body>
    @auth
        @php($role = auth()->user()->role ?? null)

        @if ($role === 'admin')
            <x-admin.sidebar />
            <x-admin.navbar />
        @elseif ($role === 'customer')
            <x-customer.sidebar />
            <x-customer.navbar />
        @elseif ($role === 'designer')
            <x-designer.sidebar />
            <x-designer.navbar />
        @endif
    @endauth
    {{-- @include('layouts.partials.header') --}}


    <div class="main-content">
        <section class="section">
            <div class="section-body">
                {{ $slot }}
            </div>
        </section>
    </div>
    @stack('modals')
    <!-- Page Specific JS File -->
    @stack('scripts')
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>


    @stack('lastScripts')
</body>

</html>
