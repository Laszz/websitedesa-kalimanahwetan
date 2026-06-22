<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Baru</title>
    <link rel="stylesheet" href="{{ asset('css/auth/reset-password.css') }}">
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- LOGO DESA -->
            <img src="{{ asset('images/Logo.png') }}" alt="Logo Desa" class="logo">
            
            <h2>Buat Password Baru</h2>
            <p class="subtitle">Masukkan password baru kamu di bawah ini.</p>

            <form method="POST" action="{{ route('password.store') }}" id="resetForm">
                @csrf

                <!-- Token dari URL -->
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $email) }}" readonly>
                    @error('email')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Baru -->
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" name="password" id="password" placeholder="Minimal 8 karakter">
                    @error('password')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="btn">Reset Password</button>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/auth/reset-password.js') }}"></script>
</body>
</html>