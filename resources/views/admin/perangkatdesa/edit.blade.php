@extends('layouts.admin')

@section('title', 'Edit Perangkat Desa')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/perangkatdesa/edit.css') }}">
@endpush

@section('content')
<div class="perangkat-page perangkat-edit">

    {{-- Header --}}
    <div class="perangkat-header">
        <div class="header-content">
            <h1 class="perangkat-title">
                <span class="perangkat-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                Edit Perangkat Desa
            </h1>
            <p class="perangkat-subtitle">Ubah data perangkat dan jabatan desa</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="perangkat-alert perangkat-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="perangkat-alert perangkat-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Card --}}
    <div class="perangkat-card form-card">

        {{-- Error Display --}}
        @if ($errors->any())
            <div class="perangkat-alert perangkat-alert-error">
                <span class="alert-icon"><i class="fa-solid fa-circle-exclamation"></i></span>
                <div class="alert-text">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
                <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
            </div>
        @endif

        <form action="{{ route('admin.perangkatdesa.update', $perangkatdesa->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="form-section"
              id="editForm">

            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="form-group">
                <label for="nama">
                    <i class="fa-solid fa-user"></i> Nama
                </label>
                <input type="text"
                       name="nama"
                       id="nama"
                       value="{{ old('nama', $perangkatdesa->nama) }}"
                       placeholder="Masukkan nama perangkat..."
                       class="input {{ $errors->has('nama') ? 'input-error' : '' }}"
                       required>
                @if($errors->has('nama'))
                    <span class="error-text">{{ $errors->first('nama') }}</span>
                @endif
            </div>

            {{-- Jabatan --}}
            <div class="form-group">
                <label for="jabatan">
                    <i class="fa-solid fa-id-badge"></i> Jabatan
                </label>
                <input type="text"
                       name="jabatan"
                       id="jabatan"
                       value="{{ old('jabatan', $perangkatdesa->jabatan) }}"
                       placeholder="Contoh: Kepala Desa, Sekretaris..."
                       class="input {{ $errors->has('jabatan') ? 'input-error' : '' }}"
                       required>
                @if($errors->has('jabatan'))
                    <span class="error-text">{{ $errors->first('jabatan') }}</span>
                @endif
            </div>

            {{-- Urutan --}}
            <div class="form-group">
                <label for="urutan">
                    <i class="fa-solid fa-arrow-up-1-9"></i> Urutan
                </label>
                <input type="number"
                       name="urutan"
                       id="urutan"
                       value="{{ old('urutan', $perangkatdesa->urutan) }}"
                       placeholder="0"
                       class="input {{ $errors->has('urutan') ? 'input-error' : '' }}"
                       min="0">
                @if($errors->has('urutan'))
                    <span class="error-text">{{ $errors->first('urutan') }}</span>
                @endif
                <span class="hint-text">Urutan tampil di halaman publik (1 = pertama)</span>
            </div>

            {{-- Foto --}}
            <div class="form-group">
                <label for="foto">
                    <i class="fa-solid fa-camera"></i> Ganti Foto
                </label>
                <div class="file-upload-area">
                    <input type="file"
                           name="foto"
                           id="foto"
                           class="input input-file"
                           accept="image/*">
                    <span class="file-hint">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Klik atau drag foto baru ke sini
                    </span>
                </div>

                <div class="file-preview" id="filePreview">
                    <img id="previewImg"
                         src="{{ $perangkatdesa->foto ? asset('storage/'.$perangkatdesa->foto) : '' }}"
                         alt="{{ $perangkatdesa->nama }}"
                         class="{{ $perangkatdesa->foto ? '' : 'hidden' }}">
                    <div class="file-error" id="fileError">
                        <i class="fa-solid fa-user"></i>
                        <span>Tidak ada foto</span>
                    </div>
                    <button type="button" class="file-preview-remove" id="fileRemove" title="Hapus foto">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                    <span class="file-preview-label" id="fileLabel">Foto saat ini</span>
                </div>

                @if($errors->has('foto'))
                    <span class="error-text">{{ $errors->first('foto') }}</span>
                @endif
            </div>

            {{-- Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fa-solid fa-floppy-disk"></i> Update
                </button>
                <a href="{{ route('admin.perangkatdesa.index') }}" class="btn btn-secondary">Batal</a>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/perangkatdesa/edit.js') }}"></script>
@endpush