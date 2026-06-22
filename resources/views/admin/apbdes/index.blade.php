@extends('layouts.admin')

@section('title', 'Dashboard APBDES')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/index.css') }}">
@endpush

@section('content')
<div class="apbdes-page apbdes-index">

    <div class="apbdes-header">
        <h1 class="apbdes-title">
            <span class="apbdes-icon"><i class="fa-solid fa-chart-simple"></i></span>
            Dashboard APBDES
        </h1>
        <p class="apbdes-subtitle">Anggaran Pendapatan dan Belanja Desa</p>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="apbdes-alert apbdes-alert-success">
            <span class="alert-icon">✅</span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="apbdes-alert apbdes-alert-error">
            <span class="alert-icon">❌</span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Stats Overview --}}
    @if(isset($stats))
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-calendar-days"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $stats['total_tahun'] }}</span>
                <span class="stat-card-label">Total Tahun Anggaran</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-sack-dollar"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>Rp {{ number_format($stats['total_anggaran_keseluruhan'], 0, ',', '.') }}</span>
                <span class="stat-card-label">Total Anggaran Keseluruhan</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-arrow-trend-up"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>Rp {{ number_format($stats['total_realisasi_keseluruhan'], 0, ',', '.') }}</span>
                <span class="stat-card-label">Total Realisasi Keseluruhan</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Tahun Aktif Card --}}
    @if($tahunAktif)
    <div class="apbdes-card apbdes-card-highlight">
        <div class="card-header">
            <h2 class="card-title">
                <span class="card-icon"><i class="fa-solid fa-align-justify"></i></span>
                Tahun Anggaran Aktif
            </h2>
            <span class="badge badge-aktif">AKTIF</span>
        </div>
        <div class="card-body">
            <div class="stat-grid">
                <div class="stat-item">
                    <span class="stat-label">Tahun</span>
                    <span class="stat-value stat-value-lg" data-counter>{{ $tahunAktif->tahun }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total Anggaran</span>
                    <span class="stat-value stat-value-lg" data-counter>Rp {{ number_format($tahunAktif->total_anggaran, 0, ',', '.') }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total Realisasi</span>
                    <span class="stat-value stat-value-lg" data-counter>Rp {{ number_format($tahunAktif->total_realisasi, 0, ',', '.') }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Sisa Anggaran</span>
                    <span class="stat-value stat-value-lg {{ $tahunAktif->sisa < 0 ? 'text-danger' : 'text-success' }}" data-counter>
                        Rp {{ number_format($tahunAktif->sisa, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <div class="progress-bar" data-progress="{{ $tahunAktif->total_anggaran > 0 ? min(($tahunAktif->total_realisasi / $tahunAktif->total_anggaran) * 100, 100) : 0 }}">
                <div class="progress-fill"></div>
                <span class="progress-text">
                    {{ number_format($tahunAktif->total_anggaran > 0 ? ($tahunAktif->total_realisasi / $tahunAktif->total_anggaran) * 100 : 0, 1) }}% Realisasi
                </span>
            </div>
        </div>
    </div>
    @else
    <div class="apbdes-card apbdes-card-warning">
        <div class="card-body">
            <span class="warning-icon">⚠️</span>
            <p>Belum ada tahun anggaran yang aktif. 
                <a href="{{ route('admin.apbdes.tahun.create') }}" class="warning-link">Buat tahun anggaran baru</a>
            </p>
        </div>
    </div>
    @endif

    {{-- Quick Actions --}}
    <div class="apbdes-quick-actions">
        <a href="{{ route('admin.apbdes.tahun.index') }}" class="quick-card">
            <span class="quick-icon"><i class="fa-solid fa-calendar-days"></i></span>
            <span class="quick-label">Tahun Anggaran</span>
        </a>
        <a href="{{ route('admin.apbdes.sumberdana.index') }}" class="quick-card">
            <span class="quick-icon"><i class="fa-solid fa-sack-dollar"></i></span>
            <span class="quick-label">Sumber Dana</span>
        </a>
        <a href="{{ route('admin.apbdes.pengalokasian.index') }}" class="quick-card">
            <span class="quick-icon"><i class="fa-solid fa-clipboard"></i></span>
            <span class="quick-label">Pengalokasian</span>
        </a>
        <a href="{{ route('admin.apbdes.realisasi.index') }}" class="quick-card">
            <span class="quick-icon"><i class="fa-solid fa-arrow-trend-up"></i></span>
            <span class="quick-label">Realisasi</span>
        </a>
    </div>

    {{-- List Tahun Anggaran --}}
    <div class="apbdes-card">
        <div class="card-header">
            <h2 class="card-title">
                <span class="card-icon"><i class="fa-solid fa-calendar-days"></i></span>
                Daftar Tahun Anggaran
            </h2>
            <a href="{{ route('admin.apbdes.tahun.create') }}" class="btn btn-primary">
                <span class="btn-icon">+</span> Tambah Tahun
            </a>
        </div>
        <div class="card-body">
            @if($tahunAnggarans->count() > 0)
            <div class="table-responsive">
                <table class="apbdes-table">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Total Anggaran</th>
                            <th>Total Realisasi</th>
                            <th>Sisa Anggaran</th>
                            <th>Sumber Dana</th>
                            <th>Bidang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tahunAnggarans as $tahun)
                        <tr>
                            <td class="fw-bold">{{ $tahun->tahun }}</td>
                            <td>
                                <span class="badge badge-{{ $tahun->status }}">
                                    {{ strtoupper($tahun->status) }}
                                </span>
                            </td>
                            <td>Rp {{ number_format($tahun->total_anggaran, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($tahun->total_realisasi, 0, ',', '.') }}</td>
                            <td class="{{ $tahun->sisa < 0 ? 'text-danger' : '' }}">
                                Rp {{ number_format($tahun->sisa, 0, ',', '.') }}
                            </td>
                            <td>{{ $tahun->sumber_danas_count }}</td>
                            <td>{{ $tahun->bidang_anggarans_count }}</td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.apbdes.tahun.show', $tahun->id) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.apbdes.tahun.edit', $tahun->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.apbdes.tahun.destroy', $tahun->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus tahun {{ $tahun->tahun }}? Semua data terkait akan ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrapper">
                {{ $tahunAnggarans->links() }}
            </div>
            @else
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <p>Belum ada tahun anggaran</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/index.js') }}"></script>
@endpush