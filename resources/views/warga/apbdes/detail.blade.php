@extends('layouts.app')

@section('title', 'Detail Kegiatan - Transparasi APBDes')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/apbdes/detail.css') }}">
@endpush

@section('content')
<div class="detail-container">
    {{-- Header --}}
    <div class="detail-header">
        <div class="header-top">
        </div>
        <h1>Detail Kegiatan</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('public.apbdes.index') }}" class="breadcrumb-link">APBDes</a>
            <span class="breadcrumb-separator">/</span>
            <a href="{{ route('public.apbdes.pengalokasian') }}" class="breadcrumb-link">Pengalokasian</a>
            <span class="breadcrumb-separator">/</span>
            <span class="breadcrumb-current">Detail</span>
        </nav>
    </div>

    @if(isset($pengalokasian) && $pengalokasian)
    @php
        $totalRealisasi = $pengalokasian->realisasis->where('status', 'terverifikasi')->sum('nominal_digunakan');
        $persen = $pengalokasian->nominal > 0 ? round(($totalRealisasi / $pengalokasian->nominal) * 100, 2) : 0;
        $sisa = $pengalokasian->nominal - $totalRealisasi;
    @endphp

    {{-- Info Card --}}
    <div class="info-card">
        <div class="info-header">
            <span class="bidang-badge">{{ $pengalokasian->bidangAnggaran->nama_bidang ?? '-' }}</span>
            <span class="status-badge status-{{ $pengalokasian->status }}">{{ ucfirst($pengalokasian->status) }}</span>
        </div>
        
        <h2>{{ $pengalokasian->nama_kegiatan }}</h2>
        
        @if($pengalokasian->detail_kegiatan)
        <p class="deskripsi">{{ $pengalokasian->detail_kegiatan }}</p>
        @endif

        <div class="info-grid">
            <div class="info-item">
                <span class="info-label">Sumber Dana</span>
                <span class="info-value">{{ strtoupper($pengalokasian->sumberDana->jenis ?? '-') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Nominal Anggaran</span>
                <span class="info-value nominal" data-counter>Rp {{ number_format($pengalokasian->nominal, 0, ',', '.') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Triwulan Target</span>
                <span class="info-value">Triwulan {{ $pengalokasian->triwulan_target ?? '-' }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tahun Anggaran</span>
                <span class="info-value">{{ $pengalokasian->sumberDana->tahunAnggaran->tahun ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Progress Card --}}
    <div class="progress-card">
        <h3>Progress Realisasi</h3>
        
        <div class="progress-stats">
            <div class="stat-item">
                <span class="stat-label">Realisasi</span>
                <span class="stat-value terpakai" data-counter>Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Sisa</span>
                <span class="stat-value sisa" data-counter>Rp {{ number_format($sisa, 0, ',', '.') }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Persentase</span>
                <span class="stat-value" data-counter>{{ $persen }}%</span>
            </div>
        </div>

        <div class="progress-bar-large">
            <div class="progress-fill-large" data-width="{{ min($persen, 100) }}"></div>
        </div>
    </div>

    {{-- Realisasi Bulanan --}}
    <div class="realisasi-card">
        <h3>Realisasi Bulanan</h3>
        
        @if($pengalokasian->realisasis->where('status', 'terverifikasi')->count() > 0)
        <div class="table-responsive">
            <table class="realisasi-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Bulan</th>
                        <th>Triwulan</th>
                        <th class="text-right">Nominal</th>
                        <th>Keterangan</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $bulanNama = [
                            1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                            4 => 'April', 5 => 'Mei', 6 => 'Juni',
                            7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                            10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                        ];
                    @endphp
                    @foreach($pengalokasian->realisasis->where('status', 'terverifikasi')->sortBy('bulan') as $index => $realisasi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $bulanNama[$realisasi->bulan] ?? '-' }}</td>
                        <td>
                            <span class="triwulan-badge">TW {{ $realisasi->triwulan }}</span>
                        </td>
                        <td class="text-right" data-counter>Rp {{ number_format($realisasi->nominal_digunakan, 0, ',', '.') }}</td>
                        <td>{{ $realisasi->keterangan_pemakaian ?? '-' }}</td>
                        <td>
                            @if($realisasi->bukti_transaksi)
                            <a href="{{ asset('storage/' . $realisasi->bukti_transaksi) }}" target="_blank" class="btn-bukti">
                                Lihat
                            </a>
                            @else
                            <span class="no-bukti">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total Realisasi</strong></td>
                        <td class="text-right"><strong data-counter>Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</strong></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="empty-realisasi">
            <p>Belum ada realisasi yang terverifikasi untuk kegiatan ini.</p>
        </div>
        @endif
    </div>

    {{-- Grafik Bulanan --}}
    @if($pengalokasian->realisasis->where('status', 'terverifikasi')->count() > 0)
    @php
        $bulanSingkat = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        $verifiedRealisasis = $pengalokasian->realisasis->where('status', 'terverifikasi');
        $maxNominal = $verifiedRealisasis->max('nominal_digunakan') ?: 1;
    @endphp
    <div class="grafik-card">
        <h3>Grafik Realisasi per Bulan</h3>
        <div class="grafik-batang">
            @foreach(range(1, 12) as $bulan)
            @php
                $nominal = $verifiedRealisasis->where('bulan', $bulan)->sum('nominal_digunakan');
                $height = $maxNominal > 0 ? ($nominal / $maxNominal) * 100 : 0;
            @endphp
            <div class="batang-item {{ $nominal > 0 ? 'has-data' : '' }}">
                <div class="batang-tooltip" data-nominal="Rp {{ number_format($nominal, 0, ',', '.') }}"></div>
                <div class="batang-tiang">
                    <div class="batang-fill" data-height="{{ $height }}"></div>
                </div>
                <div class="batang-label">{{ $bulanSingkat[$bulan] }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Bottom Nav --}}
    <div class="bottom-nav">
        <a href="{{ route('public.apbdes.pengalokasian') }}" class="btn-back">
            <span>Kembali ke Pengalokasian</span>
        </a>
    </div>

    @else
    <div class="empty-state">
        <h3>Data Tidak Ditemukan</h3>
        <p>Detail kegiatan yang Anda cari tidak tersedia.</p>
        <a href="{{ route('public.apbdes.index') }}" class="btn-back">Kembali ke Ringkasan</a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/warga/apbdes/detail.js') }}"></script>
@endpush