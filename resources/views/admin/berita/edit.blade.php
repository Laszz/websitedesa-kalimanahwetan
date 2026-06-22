@extends('layouts.admin')

@section('title', 'Edit Berita')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/berita/edit.css') }}">
@endpush

@section('content')
<div class="berita-page berita-edit">

    {{-- Header --}}
    <div class="berita-header">
        <div class="header-content">
            <h1 class="berita-title">
                <span class="berita-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                Edit Berita
            </h1>
            <p class="berita-subtitle">Ubah data berita yang sudah ada</p>
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

        <form action="{{ route('admin.berita.update', $berita->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="form-section"
              id="editForm">

            @csrf
            @method('PUT')

            {{-- Judul --}}
            <div class="form-group">
                <label for="judul">
                    <i class="fa-solid fa-heading"></i> Judul Berita
                </label>
                <input type="text"
                       name="judul"
                       id="judul"
                       value="{{ old('judul', $berita->judul) }}"
                       class="input {{ $errors->has('judul') ? 'input-error' : '' }}"
                       required>
                @if($errors->has('judul'))
                    <span class="error-text">{{ $errors->first('judul') }}</span>
                @endif
            </div>

            {{-- Ringkasan --}}
            <div class="form-group">
                <label for="ringkasan">
                    <i class="fa-solid fa-align-left"></i> Ringkasan
                </label>
                <textarea name="ringkasan"
                          id="ringkasan"
                          rows="3"
                          class="input {{ $errors->has('ringkasan') ? 'input-error' : '' }}"
                          required>{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                @if($errors->has('ringkasan'))
                    <span class="error-text">{{ $errors->first('ringkasan') }}</span>
                @endif
            </div>

            {{-- Deskripsi --}}
            <div class="form-group">
                <label for="deskripsi">
                    <i class="fa-solid fa-align-justify"></i> Deskripsi Lengkap
                </label>
                <textarea name="deskripsi"
                          id="deskripsi"
                          rows="6"
                          class="input {{ $errors->has('deskripsi') ? 'input-error' : '' }}"
                          required>{{ old('deskripsi', $berita->deskripsi) }}</textarea>
                @if($errors->has('deskripsi'))
                    <span class="error-text">{{ $errors->first('deskripsi') }}</span>
                @endif
            </div>

            {{-- Tanggal --}}
            <div class="form-group">
                <label for="tanggal">
                    <i class="fa-regular fa-calendar"></i> Tanggal Publikasi
                </label>
                <input type="date"
                       name="tanggal"
                       id="tanggal"
                       value="{{ old('tanggal', $berita->tanggal) }}"
                       class="input {{ $errors->has('tanggal') ? 'input-error' : '' }}"
                       required>
                @if($errors->has('tanggal'))
                    <span class="error-text">{{ $errors->first('tanggal') }}</span>
                @endif
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
                        <i class="fa-solid fa-cloud-arrow-up"></i> Klik atau ganti gambar
                    </span>
                </div>

                <div class="file-preview" id="filePreview">
                    <img id="previewImg"
                         src="{{ asset('storage/'.$berita->gambar) }}"
                         alt="{{ $berita->judul }}">
                    <button type="button" class="file-preview-remove" id="fileRemove" title="Hapus gambar">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <span class="file-preview-label">Gambar saat ini</span>
                </div>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label for="tampilkan">
                    <i class="fa-solid fa-eye"></i> Status Publikasi
                </label>
                <div class="select-wrapper">
                    <select name="tampilkan" id="tampilkan" class="input input-select">
                        <option value="draf" {{ old('tampilkan', $berita->tampilkan) == 'draf' ? 'selected' : '' }}>Draf</option>
                        <option value="tampilkan" {{ old('tampilkan', $berita->tampilkan) == 'tampilkan' ? 'selected' : '' }}>Tampilkan</option>
                    </select>
                    <span class="status-indicator" id="statusIndicator"></span>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fa-solid fa-floppy-disk"></i> Update Berita
                </button>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/berita/edit.js') }}"></script>
@endpush