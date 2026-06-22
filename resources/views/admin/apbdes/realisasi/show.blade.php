@extends('layouts.admin')

@section('title', 'Detail Realisasi')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/realisasi.css') }}">
@endpush

@section('content')
<div class="realisasi-page realisasi-show">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title"><i class="fas fa-eye"></i> Detail Realisasi</h1>
            <span class="status-badge status-{{ $realisasi->status }}">{{ strtoupper($realisasi->status) }}</span>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.apbdes.realisasi.edit', $realisasi->id) }}" class="btn btn-warning">
                <i class="fas fa-pen-to-square"></i> Edit
            </a>
            @if($realisasi->status === 'pending')
                <a href="{{ route('admin.apbdes.realisasi.show-verify', $realisasi->id) }}" class="btn btn-success">
                    <i class="fas fa-check-circle"></i> Verifikasi
                </a>
            @endif
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon"><i class="fas fa-circle-check"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span class="alert-icon"><i class="fas fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
        </div>
    @endif

    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <span class="stat-icon"><i class="fas fa-money-bill-wave"></i></span>
            <div class="stat-info-wrapper">
                <span class="stat-label">Nominal Digunakan</span>
                <span class="stat-value" data-counter>Rp {{ number_format($realisasi->nominal_digunakan, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-card stat-info-accent">
            <span class="stat-icon"><i class="fas fa-calendar-alt"></i></span>
            <div class="stat-info-wrapper">
                <span class="stat-label">Periode</span>
                <span class="stat-value">{{ $realisasi->bulan }}/{{ $realisasi->tahun }} (TW {{ $realisasi->triwulan }})</span>
            </div>
        </div>
        <div class="stat-card stat-success">
            <span class="stat-icon"><i class="fas fa-user-check"></i></span>
            <div class="stat-info-wrapper">
                <span class="stat-label">Verifikator</span>
                <span class="stat-value">{{ $realisasi->verifier->name ?? 'Belum Diverifikasi' }}</span>
            </div>
        </div>
        <div class="stat-card stat-warning">
            <span class="stat-icon"><i class="fas fa-user"></i></span>
            <div class="stat-info-wrapper">
                <span class="stat-label">Dibuat Oleh</span>
                <span class="stat-value">{{ $realisasi->creator->name ?? '-' }}</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-clipboard-list"></i> Informasi Realisasi</h2>
        </div>
        <div class="card-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-tasks"></i> Kegiatan</span>
                    <span class="detail-value">{{ $realisasi->pengalokasian->nama_kegiatan ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-layer-group"></i> Bidang</span>
                    <span class="detail-value">{{ $realisasi->pengalokasian->bidangAnggaran->nama_bidang ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-coins"></i> Sumber Dana</span>
                    <span class="detail-value">{{ $realisasi->sumberDana->nama_sumber ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-clock"></i> Tanggal Dibuat</span>
                    <span class="detail-value">{{ $realisasi->created_at->format('d M Y H:i') }}</span>
                </div>
                @if($realisasi->verified_at)
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-check-double"></i> Tanggal Verifikasi</span>
                    <span class="detail-value">{{ $realisasi->verified_at->format('d M Y H:i') }}</span>
                </div>
                @endif
                <div class="detail-item detail-full">
                    <span class="detail-label"><i class="fas fa-align-left"></i> Keterangan Pemakaian</span>
                    <span class="detail-value">{{ $realisasi->keterangan_pemakaian }}</span>
                </div>
                @if($realisasi->bukti_transaksi)
                <div class="detail-item detail-full">
                    <span class="detail-label"><i class="fas fa-file-pdf"></i> Bukti Transaksi</span>
                    <span class="detail-value">
                        <a href="{{ Storage::url($realisasi->bukti_transaksi) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-file-pdf"></i> Lihat Bukti
                        </a>
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="back-actions">
        <a href="{{ route('admin.apbdes.realisasi.index') }}" class="btn btn-outline">Kembali ke List</a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/realisasi.js') }}"></script>
@endpush