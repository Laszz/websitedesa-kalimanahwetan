@extends('layouts.app')

@section('title', 'Sumber Dana - Transparasi APBDes')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/warga/apbdes/sumberdana.css') }}">
@endpush

@section('content')
<div class="sumberdana-container">

    {{-- Header --}}
    <div class="sumberdana-header">
        <h1>Sumber Dana APBDes</h1>
        <p class="tahun-aktif">
            <i class="fas fa-calendar-alt"></i> Tahun Anggaran: <strong>{{ $tahunAktif ? $tahunAktif->tahun : 'Belum ada data' }}</strong>
        </p>
    </div>

    {{-- Ringkasan Total --}}
    @if($tahunAktif)
    <div class="ringkasan-total">
        <div class="total-card">
            <span class="total-icon"><i class="fas fa-wallet"></i></span>
            <span class="label">Total Sumber Dana</span>
            <span class="nominal" data-counter>Rp {{ number_format($sumberDanas->flatten()->sum('nominal_awal'), 0, ',', '.') }}</span>
        </div>
        <div class="total-card terpakai">
            <span class="total-icon"><i class="fas fa-money-bill-transfer"></i></span>
            <span class="label">Total Terpakai</span>
            <span class="nominal" data-counter>Rp {{ number_format($sumberDanas->flatten()->sum('nominal_terpakai'), 0, ',', '.') }}</span>
        </div>
        <div class="total-card sisa">
            <span class="total-icon"><i class="fas fa-piggy-bank"></i></span>
            <span class="label">Total Sisa</span>
            <span class="nominal" data-counter>Rp {{ number_format($sumberDanas->flatten()->sum('sisa'), 0, ',', '.') }}</span>
        </div>
    </div>
    @endif

    {{-- Daftar Sumber Dana per Jenis --}}
    @php
        $icons = [
            'apbn' => 'fa-landmark',
            'apbd_provinsi' => 'fa-building-columns',
            'bkk' => 'fa-gift',
            'pad' => 'fa-seedling',
            'add' => 'fa-box-open',
            'dd' => 'fa-city',
            'silpa' => 'fa-sack-dollar',
            'lainnya' => 'fa-clipboard-list',
        ];
    @endphp

    @forelse($sumberDanas as $jenis => $danaList)
    <div class="jenis-section" data-jenis="{{ $jenis }}">
        <div class="jenis-header">
            <div class="jenis-title">
                <span class="jenis-icon"><i class="fas {{ $icons[$jenis] ?? 'fa-clipboard-list' }}"></i></span>
                <h2>{{ strtoupper($jenis) }}</h2>
                <span class="jenis-count">({{ $danaList->count() }})</span>
            </div>
            <div class="jenis-summary">
                <span class="jenis-total" data-counter>Rp {{ number_format($danaList->sum('nominal_awal'), 0, ',', '.') }}</span>
                <span class="toggle-icon" id="icon-{{ $jenis }}"><i class="fas fa-chevron-down"></i></span>
            </div>
        </div>

        <div class="jenis-content" id="content-{{ $jenis }}">
            <div class="table-responsive">
                <table class="sumberdana-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag"></i> No</th>
                            <th><i class="fas fa-file-signature"></i> Nama Sumber</th>
                            <th class="text-right"><i class="fas fa-wallet"></i> Nominal Awal</th>
                            <th class="text-right"><i class="fas fa-money-bill-transfer"></i> Terpakai</th>
                            <th class="text-right"><i class="fas fa-piggy-bank"></i> Sisa</th>
                            <th><i class="fas fa-flag"></i> Status</th>
                            <th><i class="fas fa-align-left"></i> Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($danaList as $index => $dana)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $dana->nama_sumber }}</td>
                            <td class="text-right" data-counter>Rp {{ number_format($dana->nominal_awal, 0, ',', '.') }}</td>
                            <td class="text-right terpakai" data-counter>Rp {{ number_format($dana->nominal_terpakai, 0, ',', '.') }}</td>
                            <td class="text-right sisa" data-counter>Rp {{ number_format($dana->sisa, 0, ',', '.') }}</td>
                            <td>
                                <span class="status-badge status-{{ $dana->status }}">
                                    {{ ucfirst($dana->status) }}
                                </span>
                            </td>
                            <td>{{ $dana->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong><i class="fas fa-calculator"></i> Subtotal {{ strtoupper($jenis) }}</strong></td>
                            <td class="text-right"><strong data-counter>Rp {{ number_format($danaList->sum('nominal_awal'), 0, ',', '.') }}</strong></td>
                            <td class="text-right terpakai"><strong data-counter>Rp {{ number_format($danaList->sum('nominal_terpakai'), 0, ',', '.') }}</strong></td>
                            <td class="text-right sisa"><strong data-counter>Rp {{ number_format($danaList->sum('sisa'), 0, ',', '.') }}</strong></td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <span class="empty-icon"><i class="fas fa-inbox"></i></span>
        <h3>Belum Ada Data Sumber Dana</h3>
        <p>Data sumber dana untuk tahun ini belum tersedia.</p>
        <a href="{{ route('public.apbdes.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali ke Ringkasan
        </a>
    </div>
    @endforelse

    @if($sumberDanas->count() > 0)
    <div class="bottom-nav">
        <a href="{{ route('public.apbdes.index') }}" class="btn-back">  
            <span>Kembali ke Ringkasan APBDes</span>
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/apbdes/sumberdana.js') }}"></script>
@endpush