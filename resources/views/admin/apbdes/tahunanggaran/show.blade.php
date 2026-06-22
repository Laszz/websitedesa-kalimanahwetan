@extends('layouts.admin')

@section('title', 'Detail Tahun Anggaran ' . $tahun->tahun)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/tahunanggaran.css') }}">
@endpush

@section('content')
<div class="tahunanggaran-page tahunanggaran-show">
    
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Detail Tahun Anggaran {{ $tahun->tahun }}</h1>
            <span class="status-badge status-{{ $tahun->status }}">{{ strtoupper($tahun->status) }}</span>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.apbdes.tahun.edit', $tahun->id) }}" class="btn btn-warning">
                <span class="btn-icon"></span> Edit
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

    {{-- Ringkasan Keuangan --}}
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-info">
                <span class="stat-label">Total Anggaran</span>
                <span class="stat-value" data-counter>Rp {{ number_format($tahun->total_anggaran, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-info">
                <span class="stat-label">Total Realisasi</span>
                <span class="stat-value" data-counter>Rp {{ number_format($tahun->total_realisasi, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-info">
                <span class="stat-label">Sisa Anggaran</span>
                <span class="stat-value {{ $tahun->sisa < 0 ? 'text-danger' : '' }}" data-counter>
                    Rp {{ number_format($tahun->sisa, 0, ',', '.') }}
                </span>
            </div>
        </div>
        <div class="stat-card stat-info">
            <div class="stat-info">
                <span class="stat-label">Persentase Realisasi</span>
                <span class="stat-value">
                    @php
                        $persen = $tahun->total_anggaran > 0 
                            ? ($tahun->total_realisasi / $tahun->total_anggaran) * 100 
                            : 0;
                    @endphp
                    {{ number_format($persen, 1) }}%
                </span>
            </div>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div class="card">
        <div class="card-body">
            <div class="progress-section" data-progress="{{ min($persen, 100) }}">
                <span class="progress-label">Progress Realisasi</span>
                <div class="progress-track">
                    <div class="progress-bar-fill"></div>
                </div>
                <span class="progress-percent">{{ number_format($persen, 1) }}%</span>
            </div>
        </div>
    </div>

    {{-- Sumber Dana --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Sumber Dana</h2>
            <span class="count-badge">{{ $tahun->sumberDanas->count() }}</span>
        </div>
        <div class="card-body">
            @if($tahun->sumberDanas->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Nama Sumber</th>
                            <th>Nominal Awal</th>
                            <th>Terpakai</th>
                            <th>Sisa</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tahun->sumberDanas as $sumber)
                        <tr>
                            <td>
                                <span class="jenis-badge jenis-{{ $sumber->jenis }}">
                                    {{ strtoupper($sumber->jenis) }}
                                </span>
                            </td>
                            <td class="fw-bold">{{ $sumber->nama_sumber }}</td>
                            <td class="text-right">Rp {{ number_format($sumber->nominal_awal, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($sumber->nominal_terpakai, 0, ',', '.') }}</td>
                            <td class="text-right {{ $sumber->sisa <= 0 ? 'text-danger' : '' }}">
                                Rp {{ number_format($sumber->sisa, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ $sumber->status }}">
                                    {{ strtoupper($sumber->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state-sm">
                <span class="empty-icon">📭</span>
                <p>Belum ada sumber dana</p>
                <a href="{{ route('admin.apbdes.sumberdana.create') }}" class="btn btn-sm btn-primary">
                    <span class="btn-icon">+</span> Tambah Sumber Dana
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Bidang Anggaran --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Bidang Anggaran</h2>
            <span class="count-badge">{{ $tahun->bidangAnggarans->count() }}</span>
        </div>
        <div class="card-body">
            <div class="bidang-grid">
                @foreach($tahun->bidangAnggarans as $bidang)
            <div class="bidang-card">
                <div class="bidang-header">
                    <span class="bidang-kode">{{ $bidang->kode_bidang }}</span>
                    <span class="bidang-nama">{{ $bidang->nama_bidang }}</span>
                </div>
                <div class="bidang-stats">
                    <div class="bidang-stat">
                        <span class="bidang-stat-label">Anggaran</span>
                        <span class="bidang-stat-value">Rp {{ number_format($bidang->total_anggaran, 0, ',', '.') }}</span>
                    </div>
                    <div class="bidang-stat">
                        <span class="bidang-stat-label">Realisasi</span>
                        <span class="bidang-stat-value">Rp {{ number_format($bidang->total_realisasi, 0, ',', '.') }}</span>
                    </div>
                    <div class="bidang-stat">
                        <span class="bidang-stat-label">Kegiatan</span>
                        <span class="bidang-stat-value">{{ $bidang->total_kegiatan }}</span>
                    </div>
                </div>
                @php
                    $bidangPersen = $bidang->total_anggaran > 0 
                        ? ($bidang->total_realisasi / $bidang->total_anggaran) * 100 
                        : 0;
                @endphp
                <div class="bidang-progress-track" data-progress="{{ min($bidangPersen, 100) }}">
                    <div class="bidang-progress-fill"></div>
                </div>
                <span class="bidang-progress-text">{{ number_format($bidangPersen, 1) }}%</span>
            </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="back-actions">
        <a href="{{ route('admin.apbdes.tahun.index') }}" class="btn btn-outline">
            Kembali ke List Tahun
        </a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/tahunanggaran.js') }}"></script>
@endpush