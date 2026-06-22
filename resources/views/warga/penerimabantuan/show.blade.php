@extends('layouts.app')

@section('title', 'Detail Bantuan - ' . ($bantuan->jenisBantuan->nama_bantuan ?? 'Bantuan'))

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/warga/penerimabantuan/show.css') }}">
@endpush

@section('content')
<div class="wpb-container">

    {{-- Header --}}
    <div class="wpb-header">
        <div class="wpb-header-text">
            <h1 class="wpb-title">Detail Bantuan</h1>
            <p class="wpb-subtitle">{{ $bantuan->jenisBantuan->nama_bantuan ?? 'Bantuan' }}</p>
        </div>
    </div>

    {{-- Detail Cards --}}
    <div class="wpb-detail-grid">
        
        {{-- Card: Info Bantuan --}}
        <div class="wpb-card wpb-card-info">
            <div class="wpb-card-header">
                <h3 class="wpb-card-title"><i class="fas fa-hand-holding-heart"></i> Informasi Bantuan</h3>
            </div>
            <div class="wpb-card-body">
                <div class="wpb-detail-row">
                    <span class="wpb-detail-label">Kode Bantuan</span>
                    <span class="wpb-detail-value">{{ $bantuan->jenisBantuan->kode_bantuan ?? '-' }}</span>
                </div>
                <div class="wpb-detail-row">
                    <span class="wpb-detail-label">Nama Bantuan</span>
                    <span class="wpb-detail-value">{{ $bantuan->jenisBantuan->nama_bantuan ?? '-' }}</span>
                </div>
                <div class="wpb-detail-row">
                    <span class="wpb-detail-label">Sumber Dana</span>
                    <span class="wpb-detail-value">{{ $bantuan->jenisBantuan->sumber_dana ?? '-' }}</span>
                </div>
                <div class="wpb-detail-row">
                    <span class="wpb-detail-label">Tahun Anggaran</span>
                    <span class="wpb-detail-value">{{ $bantuan->jenisBantuan->tahunAnggaran->tahun ?? '-' }}</span>
                </div>
                <div class="wpb-detail-row">
                    <span class="wpb-detail-label">Anggaran per KK</span>
                    <span class="wpb-detail-value wpb-detail-money">
                        Rp {{ number_format($bantuan->jenisBantuan->anggaran_per_kk ?? 0, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Card: Status & Desil --}}
        <div class="wpb-card wpb-card-status">
            <div class="wpb-card-header">
                <h3 class="wpb-card-title"><i class="fas fa-info-circle"></i> Status Penerimaan</h3>
            </div>
            <div class="wpb-card-body">
                <div class="wpb-status-display">
                    <div class="wpb-status-icon">
                        @if($bantuan->status === 'aktif')
                            <i class="fas fa-check-circle wpb-status-aktif"></i>
                        @elseif($bantuan->status === 'nonaktif')
                            <i class="fas fa-pause-circle wpb-status-nonaktif"></i>
                        @else
                            <i class="fas fa-times-circle wpb-status-dicabut"></i>
                        @endif
                    </div>
                    <div class="wpb-status-text">
                        <span class="wpb-status-label">Status</span>
                        <span class="wpb-status-value">{!! $bantuan->status_badge !!}</span>
                    </div>
                </div>
                <div class="wpb-detail-row">
                    <span class="wpb-detail-label">Desil</span>
                    <span class="wpb-detail-value">
                        <span class="wpb-desil-badge {{ $bantuan->desil <= 3 ? 'wpb-desil-prioritas' : ($bantuan->desil <= 7 ? 'wpb-desil-menengah' : 'wpb-desil-tinggi') }}">
                            Desil {{ $bantuan->desil }}
                        </span>
                    </span>
                </div>
                <div class="wpb-detail-row">
                    <span class="wpb-detail-label">Tanggal Terima</span>
                    <span class="wpb-detail-value">{{ $bantuan->tanggal_terima ? $bantuan->tanggal_terima->format('d F Y') : '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Card: Keterangan --}}
        <div class="wpb-card wpb-card-full">
            <div class="wpb-card-header">
                <h3 class="wpb-card-title"><i class="fas fa-sticky-note"></i> Keterangan</h3>
            </div>
            <div class="wpb-card-body">
                <div class="wpb-keterangan-box">
                    {{ $bantuan->keterangan ?? 'Tidak ada keterangan tambahan.' }}
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="wpb-back-section">
        <a href="{{ route('warga.penerimabantuan.index') }}" class="wpb-btn-back-bottom">
            Kembali
        </a>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/penerimabantuan/show.js') }}"></script>
@endpush