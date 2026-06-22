@extends('layouts.admin')

@section('title', 'Detail Sumber Dana')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/sumberdana.css') }}">
@endpush

@section('content')
<div class="sumberdana-page sumberdana-show">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Detail Sumber Dana</h1>
            <p class="page-subtitle">{{ $sumber->nama_sumber }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.apbdes.sumberdana.edit', $sumber->id) }}" class="btn btn-warning">
                Edit
            </a>
        </div>
    </div>

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

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-primary">
            <div class="stat-info-wrapper">
                <span class="stat-label">Nominal Awal</span>
                <span class="stat-value" data-counter>Rp {{ number_format($sumber->nominal_awal, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-card stat-info-accent">
            <div class="stat-info-wrapper">
                <span class="stat-label">Terpakai</span>
                <span class="stat-value" data-counter>Rp {{ number_format($sumber->nominal_terpakai, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-info-wrapper">
                <span class="stat-label">Sisa</span>
                <span class="stat-value" data-counter>Rp {{ number_format($sumber->sisa, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-info-wrapper">
                <span class="stat-label">Status</span>
                <span class="stat-value">
                    <span class="status-badge status-{{ $sumber->status }}">{{ ucfirst($sumber->status) }}</span>
                </span>
            </div>
        </div>
    </div>

    {{-- Detail Info --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Informasi Sumber Dana</h2>
        </div>
        <div class="card-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <span class="detail-label">Nama Sumber</span>
                    <span class="detail-value">{{ $sumber->nama_sumber }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Jenis</span>
                    <span class="detail-value">
                        <span class="badge badge-{{ $sumber->jenis }}">{{ strtoupper($sumber->jenis) }}</span>
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tahun Anggaran</span>
                    <span class="detail-value">{{ $sumber->tahunAnggaran->tahun ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Dibuat Oleh</span>
                    <span class="detail-value">{{ $sumber->creator->name ?? '-' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tanggal Dibuat</span>
                    <span class="detail-value">{{ $sumber->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Terakhir Diupdate</span>
                    <span class="detail-value">{{ $sumber->updated_at->format('d M Y H:i') }}</span>
                </div>
                @if($sumber->keterangan)
                <div class="detail-item detail-full">
                    <span class="detail-label">Keterangan</span>
                    <span class="detail-value">{{ $sumber->keterangan }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Pengalokasian Terkait --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Pengalokasian Terkait</h2>
        </div>
        <div class="card-body">
            @if($sumber->pengalokasians->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Nama Kegiatan</th>
                            <th>Bidang</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sumber->pengalokasians as $index => $alokasi)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $alokasi->nama_kegiatan }}</td>
                            <td>{{ $alokasi->bidangAnggaran->nama_bidang ?? '-' }}</td>
                            <td class="text-right fw-bold">Rp {{ number_format($alokasi->nominal, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge status-{{ $alokasi->status }}">{{ ucfirst($alokasi->status) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state-sm">
                <p class="empty-text">Belum ada pengalokasian</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Realisasi Terkait --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Realisasi Terverifikasi</h2>
        </div>
        <div class="card-body">
            @if($sumber->realisasis->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Bulan/Tahun</th>
                            <th>Triwulan</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sumber->realisasis as $index => $realisasi)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $realisasi->bulan }}/{{ $realisasi->tahun }}</td>
                            <td class="text-center">TW {{ $realisasi->triwulan }}</td>
                            <td class="text-right fw-bold">Rp {{ number_format($realisasi->nominal_digunakan, 0, ',', '.') }}</td>
                            <td>{{ Str::limit($realisasi->keterangan_pemakaian, 50) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state-sm">
                <p class="empty-text">Belum ada realisasi terverifikasi</p>
            </div>
            @endif
        </div>
    </div>

    <div class="back-actions">
        <a href="{{ route('admin.apbdes.sumberdana.index') }}" class="btn btn-outline">
            <span class="btn-icon"></span> Kembali ke List
        </a>
        <a href="{{ route('admin.apbdes.index') }}" class="btn btn-outline">
            <span class="btn-icon"></span> Dashboard APBDES
        </a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/sumberdana.js') }}"></script>
@endpush