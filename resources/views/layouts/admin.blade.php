<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - @yield('title', 'Dashboard')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/Logo.png') }}">

    <!-- CSS Layout -->
    <link rel="stylesheet" href="{{ asset('css/layouts/admin.css') }}">
    
    <!-- CSS Sidebar -->
    <link rel="stylesheet" href="{{ asset('css/partials/sidebar.css') }}">

    @stack('styles')
</head>
<body>

    <!-- Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Tombol Toggle Sidebar -->
    <button id="sidebarToggle" class="sidebar-toggle-btn">
        ☰ Menu
    </button>

    {{-- Sidebar Admin --}}
    @include('partials.admin.sidebar')

    {{-- Konten Halaman --}}
    <main class="admin-content">
        @yield('content')
    </main>

    <!-- JS Layout -->
    <script src="{{ asset('js/layouts/admin.js') }}"></script>
    
    <!-- JS Sidebar -->
    <script src="{{ asset('js/partials/sidebar.js') }}"></script>

    @stack('scripts')
</body>
</html>