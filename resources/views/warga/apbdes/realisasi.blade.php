@extends('layouts.app')

@section('title', 'Realisasi APBDes - Transparasi APBDes')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/warga/apbdes/realisasi.css') }}">
@endpush

@section('content')
<div class="realisasi-container">

    {{-- Header --}}
    <div class="realisasi-header">
        <h1>Realisasi APBDes</h1>
        <p class="tahun-aktif">
            <i class="fas fa-calendar-alt"></i> Tahun Anggaran: <strong>{{ $tahunAktif ? $tahunAktif->tahun : 'Belum ada data' }}</strong>
        </p>
        <p class="subtitle"><i class="fas fa-chart-pie"></i> Realisasi Anggaran per Triwulan</p>
    </div>

    @if($tahunAktif)
    @php
        $totalAnggaran = $tahunAktif->total_anggaran;
        $totalRealisasi = array_sum($triwulans);
        $sisa = $totalAnggaran - $totalRealisasi;
        $persen = $totalAnggaran > 0 ? round(($totalRealisasi / $totalAnggaran) * 100, 2) : 0;
    @endphp
    
    {{-- Ringkasan Total --}}
    <div class="ringkasan-total">
        <div class="total-card">
            <span class="total-icon"><i class="fas fa-wallet"></i></span>
            <span class="label">Total Anggaran</span>
            <span class="nominal" data-counter>Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</span>
        </div>
        <div class="total-card terpakai">
            <span class="total-icon"><i class="fas fa-money-bill-transfer"></i></span>
            <span class="label">Total Realisasi</span>
            <span class="nominal" data-counter>Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</span>
        </div>
        <div class="total-card sisa">
            <span class="total-icon"><i class="fas fa-piggy-bank"></i></span>
            <span class="label">Sisa Anggaran</span>
            <span class="nominal" data-counter>Rp {{ number_format($sisa, 0, ',', '.') }}</span>
        </div>
        <div class="total-card persen">
            <span class="total-icon"><i class="fas fa-percent"></i></span>
            <span class="label">Persentase</span>
            <span class="nominal" data-counter>{{ $persen }}%</span>
        </div>
    </div>

    {{-- Progress Bar Besar --}}
    <div class="progress-section">
        <div class="progress-header">
            <span><i class="fas fa-bars-progress"></i> Progress Realisasi Tahunan</span>
            <span class="progress-percent" data-counter>{{ $persen }}%</span>
        </div>
        <div class="progress-bar-large">
            <div class="progress-fill-large" data-width="{{ $persen }}"></div>
        </div>
    </div>

    {{-- Triwulan Cards --}}
    <div class="triwulan-grid">
        @foreach(['I', 'II', 'III', 'IV'] as $triwulan)
        @php
            $nominal = $triwulans[$triwulan] ?? 0;
            
            // FIX: Round target untuk hindari floating point error
            $target = round($totalAnggaran / 4, 2);
            $persenTriwulan = $target > 0 ? round(($nominal / $target) * 100, 2) : 0;
            
            // FIX: Gunakan tolerance untuk perbandingan
            // Selisih <= 1 rupiah dianggap mencapai target
            $tolerance = 1;
            $isTargetReached = ($nominal >= $target - $tolerance);
            
            $bulanList = [
                'I' => 'Januari - Maret',
                'II' => 'April - Juni',
                'III' => 'Juli - September',
                'IV' => 'Oktober - Desember'
            ];
            $statusClass = $isTargetReached ? 'success' : ($nominal > 0 ? 'warning' : 'empty');
        @endphp
        <div class="triwulan-card">
            <div class="triwulan-header">
                <div class="triwulan-badge"><i class="fas fa-calendar"></i> Triwulan {{ $triwulan }}</div>
                <div class="triwulan-bulan">{{ $bulanList[$triwulan] }}</div>
            </div>
            
            <div class="triwulan-body">
                <div class="triwulan-nominal" data-counter>Rp {{ number_format($nominal, 0, ',', '.') }}</div>
                
                <div class="triwulan-progress">
                    <div class="progress-bar-triwulan">
                        <div class="progress-fill-triwulan" style="width: 0%" data-width="{{ min($persenTriwulan, 100) }}"></div>
                    </div>
                    <span class="progress-percent">{{ $persenTriwulan }}% dari target</span>
                </div>
                
                <div class="triwulan-detail">
                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-bullseye"></i> Target</span>
                        <span class="detail-value" data-counter>Rp {{ number_format($target, 0, ',', '.') }}</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-check-circle"></i> Realisasi</span>
                        <span class="detail-value {{ $isTargetReached ? 'success' : 'warning' }}" data-counter>
                            Rp {{ number_format($nominal, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label"><i class="fas fa-scale-balanced"></i> Selisih</span>
                        <span class="detail-value {{ $isTargetReached ? 'success' : 'danger' }}" data-counter>
                            {{ $isTargetReached ? '+' : '' }}Rp {{ number_format($nominal - $target, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="triwulan-status {{ $statusClass }}">
                @if($isTargetReached)
                    <i class="fas fa-circle-check"></i> Mencapai Target
                @elseif($nominal > 0)
                    <i class="fas fa-triangle-exclamation"></i> Belum Mencapai Target
                @else
                    <i class="fas fa-inbox"></i> Belum Ada Realisasi
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Grafik Batang --}}
    @if($totalRealisasi > 0)
    <div class="grafik-section">
        <h2><i class="fas fa-chart-column"></i> Grafik Realisasi per Triwulan</h2>
        <div class="grafik-batang">
            @php $maxHeight = max($triwulans) > 0 ? max($triwulans) : 1; @endphp
            @foreach(['I', 'II', 'III', 'IV'] as $triwulan)
            @php
                $nominal = $triwulans[$triwulan] ?? 0;
                $height = ($nominal / $maxHeight) * 100;
                
                // FIX: Format label grafik dengan benar
                $labelNominal = (float) $nominal;
                if ($labelNominal >= 1000000000) {
                    $labelText = 'Rp ' . number_format($labelNominal / 1000000000, 1) . 'M';
                } elseif ($labelNominal >= 1000000) {
                    $labelText = 'Rp ' . number_format($labelNominal / 1000000, 1) . 'jt';
                } elseif ($labelNominal >= 1000) {
                    $labelText = 'Rp ' . number_format($labelNominal / 1000, 1) . 'rb';
                } else {
                    $labelText = 'Rp ' . number_format($labelNominal, 0, ',', '.');
                }
            @endphp
            <div class="batang-item">
                <div class="batang-atas">
                    <span class="batang-nominal">{{ $labelText }}</span>
                </div>
                <div class="batang-tiang">
                    <div class="batang-fill" data-height="{{ $height }}"></div>
                </div>
                <div class="batang-label"><i class="fas fa-calendar"></i> TW {{ $triwulan }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="empty-grafik">
        <i class="fas fa-chart-simple"></i>
        <p>Belum ada data realisasi untuk ditampilkan pada grafik.</p>
    </div>
    @endif

    {{-- Bottom Nav --}}
    <div class="bottom-nav">
        <a href="{{ route('public.apbdes.index') }}" class="btn-back">
            <span>Kembali ke Ringkasan APBDes</span>
        </a>
    </div>

    @else
    <div class="empty-state">
        <span class="empty-icon"><i class="fas fa-inbox"></i></span>
        <h3>Belum Ada Data Realisasi</h3>
        <p>Data realisasi anggaran per triwulan untuk tahun ini belum tersedia.</p>
        <a href="{{ route('public.apbdes.index') }}" class="btn-back">
            Kembali ke Ringkasan
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/apbdes/realisasi.js') }}"></script>
@endpush