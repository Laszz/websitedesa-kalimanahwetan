@extends('layouts.app')

@section('title', 'Daftar Layanan')

@section('content')
<div class="layanan-container">
    <div class="layanan-header">
        <h1 class="layanan-title">Layanan Penduduk</h1>
        <p class="layanan-subtitle">Pilih layanan yang Anda butuhkan untuk mempermudah urusan administrasi desa</p>
    </div>

    <!-- Filter -->
    <div class="filter-box">
        <button class="filter-btn active" data-filter="all">

            <span>Semua</span>
        </button>
        <button class="filter-btn" data-filter="layanan_administrasi_penduduk">
            <span>Adm Penduduk</span>
        </button>
        <button class="filter-btn" data-filter="layanan_administrasi_umum">
            <span>Adm Umum</span>
        </button>
        <button class="filter-btn" data-filter="layanan_hukum_tanah">
            <span>Hukum & Tanah</span>
        </button>
    </div>

    <!-- Counter -->
    <div class="layanan-counter">
        <span id="counterText">Menampilkan <strong>{{ count($layanan) }}</strong> layanan</span>
    </div>

    <!-- Grid Card -->
    <div class="layanan-grid" id="layananGrid">
        @forelse ($layanan as $item)
        <div class="layanan-card" data-kategori="{{ $item->kategori }}">
            <div class="card-icon">
                @switch($item->kategori)
                    @case('layanan_administrasi_penduduk')
                        @break
                    @case('layanan_administrasi_umum')
                        @break
                    @case('layanan_hukum_tanah')
                        @break
                    @default
                @endswitch
            </div>
            
            <div class="card-content">
                <span class="kategori-badge">
                    {{ str_replace('_', ' ', $item->kategori) }}
                </span>
                
                <h3 class="card-title">{{ $item->nama_layanan }}</h3>
                
                <p class="card-deskripsi">
                    {{ Str::limit($item->deskripsi, 120) }}
                </p>
                
                <div class="card-footer">
                    <a href="{{ route('warga.layananpenduduk.show', $item->id) }}" class="btn-detail">
                        <span>Detail</span>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <h3>Belum ada layanan</h3>
            <p>Layanan akan segera ditambahkan oleh admin desa.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/layananpenduduk/index.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/warga/layananpenduduk/index.js') }}"></script>
@endpush