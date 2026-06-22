@extends('layouts.admin')

@section('title', 'Detail Alokasi - ' . $pengalokasian->nama_kegiatan)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/pengalokasian.css') }}">
@endpush

@section('content')
<div class="pengalokasian-page pengalokasian-show">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title"> {{ $pengalokasian->nama_kegiatan }}</h1>
            <span class="status-badge status-{{ $pengalokasian->status }}">{{ strtoupper($pengalokasian->status) }}</span>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.apbdes.pengalokasian.edit', $pengalokasian->id) }}" class="btn btn-warning">
                Edit
            </a>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    @php
        $persenRealisasi = $pengalokasian->nominal > 0 ? ($pengalokasian->total_realisasi / $pengalokasian->nominal) * 100 : 0;
    @endphp

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-info-wrapper">
                <span class="stat-label">Nominal Alokasi</span>
                <span class="stat-value" data-counter>Rp {{ number_format($pengalokasian->nominal, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-info-wrapper">
                <span class="stat-label">Realisasi Terverifikasi</span>
                <span class="stat-value" data-counter>Rp {{ number_format($pengalokasian->total_realisasi, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-info-wrapper">
                <span class="stat-label">Sisa Alokasi</span>
                <span class="stat-value {{ $pengalokasian->sisa < 0 ? 'text-danger' : '' }}" data-counter>
                    Rp {{ number_format($pengalokasian->sisa, 0, ',', '.') }}
                </span>
            </div>
        </div>
        <div class="stat-card stat-info">
            <div class="stat-info-wrapper">
                <span class="stat-label">Progress</span>
                <span class="stat-value">{{ number_format($persenRealisasi, 1) }}%</span>
            </div>
        </div>
    </div>

    {{-- Progress --}}
    <div class="card">
        <div class="card-body">
            <div class="progress-section">
                <span class="progress-label">Progress Realisasi</span>
                <div class="progress-track">
                <div class="progress-bar-fill"></div>
                </div>
                <span class="progress-percent">{{ number_format($persenRealisasi, 1) }}%</span>
            </div>
        </div>
    </div>

    {{-- Detail Info --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Informasi Kegiatan</h2>
        </div>
        <div class="card-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Bidang</span>
                    <span class="detail-value">
                        <span class="bidang-badge">{{ $pengalokasian->bidangAnggaran->kode_bidang ?? '-' }}</span>
                        {{ $pengalokasian->bidangAnggaran->nama_bidang ?? '-' }}
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Sumber Dana</span>
                    <span class="detail-value">
                        <span class="jenis-badge jenis-{{ $pengalokasian->sumberDana->jenis ?? 'lainnya' }}">
                            {{ strtoupper($pengalokasian->sumberDana->jenis ?? '-') }}
                        </span>
                        {{ $pengalokasian->sumberDana->nama_sumber ?? '-' }}
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Target Triwulan</span>
                    <span class="detail-value">Triwulan {{ $pengalokasian->triwulan_target ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Dibuat Oleh</span>
                    <span class="detail-value">{{ $pengalokasian->creator->name ?? '-' }}</span>
                </div>
                <div class="detail-item detail-full">
                    <span class="detail-label">Detail Kegiatan</span>
                    <span class="detail-value">{{ $pengalokasian->detail_kegiatan ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Realisasi --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Realisasi Bulanan</h2>
            <span class="count-badge">{{ $pengalokasian->realisasis->count() }}</span>
        </div>
        <div class="card-body">
            @if($pengalokasian->realisasis->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Bulan</th>
                            <th>Triwulan</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Status</th>
                            <th>Verifikator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengalokasian->realisasis as $realisasi)
                        <tr>
                            <td>{{ $realisasi->bulan }}/{{ $realisasi->tahun }}</td>
                            <td>TW {{ $realisasi->triwulan }}</td>
                            <td class="text-right">Rp {{ number_format($realisasi->nominal_digunakan, 0, ',', '.') }}</td>
                            <td>{{ Str::limit($realisasi->keterangan_pemakaian, 30) }}</td>
                            <td>
                                <span class="status-badge status-{{ $realisasi->status }}">
                                    {{ strtoupper($realisasi->status) }}
                                </span>
                            </td>
                            <td>{{ $realisasi->verifier->name ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state-sm">
                <p>Belum ada realisasi</p>
            </div>
            @endif
        </div>
    </div>

    <div class="back-actions">
        <a href="{{ route('admin.apbdes.pengalokasian.index') }}" class="btn btn-outline">
            Kembali ke List
        </a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/pengalokasian.js') }}"></script>
@endpush