@extends('layouts.app')

@section('title', $berita->judul)

@section('content')
<div class="berita-show-container">

    {{-- Header --}}
    <div class="berita-header">
        <span class="berita-tanggal">
            {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('l, d F Y') }}
        </span>
        <h1 class="judul">{{ $berita->judul }}</h1>
        <p class="ringkasan">{{ $berita->ringkasan }}</p>
    </div>

    {{-- Gambar --}}
    @if($berita->gambar)
    <div class="gambar-wrapper">
        <img src="{{ asset('storage/'.$berita->gambar) }}" 
             alt="Gambar {{ $berita->judul }}" 
             id="beritaImage"
             loading="lazy">
        <div class="gambar-caption">Klik gambar untuk memperbesar</div>
    </div>
    @endif

    {{-- Deskripsi --}}
    <div class="deskripsi">
        {!! nl2br(e($berita->deskripsi)) !!}
    </div>

    {{-- Share --}}
    <div class="share-section">
        <span>Bagikan:</span>
        <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . url()->current()) }}" 
           target="_blank" class="share-btn wa">WhatsApp</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
           target="_blank" class="share-btn fb">Facebook</a>
    </div>

    {{-- Navigasi --}}
    <div class="navigasi">
        <a href="{{ route('berita.index') }}" class="back-btn">
            Kembali Ke Daftar Berita
        </a>
    </div>
</div>

{{-- Lightbox --}}
<div id="lightbox" class="lightbox-hidden">
    <div class="lightbox-content">
        <button id="closeLightbox" class="lightbox-close">&times;</button>
        <img src="" alt="Zoom Gambar" id="lightboxImg">
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/warga/berita/show.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/warga/berita/show.js') }}"></script>
@endpush