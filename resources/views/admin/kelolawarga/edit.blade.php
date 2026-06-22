@extends('layouts.admin')

@section('title', 'Edit Warga - ' . $warga->name)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/kelolawarga/edit.css') }}">
@endpush

@section('content')
<div class="warga-page warga-edit">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="warga-alert warga-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="warga-alert warga-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Header --}}
    <div class="warga-header">
        <div class="header-content">
            <h1 class="warga-title">
                <span class="warga-icon"><i class="fa-solid fa-user-pen"></i></span>
                Edit Data Warga
            </h1>
            <p class="warga-subtitle">Perbarui data warga: <strong>{{ $warga->name }}</strong></p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="warga-card form-card">

        <form action="{{ route('admin.kelolawarga.update', $warga->id) }}" method="POST" enctype="multipart/form-data" id="wargaForm">
            @csrf
            @method('PUT')

            {{-- Section: Identitas --}}
            <div class="form-section">
                <h3 class="section-title">
                    <span class="section-icon"><i class="fa-solid fa-id-card"></i></span>
                    Identitas
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">User ID <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-hashtag input-icon"></i>
                            <input type="text" name="user_id" class="input-modern" value="{{ old('user_id', $warga->user_id) }}" required>
                        </div>
                        @error('user_id')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">NIK <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-id-card input-icon"></i>
                            <input type="text" name="nik" class="input-modern" value="{{ old('nik', $warga->nik) }}" required maxlength="16">
                        </div>
                        @error('nik')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">KK <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-house-chimney-user input-icon"></i>
                            <input type="text" name="kk" class="input-modern" value="{{ old('kk', $warga->kk) }}" required>
                        </div>
                        @error('kk')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nama Lengkap <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user input-icon"></i>
                            <input type="text" name="name" class="input-modern" value="{{ old('name', $warga->name) }}" required>
                        </div>
                        @error('name')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Section: Data Pribadi --}}
            <div class="form-section">
                <h3 class="section-title">
                    <span class="section-icon"><i class="fa-solid fa-user-circle"></i></span>
                    Data Pribadi
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tempat Lahir</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-location-dot input-icon"></i>
                            <input type="text" name="tempat_lahir" class="input-modern" value="{{ old('tempat_lahir', $warga->tempat_lahir) }}">
                        </div>
                        @error('tempat_lahir')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tanggal Lahir</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-calendar input-icon"></i>
                            <input type="date" name="tanggal_lahir" class="input-modern" value="{{ old('tanggal_lahir', $warga->tanggal_lahir) }}">
                        </div>
                        @error('tanggal_lahir')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Umur</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-hourglass-half input-icon"></i>
                            <input type="number" name="umur" class="input-modern" value="{{ old('umur', $warga->umur) }}">
                        </div>
                        @error('umur')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-venus-mars input-icon"></i>
                            <select name="jenis_kelamin" class="input-modern">
                                <option value="">Pilih</option>
                                <option value="Laki-laki" {{ (old('jenis_kelamin', $warga->jenis_kelamin) == 'Laki-laki') ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ (old('jenis_kelamin', $warga->jenis_kelamin) == 'Perempuan') ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        @error('jenis_kelamin')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Agama</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-place-of-worship input-icon"></i>
                            <select name="agama" class="input-modern">
                                <option value="">Pilih</option>
                                <option value="Islam" {{ (old('agama', $warga->agama) == 'Islam') ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ (old('agama', $warga->agama) == 'Kristen') ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ (old('agama', $warga->agama) == 'Katolik') ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ (old('agama', $warga->agama) == 'Hindu') ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ (old('agama', $warga->agama) == 'Buddha') ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ (old('agama', $warga->agama) == 'Konghucu') ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                        @error('agama')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Perkawinan</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-heart input-icon"></i>
                            <select name="status" class="input-modern">
                                <option value="">Pilih</option>
                                <option value="Kawin" {{ (old('status', $warga->status) == 'Kawin') ? 'selected' : '' }}>Kawin</option>
                                <option value="Belum Kawin" {{ (old('status', $warga->status) == 'Belum Kawin') ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Cerai Hidup" {{ (old('status', $warga->status) == 'Cerai Hidup') ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ (old('status', $warga->status) == 'Cerai Mati') ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                        @error('status')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Section: Domisili --}}
            <div class="form-section">
                <h3 class="section-title">
                    <span class="section-icon"><i class="fa-solid fa-map-location-dot"></i></span>
                    Domisili
                </h3>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label class="form-label">Alamat <span class="required">*</span></label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-map-pin input-icon textarea-icon"></i>
                            <textarea name="alamat" class="input-modern textarea" rows="3" required>{{ old('alamat', $warga->alamat) }}</textarea>
                        </div>
                        @error('alamat')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">RW</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-building input-icon"></i>
                            <input type="text" name="rw" class="input-modern" value="{{ old('rw', $warga->rw) }}">
                        </div>
                        @error('rw')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">RT</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-house input-icon"></i>
                            <input type="text" name="rt" class="input-modern" value="{{ old('rt', $warga->rt) }}">
                        </div>
                        @error('rt')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Section: Sosial & Pekerjaan --}}
            <div class="form-section">
                <h3 class="section-title">
                    <span class="section-icon"><i class="fa-solid fa-briefcase"></i></span>
                    Sosial & Pekerjaan
                </h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Pekerjaan</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-briefcase input-icon"></i>
                            <input type="text" name="pekerjaan" class="input-modern" value="{{ old('pekerjaan', $warga->pekerjaan) }}">
                        </div>
                        @error('pekerjaan')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pendidikan Akhir</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-graduation-cap input-icon"></i>
                            <select name="pendidikan_akhir" class="input-modern">
                                <option value="">Pilih</option>
                                <option value="SD" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'SD') ? 'selected' : '' }}>SD</option>
                                <option value="SMP" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'SMP') ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'SMA') ? 'selected' : '' }}>SMA</option>
                                <option value="D1" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'D1') ? 'selected' : '' }}>D1</option>
                                <option value="D2" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'D2') ? 'selected' : '' }}>D2</option>
                                <option value="D3" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'D3') ? 'selected' : '' }}>D3</option>
                                <option value="S1" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'S1') ? 'selected' : '' }}>S1</option>
                                <option value="S2" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'S2') ? 'selected' : '' }}>S2</option>
                                <option value="S3" {{ (old('pendidikan_akhir', $warga->pendidikan_akhir) == 'S3') ? 'selected' : '' }}>S3</option>
                            </select>
                        </div>
                        @error('pendidikan_akhir')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Section: Foto --}}
            <div class="form-section">
                <h3 class="section-title">
                    <span class="section-icon"><i class="fa-solid fa-camera"></i></span>
                    Foto
                </h3>

                @if($warga->foto)
                    <div class="current-photo">
                        <p class="photo-label">Foto Saat Ini:</p>
                        <img src="{{ asset('storage/'.$warga->foto) }}" alt="Foto Warga" class="photo-preview" id="currentPhoto">
                    </div>
                @endif

                <div class="file-upload-wrapper">
                    <input type="file" name="foto" class="file-input" id="fotoInput" accept="image/*">
                    <label for="fotoInput" class="file-label">
                        <div class="file-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                        <div class="file-text">
                            <span class="file-main">Klik untuk ganti foto</span>
                            <span class="file-sub">atau drag & drop disini</span>
                        </div>
                        <div class="file-status">JPG / PNG (Max 2MB)</div>
                    </label>
                    <div class="file-preview" id="fotoPreview"></div>
                </div>
                @error('foto')<div class="error-box"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
            </div>

            {{-- Actions --}}
            <div class="form-actions">
                <a href="{{ route('admin.kelolawarga.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success" id="btnSubmit">
                    <span class="btn-text"><i class="fa-solid fa-floppy-disk"></i> Update Data</span>
                    <div class="btn-loader" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/kelolawarga/edit.js') }}"></script>
@endpush