<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="{{ asset('css/auth/forgot-password.css') }}">
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- LOGO DESA -->
            <img src="{{ asset('images/Logo.png') }}" alt="Logo Desa" class="logo">
            
            <h2>Lupa Password?</h2>
            <p class="subtitle">Masukkan email kamu, nanti kita kirim link reset password.</p>

            @if (session('status'))
                <div class="alert success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="resetForm" novalidate>
                @csrf
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="contoh@email.com" autofocus>
                    <small class="error"></small>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn">Kirim Link Reset</button>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth/forgot-password.js') }}"></script>
</body>
</html>