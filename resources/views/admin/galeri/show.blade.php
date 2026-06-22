@extends('layouts.admin')

@section('title', 'Detail Galeri')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/galeri/show.css') }}">
@endpush

@section('content')
<div class="galeri-page galeri-show">

    {{-- Header --}}
    <div class="galeri-header">
        <div class="header-content">
            <h1 class="galeri-title">
                <span class="galeri-icon"><i class="fa-solid fa-circle-info"></i></span>
                Detail Galeri
            </h1>
            <p class="galeri-subtitle">Informasi lengkap foto galeri desa</p>
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

    {{-- Detail Card --}}
    <div class="galeri-card detail-card">

        {{-- Status Badge --}}
        <div class="detail-status">
            @if($galeri->tampilkan === 'tampilkan')
                <span class="status-badge status-tampil">
                    <i class="fa-solid fa-eye"></i> Ditampilkan
                </span>
            @else
                <span class="status-badge status-draf">
                    <i class="fa-solid fa-eye-slash"></i> Disembunyikan
                </span>
            @endif
        </div>

        {{-- Content Grid --}}
        <div class="detail-grid">

            {{-- Gambar --}}
            <div class="detail-image">
                <div class="image-wrapper">
                    <img src="{{ asset('storage/' . $galeri->gambar) }}"
                         alt="{{ $galeri->judul }}"
                         class="gambar-detail"
                         onerror="this.style.display='none'; this.parentElement.querySelector('.image-error').style.display='flex';">
                    <div class="image-error" style="display: none;">
                        <i class="fa-solid fa-image"></i>
                        <span>Gambar tidak tersedia</span>
                    </div>
                    <div class="image-zoom-hint">
                        <i class="fa-solid fa-magnifying-glass-plus"></i> Klik untuk zoom
                    </div>
                </div>
            </div>

            {{-- Info --}}
            <div class="detail-info">

                <div class="detail-section">
                    <span class="section-label">
                        <i class="fa-solid fa-heading"></i> Judul Foto
                    </span>
                    <h2 class="detail-title">{{ $galeri->judul }}</h2>
                </div>

                <div class="detail-section">
                    <span class="section-label">
                        <i class="fa-regular fa-calendar"></i> Tanggal Foto
                    </span>
                    <div class="detail-meta">
                        <i class="fa-regular fa-clock"></i>
                        <span>{{ \Carbon\Carbon::parse($galeri->tanggal)->format('d F Y') }}</span>
                    </div>
                </div>

                <div class="detail-section">
                    <span class="section-label">
                        <i class="fa-solid fa-align-left"></i> Deskripsi
                    </span>
                    <div class="detail-deskripsi">
                        {{ $galeri->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </div>
                </div>

            </div>
        </div>

        {{-- Actions --}}
        <div class="detail-actions">
            <a href="{{ route('admin.galeri.edit', $galeri->id) }}" class="btn btn-edit">
                <i class="fa-solid fa-pen"></i> Edit
            </a>

            <form action="{{ route('admin.galeri.destroy', $galeri->id) }}"
                  method="POST"
                  class="delete-form"
                  data-name="{{ Str::limit($galeri->judul, 30) }}"
                  onsubmit="return confirmDelete(event)">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete">
                    <i class="fa-solid fa-trash"></i> Hapus
                </button>
            </form>

            <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/galeri/show.js') }}"></script>
@endpush