<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Perangkat Desa - {{ config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/Logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    {{-- Tailwind (Vite) --}}
    @vite('resources/css/app.css')

    {{-- Custom CSS untuk halaman login --}}
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="text-center mb-6">
                <img src="{{ asset('images/Logo.png') }}" alt="Logo Desa" class="login-logo">
                <h1 class="login-title">Login Perangkat Desa</h1>
                <p class="login-subtitle">Silakan masuk untuk mengakses panel perangkat desa</p>
            </div>

            {{-- Pesan sukses dari register --}}
            @if (session('success'))
                <div id="alert-success" class="alert alert-success">
                    <span>{{ session('success') }}</span>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">✖</button>
                </div>
            @endif

            {{-- Pesan status (misal dari reset password) --}}
            @if (session('status'))
                <div id="alert-status" class="alert alert-status">
                    <span>{{ session('status') }}</span>
                    <button type="button" class="alert-close" onclick="this.parentElement.remove()">✖</button>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Masukkan Email">
                    @error('email')
                        <span class="text-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password + Toggle -->
                <div class="form-group relative">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required placeholder="Masukkan Password">
                    <button type="button" id="togglePassword" class="toggle-password-btn">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    @error('password')
                        <span class="text-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="remember-me-wrapper">
                    <label class="remember-me-label">
                        <input type="checkbox" name="remember" value="1" id="remember_me">
                        <span class="checkmark"></span>
                        <span class="remember-text">Ingat saya</span>
                    </label>
                </div>

                <!-- Submit -->
                <div class="form-footer">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="login-link">Lupa password?</a>
                    @endif

                    <button type="submit" class="btn-submit" id="btnSubmit">
                        <span class="btn-text">Masuk</span>
                        <div class="btn-loader" style="display: none;">
                            <div class="spinner"></div>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/auth/login.js') }}"></script>
</body>
</html>