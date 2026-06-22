@extends('layouts.app')

@section('title', 'Galeri Desa')

@section('content')
<div class="galeri-container">
    <h2 class="galeri-title">Galeri Kegiatan Desa</h2>

    <!-- Search -->
    <form method="GET" action="{{ route('galeri.index') }}" class="search-box">
        <input type="text" name="search" placeholder="Cari kegiatan desa..." value="{{ request('search') }}">
    </form>

    <!-- Grid Galeri -->
    <div class="galeri-grid">
        @forelse($galeri as $item)
            @php
                $gambarUrl = asset('storage/' . $item->gambar);
                $judulEscaped = htmlspecialchars($item->judul, ENT_QUOTES, 'UTF-8');
            @endphp
            
            <div class="galeri-card">
                <div class="galeri-image">
                    <img src="{{ $gambarUrl }}"
                         alt="{{ $judulEscaped }}"
                         loading="lazy"
                         data-gambar="{{ $gambarUrl }}"
                         data-judul="{{ $judulEscaped }}"
                         onclick="openPreviewFromData(this)">
                    <div class="galeri-overlay">
                        <span class="zoom-icon">🔍</span>
                    </div>
                </div>
                <div class="galeri-content">
                    <h3>{{ $item->judul }}</h3>
                    <p class="deskripsi">{{ Str::limit($item->deskripsi, 100) }}</p>
                    <div class="galeri-meta">
                        <span class="tanggal">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                        </span>
                        <span class="badge {{ $item->tampilkan === 'tampilkan' ? 'aktif' : 'draf' }}">
                            {{ $item->tampilkan === 'tampilkan' ? 'Kegiatan' : 'Draf' }}
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.5">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                    <polyline points="21 15 16 10 5 21"></polyline>
                </svg>
                <p>Belum ada foto kegiatan.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $galeri->links() }}
    </div>
</div>

<!-- Modal Preview -->
<div id="previewModal" class="preview-modal">
    <span class="close" onclick="closePreview()">✕</span>
    <div class="preview-wrapper">
        <img id="previewImage" class="preview-content">
        <div class="preview-caption">
            <h3 id="previewTitle"></h3>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/galeri/index.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/warga/galeri/index.js') }}"></script>
@endpush