@extends('layouts.app')

@section('title', 'Pengalokasian Dana - Transparasi APBDes')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/warga/apbdes/pengalokasian.css') }}">
@endpush

@section('content')
<div class="pengalokasian-container">

    {{-- Header --}}
    <div class="pengalokasian-header">
        <h1>Pengalokasian Dana APBDes</h1>
        <p class="tahun-aktif">
            <i class="fas fa-calendar-alt"></i> Tahun Anggaran: <strong>{{ $tahunAktif ? $tahunAktif->tahun : 'Belum ada data' }}</strong>
        </p>
    </div>

    {{-- Ringkasan Total --}}
    @if($tahunAktif)
    <div class="ringkasan-total">
        <div class="total-card">
            <span class="total-icon"><i class="fas fa-wallet"></i></span>
            <span class="label">Total Anggaran</span>
            <span class="nominal" data-counter>Rp {{ number_format($bidangs->sum('total_anggaran'), 0, ',', '.') }}</span>
        </div>
        <div class="total-card terpakai">
            <span class="total-icon"><i class="fas fa-money-bill-transfer"></i></span>
            <span class="label">Total Realisasi</span>
            <span class="nominal" data-counter>Rp {{ number_format($bidangs->sum('total_realisasi'), 0, ',', '.') }}</span>
        </div>
        <div class="total-card sisa">
            <span class="total-icon"><i class="fas fa-piggy-bank"></i></span>
            <span class="label">Sisa Anggaran</span>
            <span class="nominal" data-counter>Rp {{ number_format($bidangs->sum('total_anggaran') - $bidangs->sum('total_realisasi'), 0, ',', '.') }}</span>
        </div>
    </div>
    @endif

    {{-- Grid Bidang --}}
    @php
        $bidangIcons = [
            '1' => 'fa-landmark',
            '2' => 'fa-hammer',
            '3' => 'fa-seedling',
            '4' => 'fa-book-open',
            '5' => 'fa-bolt',
        ];
    @endphp

    @forelse($bidangs as $bidang)
    <div class="bidang-section" data-bidang="{{ $bidang->id }}">
        <div class="bidang-header">
            <div class="bidang-title">
                <span class="bidang-icon"><i class="fas {{ $bidangIcons[$bidang->kode_bidang] ?? 'fa-clipboard-list' }}"></i></span>
                <div class="bidang-info">
                    <h2>{{ $bidang->nama_bidang }}</h2>
                    <span class="bidang-kode">Bidang {{ $bidang->kode_bidang }}</span>
                </div>
            </div>
            <div class="bidang-summary">
                <div class="summary-item">
                    <span class="summary-label">Anggaran</span>
                    <span class="summary-nominal" data-counter>Rp {{ number_format($bidang->total_anggaran, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Realisasi</span>
                    <span class="summary-nominal terpakai" data-counter>Rp {{ number_format($bidang->total_realisasi, 0, ',', '.') }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Sisa</span>
                    <span class="summary-nominal sisa" data-counter>Rp {{ number_format($bidang->total_anggaran - $bidang->total_realisasi, 0, ',', '.') }}</span>
                </div>
                <span class="toggle-icon" id="icon-bidang-{{ $bidang->id }}"><i class="fas fa-chevron-down"></i></span>
            </div>
        </div>

        <div class="bidang-content" id="content-bidang-{{ $bidang->id }}">
            @if($bidang->pengalokasians->count() > 0)
            <div class="table-responsive">
                <table class="pengalokasian-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> No</th>
                            <th><i class="fas fa-file-signature"></i> Nama Kegiatan</th>
                            <th><i class="fas fa-coins"></i> Sumber Dana</th>
                            <th class="text-right"><i class="fas fa-wallet"></i> Nominal</th>
                            <th><i class="fas fa-calendar"></i> Triwulan</th>
                            <th><i class="fas fa-flag"></i> Status</th>
                            <th><i class="fas fa-chart-pie"></i> Realisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bidang->pengalokasians as $index => $alokasi)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $alokasi->nama_kegiatan }}</strong>
                                @if($alokasi->detail_kegiatan)
                                <p class="detail-text">{{ Str::limit($alokasi->detail_kegiatan, 100) }}</p>
                                @endif
                            </td>
                            <td>
                                <span class="badge-sumber badge-{{ $alokasi->sumberDana->jenis }}">
                                    {{ strtoupper($alokasi->sumberDana->jenis) }}
                                </span>
                            </td>
                            <td class="text-right" data-counter>Rp {{ number_format($alokasi->nominal, 0, ',', '.') }}</td>
                            <td>
                                <span class="triwulan-badge">Triwulan {{ $alokasi->triwulan_target ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $alokasi->status }}">
                                    {{ ucfirst($alokasi->status) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $realisasi = $alokasi->realisasis->where('status', 'terverifikasi')->sum('nominal_digunakan');
                                    $persen = $alokasi->nominal > 0 ? round(($realisasi / $alokasi->nominal) * 100, 1) : 0;
                                @endphp
                                <div class="progress-mini">
                                    <div class="progress-bar-mini" data-width="{{ min($persen, 100) }}"></div>
                                    <span class="progress-text">{{ $persen }}%</span>
                                </div>
                                <span class="realisasi-nominal" data-counter>Rp {{ number_format($realisasi, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><strong><i class="fas fa-calculator"></i> Subtotal {{ $bidang->nama_bidang }}</strong></td>
                            <td class="text-right"><strong data-counter>Rp {{ number_format($bidang->pengalokasians->sum('nominal'), 0, ',', '.') }}</strong></td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            @else
            <div class="empty-bidang">
                <i class="fas fa-folder-open"></i>
                <p>Belum ada pengalokasian dana untuk bidang ini.</p>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="empty-state">
        <span class="empty-icon"><i class="fas fa-inbox"></i></span>
        <h3>Belum Ada Data Pengalokasian</h3>
        <p>Data pengalokasian dana untuk tahun ini belum tersedia.</p>
        <a href="{{ route('public.apbdes.index') }}" class="btn-back">
            Kembali ke Ringkasan
        </a>
    </div>
    @endforelse

    @if($bidangs->count() > 0)
    <div class="bottom-nav">
        <a href="{{ route('public.apbdes.index') }}" class="btn-back">
            <span>Kembali ke Ringkasan APBDes</span>
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/apbdes/pengalokasian.js') }}"></script>
@endpush