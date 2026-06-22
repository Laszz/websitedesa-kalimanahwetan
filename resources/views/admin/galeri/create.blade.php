@extends('layouts.admin')

@section('title', 'Tambah Galeri')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/galeri/create.css') }}">
@endpush

@section('content')
<div class="galeri-page galeri-create">

    {{-- Header --}}
    <div class="galeri-header">
        <div class="header-content">
            <h1 class="galeri-title">
                <span class="galeri-icon"><i class="fa-solid fa-circle-plus"></i></span>
                Tambah Foto ke Galeri
            </h1>
            <p class="galeri-subtitle">Upload foto baru ke galeri desa</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="galeri-alert galeri-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="galeri-alert galeri-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Card --}}
    <div class="galeri-card form-card">

        {{-- Error Display --}}
        @if ($errors->any())
            <div class="galeri-alert galeri-alert-error">
                <span class="alert-icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                <div class="alert-text">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
            </div>
        @endif

        <form action="{{ route('admin.galeri.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="form-section"
              id="createForm">

            @csrf

            {{-- Judul --}}
            <div class="form-group">
                <label for="judul">
                    <i class="fa-solid fa-heading"></i> Judul Foto
                </label>
                <input type="text"
                       name="judul"
                       id="judul"
                       value="{{ old('judul') }}"
                       placeholder="Masukkan judul foto..."
                       class="input {{ $errors->has('judul') ? 'input-error' : '' }}"
                       required>
                @if($errors->has('judul'))
                    <span class="error-text">{{ $errors->first('judul') }}</span>
                @endif
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="deskripsi">
                    <i class="fa-solid fa-align-left"></i> Deskripsi
                </label>
                <textarea name="deskripsi"
                          id="deskripsi"
                          rows="4"
                          placeholder="Tulis deskripsi singkat..."
                          class="input {{ $errors->has('deskripsi') ? 'input-error' : '' }}">{{ old('deskripsi') }}</textarea>
                @if($errors->has('deskripsi'))
                    <span class="error-text">{{ $errors->first('deskripsi') }}</span>
                @endif
            </div>

            {{-- Tanggal --}}
            <div class="form-group">
                <label for="tanggal">
                    <i class="fa-regular fa-calendar"></i> Tanggal Foto
                </label>
                <input type="date"
                       name="tanggal"
                       id="tanggal"
                       value="{{ old('tanggal') }}"
                       class="input {{ $errors->has('tanggal') ? 'input-error' : '' }}"
                       required>
                @if($errors->has('tanggal'))
                    <span class="error-text">{{ $errors->first('tanggal') }}</span>
                @endif
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="tampilkan">
                    <i class="fa-solid fa-eye"></i> Tampilkan?
                </label>
                <div class="select-wrapper">
                    <select name="tampilkan"
                            id="tampilkan"
                            class="input input-select {{ $errors->has('tampilkan') ? 'input-error' : '' }}"
                            required>
                        <option value="tampilkan" {{ old('tampilkan') == 'tampilkan' ? 'selected' : '' }}>Ya</option>
                        <option value="draf" {{ old('tampilkan') == 'draf' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    <span class="status-indicator" id="statusIndicator"></span>
                </div>
                @if($errors->has('tampilkan'))
                    <span class="error-text">{{ $errors->first('tampilkan') }}</span>
                @endif
            </div>

            {{-- Upload Foto --}}
            <div class="form-group">
                <label for="gambar">
                    <i class="fa-solid fa-image"></i> Upload Foto
                </label>
                <div class="file-upload-area">
                    <input type="file"
                           name="gambar"
                           id="gambar"
                           class="input input-file"
                           accept="image/*"
                           required>
                    <span class="file-hint">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Klik atau drag foto ke sini
                    </span>
                </div>

                <div class="file-preview" id="filePreview" style="display: none;">
                    <img id="previewImg" alt="Preview Foto">
                    <button type="button" class="file-preview-remove" id="fileRemove" title="Hapus foto">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                @if($errors->has('gambar'))
                    <span class="error-text">{{ $errors->first('gambar') }}</span>
                @endif
            </div>

            {{-- Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/galeri/create.js') }}"></script>
@endpush