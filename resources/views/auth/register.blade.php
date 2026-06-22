<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="icon" type="image/png" href="{{ asset('images/Logo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>
<body>
<div class="register-wrapper">
    <div class="register-card">
        <div class="register-header">
            <h2 class="register-title">Daftar Akun</h2>
            <p class="register-subtitle">Isi data diri Anda dengan lengkap</p>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registerForm">
            @csrf

            <!-- SECTION: Identitas -->
            <div class="section-title">Identitas Diri</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Nama Lengkap <span class="required">*</span></label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Nama lengkap Anda">
                    @error('name') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="nik">NIK <span class="required">*</span></label>
                    <input id="nik" type="text" name="nik" value="{{ old('nik') }}" required maxlength="16" placeholder="16 digit NIK" class="numeric-input">
                    <span class="input-hint" id="nikHint">Masukkan 16 digit angka</span>
                    @error('nik') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="kk">No. KK <span class="required">*</span></label>
                    <input id="kk" type="text" name="kk" value="{{ old('kk') }}" required maxlength="16" placeholder="16 digit No. KK" class="numeric-input">
                    @error('kk') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan'?'selected':'' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION: Kelahiran -->
            <div class="section-title">Data Kelahiran</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                    <input id="tempat_lahir" type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required placeholder="Kota kelahiran">
                    @error('tempat_lahir') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                    <input id="tanggal_lahir" type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="umur_display">Umur</label>
                    <input id="umur_display" type="text" readonly placeholder="Otomatis terhitung">
                    <input type="hidden" name="umur" id="umur" value="{{ old('umur') }}">
                    @error('umur') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="agama">Agama <span class="required">*</span></label>
                    <select id="agama" name="agama" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('agama')=='Islam'?'selected':'' }}>Islam</option>
                        <option value="Kristen" {{ old('agama')=='Kristen'?'selected':'' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama')=='Katolik'?'selected':'' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama')=='Hindu'?'selected':'' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama')=='Buddha'?'selected':'' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama')=='Konghucu'?'selected':'' }}>Konghucu</option>
                    </select>
                    @error('agama') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION: Alamat -->
            <div class="section-title">Alamat</div>
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="alamat">Alamat Lengkap <span class="required">*</span></label>
                    <input id="alamat" type="text" name="alamat" value="{{ old('alamat') }}" required placeholder="Alamat lengkap">
                    @error('alamat') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="rw">RW <span class="required">*</span></label>
                    <input id="rw" type="text" name="rw" value="{{ old('rw') }}" required placeholder="Contoh: 001">
                    @error('rw') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="rt">RT <span class="required">*</span></label>
                    <input id="rt" type="text" name="rt" value="{{ old('rt') }}" required placeholder="Contoh: 002">
                    @error('rt') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION: Lainnya -->
            <div class="section-title">Informasi Lainnya</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="status">Status Perkawinan <span class="required">*</span></label>
                    <select id="status" name="status" required>
                        <option value="">Pilih Status</option>
                        <option value="Belum Menikah" {{ old('status')=='Belum Menikah'?'selected':'' }}>Belum Menikah</option>
                        <option value="Menikah" {{ old('status')=='Menikah'?'selected':'' }}>Menikah</option>
                        <option value="Cerai Hidup" {{ old('status')=='Cerai Hidup'?'selected':'' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status')=='Cerai Mati'?'selected':'' }}>Cerai Mati</option>
                    </select>
                    @error('status') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="pendidikan_akhir">Pendidikan Akhir <span class="required">*</span></label>
                    <select id="pendidikan_akhir" name="pendidikan_akhir" required>
                        <option value="">Pilih Pendidikan</option>
                        <option value="Tidak Sekolah" {{ old('pendidikan_akhir')=='Tidak Sekolah'?'selected':'' }}>Tidak Sekolah</option>
                        <option value="SD" {{ old('pendidikan_akhir')=='SD'?'selected':'' }}>SD</option>
                        <option value="SMP" {{ old('pendidikan_akhir')=='SMP'?'selected':'' }}>SMP</option>
                        <option value="SMA/SMK" {{ old('pendidikan_akhir')=='SMA/SMK'?'selected':'' }}>SMA/SMK</option>
                        <option value="D1/D2" {{ old('pendidikan_akhir')=='D1/D2'?'selected':'' }}>D1/D2</option>
                        <option value="D3" {{ old('pendidikan_akhir')=='D3'?'selected':'' }}>D3</option>
                        <option value="S1" {{ old('pendidikan_akhir')=='S1'?'selected':'' }}>S1</option>
                        <option value="S2" {{ old('pendidikan_akhir')=='S2'?'selected':'' }}>S2</option>
                        <option value="S3" {{ old('pendidikan_akhir')=='S3'?'selected':'' }}>S3</option>
                    </select>
                    @error('pendidikan_akhir') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan <span class="required">*</span></label>
                    <input id="pekerjaan" type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" required placeholder="Pekerjaan saat ini">
                    @error('pekerjaan') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                    @error('email') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- SECTION: Foto -->
            <div class="section-title">Foto Profil</div>
            <div class="form-group">
                <div class="foto-upload-wrapper">
                    <div class="foto-preview" id="fotoPreview">
                        <i class="fa-solid fa-user foto-placeholder-icon"></i>
                    </div>
                    <div class="foto-upload-info">
                        <label for="foto" class="btn-upload">
                            <i class="fa-solid fa-camera"></i> Pilih Foto
                        </label>
                        <input id="foto" type="file" name="foto" accept="image/*" hidden>
                        <p class="foto-hint">Format: JPG, PNG. Maks 2MB</p>
                    </div>
                </div>
                @error('foto') <p class="text-error">{{ $message }}</p> @enderror
            </div>

            <!-- SECTION: Password -->
            <div class="section-title">Keamanan Akun</div>
            <div class="form-grid">
                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <div class="password-wrapper">
                        <input id="password" type="password" name="password" required placeholder="Minimal 8 karakter">
                        <button type="button" class="toggle-password" data-target="password">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    @error('password') <p class="text-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password <span class="required">*</span></label>
                    <div class="password-wrapper">
                        <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi password">
                        <button type="button" class="toggle-password" data-target="password_confirmation">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                    @error('password_confirmation') <p class="text-error">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Footer -->
            <div class="form-footer">
                <a href="{{ route('login') }}" class="register-link">Sudah punya akun? Login</a>
                <button type="submit" class="btn-submit" id="btnSubmit">
                    <span class="btn-text">Daftar Sekarang</span>
                    <div class="btn-loader" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/auth/register.js') }}" defer></script>
</body>
</html>