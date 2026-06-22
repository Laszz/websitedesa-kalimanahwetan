@extends('layouts.admin')

@section('title', 'Detail Berita')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/berita/show.css') }}">
@endpush

@section('content')
<div class="berita-page berita-show">

    {{-- Header --}}
    <div class="berita-header">
        <div class="header-content">
            <h1 class="berita-title">
                <span class="berita-icon"><i class="fa-solid fa-newspaper"></i></span>
                Detail Berita
            </h1>
            <p class="berita-subtitle">Informasi lengkap berita desa</p>
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

    {{-- Detail Card --}}
    <div class="berita-card detail-card">

        {{-- Status Badge --}}
        <div class="detail-status">
            @if($berita->tampilkan == 'tampilkan')
                <span class="status-badge status-tampil">
                    <i class="fa-solid fa-eye"></i> Ditampilkan
                </span>
            @else
                <span class="status-badge status-draf">
                    <i class="fa-solid fa-eye-slash"></i> Draf
                </span>
            @endif
        </div>

        {{-- Judul --}}
        <div class="detail-section">
            <span class="section-label">
                <i class="fa-solid fa-heading"></i> Judul Berita
            </span>
            <h2 class="detail-title">{{ $berita->judul }}</h2>
        </div>

        {{-- Tanggal --}}
        <div class="detail-section">
            <span class="section-label">
                <i class="fa-regular fa-calendar"></i> Tanggal Publikasi
            </span>
            <div class="detail-meta">
                <i class="fa-regular fa-clock"></i>
                <span>{{ \Carbon\Carbon::parse($berita->tanggal)->format('d F Y') }}</span>
            </div>
        </div>

        {{-- Gambar --}}
        <div class="detail-section">
            <span class="section-label">
                <i class="fa-solid fa-image"></i> Gambar Berita
            </span>
            <div class="gambar-wrapper">
                <img src="{{ asset('storage/'.$berita->gambar) }}"
                     alt="{{ $berita->judul }}"
                     class="gambar-detail"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="gambar-error" style="display: none;">
                    <i class="fa-solid fa-image"></i>
                    <span>Gambar tidak tersedia</span>
                </div>
            </div>
        </div>

        {{-- Ringkasan --}}
        <div class="detail-section">
            <span class="section-label">
                <i class="fa-solid fa-align-left"></i> Ringkasan
            </span>
            <blockquote class="detail-ringkasan">
                <i class="fa-solid fa-quote-left quote-icon"></i>
                {{ $berita->ringkasan }}
            </blockquote>
        </div>

        {{-- Deskripsi --}}
        <div class="detail-section">
            <span class="section-label">
                <i class="fa-solid fa-align-justify"></i> Deskripsi Lengkap
            </span>
            <div class="detail-deskripsi">
                {!! nl2br(e($berita->deskripsi)) !!}
            </div>
        </div>

        {{-- Actions --}}
        <div class="detail-actions">
            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-primary">
                <i class="fa-solid fa-pen"></i> Edit Berita
            </a>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/berita/show.js') }}"></script>
@endpush