@extends('layouts.admin')

@section('title', 'Tambah Berita')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/berita/create.css') }}">
@endpush

@section('content')
<div class="berita-page berita-create">

    {{-- Header --}}
    <div class="berita-header">
        <div class="header-content">
            <h1 class="berita-title">
                <span class="berita-icon"><i class="fa-solid fa-circle-plus"></i></span>
                Tambah Berita
            </h1>
            <p class="berita-subtitle">Buat berita atau pengumuman baru</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="berita-alert berita-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="berita-alert berita-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Card --}}
    <div class="berita-card form-card">

        {{-- Error Display --}}
        @if ($errors->any())
            <div class="berita-alert berita-alert-error">
                <span class="alert-icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                <div class="alert-text">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
            </div>
        @endif

        <form action="{{ route('admin.berita.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="form-section"
              id="createForm">

            @csrf

            {{-- Judul --}}
            <div class="form-group">
                <label for="judul">
                    <i class="fa-solid fa-heading"></i> Judul Berita
                </label>
                <input type="text"
                       name="judul"
                       id="judul"
                       value="{{ old('judul') }}"
                       placeholder="Masukkan judul berita..."
                       class="input"
                       required>
            </div>

            {{-- Ringkasan --}}
            <div class="form-group">
                <label for="ringkasan">
                    <i class="fa-solid fa-align-left"></i> Ringkasan
                </label>
                <textarea name="ringkasan"
                          id="ringkasan"
                          rows="3"
                          placeholder="Tulis ringkasan singkat..."
                          class="input">{{ old('ringkasan') }}</textarea>
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="deskripsi">
                    <i class="fa-solid fa-align-justify"></i> Deskripsi Lengkap
                </label>
                <textarea name="deskripsi"
                          id="deskripsi"
                          rows="6"
                          placeholder="Isi detail berita..."
                          class="input">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- Tanggal --}}
            <div class="form-group">
                <label for="tanggal">
                    <i class="fa-regular fa-calendar"></i> Tanggal Publikasi
                </label>
                <input type="date"
                       name="tanggal"
                       id="tanggal"
                       value="{{ old('tanggal') }}"
                       class="input"
                       required>
            </div>

            {{-- Gambar --}}
            <div class="form-group">
                <label for="gambar">
                    <i class="fa-solid fa-image"></i> Gambar Berita
                </label>
                <div class="file-upload-area">
                    <input type="file"
                           name="gambar"
                           id="gambar"
                           class="input input-file"
                           accept="image/*">
                    <span class="file-hint">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Klik atau drag gambar ke sini
                    </span>
                </div>

                <div class="file-preview" id="filePreview" style="display: none;">
                    <img id="previewImg" alt="Preview Gambar">
                    <button type="button" class="file-preview-remove" id="fileRemove" title="Hapus gambar">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="tampilkan">
                    <i class="fa-solid fa-eye"></i> Status Publikasi
                </label>
                <div class="select-wrapper">
                    <select name="tampilkan" id="tampilkan" class="input input-select">
                        <option value="draf" {{ old('tampilkan') == 'draf' ? 'selected' : '' }}>Draf</option>
                        <option value="tampilkan" {{ old('tampilkan') == 'tampilkan' ? 'selected' : '' }}>Tampilkan</option>
                    </select>
                    <span class="status-indicator" id="statusIndicator"></span>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Berita
                </button>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/berita/create.js') }}"></script>
@endpush