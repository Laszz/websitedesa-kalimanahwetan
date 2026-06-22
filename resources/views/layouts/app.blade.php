<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aplikasi Warga')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/Logo.png') }}">

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('css/layouts/app.css') }}">

    <!-- CSS Navbar -->
    <link rel="stylesheet" href="{{ asset('css/partials/navbar.css') }}">

    {{-- Styles tambahan dari halaman --}}
    @stack('styles')
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    {{-- Navbar --}}
    @include('partials.navbar')

    {{--FLASH NOTIFICATION TOAST --}}
    @if(session('success'))
        <div class="flash-toast" data-type="success">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" aria-label="Tutup notifikasi">✕</button>
        </div>
    @endif

    @if(session('error'))
        <div class="flash-toast flash-error" data-type="error">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" aria-label="Tutup notifikasi">✕</button>
        </div>
    @endif

    {{-- Content --}}
    <main class="flex-1 w-full">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    <!-- JS Global -->
    <script src="{{ asset('js/layouts/app.js') }}"></script>

    <!-- JS Navbar -->
    <script src="{{ asset('js/partials/navbar.js') }}"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    @stack('scripts')
</body>
</html>