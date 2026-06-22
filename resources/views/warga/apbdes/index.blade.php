@extends('layouts.app')

@section('title', 'Transparasi APBDes - Desa Kalimanah Wetan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/apbdes/index.css') }}">
@endpush

@section('content')
<div class="apbdes-container">
    {{-- Header --}}
    <div class="apbdes-header">
        <h1>Transparasi APBDes</h1>
        <p class="tahun-aktif">
            Tahun Anggaran: <strong>{{ $tahunAktif ? $tahunAktif->tahun : 'Belum ada data' }}</strong>
        </p>
    </div>

    {{-- Ringkasan Card --}}
    <div class="ringkasan-grid">
        <div class="ringkasan-card total">
            <div class="info">
                <span class="label">Total Anggaran</span>
                <span class="nominal" data-counter>Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="ringkasan-card terpakai">
            <div class="info">
                <span class="label">Total Realisasi</span>
                <span class="nominal" data-counter>Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="ringkasan-card sisa">
            <div class="info">
                <span class="label">Sisa Anggaran</span>
                <span class="nominal" data-counter>Rp {{ number_format($totalAnggaran - $totalRealisasi, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <div class="ringkasan-card persen">
            <div class="info">
                <span class="label">Persentase</span>
                <span class="nominal" data-counter>
                    {{ $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 2) : 0 }}%
                </span>
            </div>
        </div>
    </div>

    {{-- Progress Bar --}}
    <div class="progress-section">
        <div class="progress-header">
            <span>Progress Realisasi</span>
            <span class="progress-percent" data-counter>
                {{ $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 2) : 0 }}%
            </span>
        </div>
        <div class="progress-bar">
            <div class="progress-fill" data-width="{{ $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0 }}"></div>
        </div>
    </div>

    {{-- Menu Navigasi --}}
    <div class="menu-grid">
        <a href="{{ route('public.apbdes.sumberdana') }}" class="menu-card">
            <h3>Sumber Dana</h3>
            <p>Lihat detail pemasukan desa dari APBN, APBD, BKK, PAD, dll</p>
            <span class="btn-detail">Lihat Detail</span>
        </a>

        <a href="{{ route('public.apbdes.pengalokasian') }}" class="menu-card">
            <h3>Pengalokasian Dana</h3>
            <p>Lihat pembagian dana per bidang: Pemerintahan, Pembangunan, dll</p>
            <span class="btn-detail">Lihat Detail</span>
        </a>

        <a href="{{ route('public.apbdes.realisasi') }}" class="menu-card">
            <h3>Realisasi Bulanan</h3>
            <p>Lihat realisasi anggaran per triwulan</p>
            <span class="btn-detail">Lihat Detail</span>
        </a>
    </div>

    @if($sumberDanas->count() > 0)
    <div class="tabel-section">
        <h2>Ringkasan Sumber Dana</h2>
        <div class="table-responsive">
            <table class="apbdes-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Nama Sumber</th>
                        <th class="text-right">Nominal</th>
                        <th class="text-right">Terpakai</th>
                        <th class="text-right">Sisa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sumberDanas as $index => $sumber)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge badge-{{ $sumber->jenis }}">
                                {{ strtoupper($sumber->jenis) }}
                            </span>
                        </td>
                        <td>{{ $sumber->nama_sumber }}</td>
                        <td class="text-right" data-counter>Rp {{ number_format($sumber->nominal_awal, 0, ',', '.') }}</td>
                        <td class="text-right" data-counter>Rp {{ number_format($sumber->nominal_terpakai, 0, ',', '.') }}</td>
                        <td class="text-right" data-counter>Rp {{ number_format($sumber->sisa, 0, ',', '.') }}</td>
                        <td>
                            <span class="status status-{{ $sumber->status }}">
                                {{ ucfirst($sumber->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="empty-state">
        <h3>Belum Ada Data</h3>
        <p>Data APBDes untuk tahun ini belum tersedia.</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/warga/apbdes/index.js') }}"></script>
@endpush