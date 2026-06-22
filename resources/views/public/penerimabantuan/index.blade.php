@extends('layouts.app')

@section('title', 'Transparansi Penerima Bantuan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/public/penerimabantuan/index.css') }}">
@endpush

@section('content')
<div class="ppb-container">

    {{-- Header --}}
    <div class="ppb-header">
        <div class="ppb-header-text">
            <h1 class="ppb-title">Transparansi Penerima Bantuan</h1>
            <p class="ppb-subtitle">Daftar Jenis Bantuan Dan Statistik Penerima Di Desa Kalimanah Wetan</p>
        </div>
    </div>

    {{-- Statistik Total --}}
    <div class="ppb-counter-row">
        <div class="ppb-counter-grid">
            <div class="ppb-counter-item">
                <div class="ppb-counter-card ppb-counter-total">
                    <div class="ppb-counter-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="ppb-counter-body">
                        <h3 class="ppb-counter-value" data-target="{{ $jenisBantuans->count() }}">{{ $jenisBantuans->count() }}</h3>
                        <span class="ppb-counter-label">Jenis Bantuan</span>
                    </div>
                </div>
            </div>
            <div class="ppb-counter-item">
                <div class="ppb-counter-card ppb-counter-penerima">
                    <div class="ppb-counter-icon"><i class="fas fa-users"></i></div>
                    <div class="ppb-counter-body">
                        <h3 class="ppb-counter-value" data-target="{{ $jenisBantuans->sum('total_penerima') }}">{{ $jenisBantuans->sum('total_penerima') }}</h3>
                        <span class="ppb-counter-label">Total Penerima Aktif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Jenis Bantuan --}}
    <div class="ppb-card">
        <div class="ppb-card-header">
            <h3 class="ppb-card-title"><i class="fas fa-list"></i> Daftar Jenis Bantuan</h3>
        </div>
        <div class="ppb-card-body">
            <div class="ppb-grid">
                @forelse($jenisBantuans as $jb)
                    <div class="ppb-jenis-item">
                        <div class="ppb-jenis-card">
                            <div class="ppb-jenis-header">
                                <div class="ppb-jenis-icon">
                                    <i class="fas fa-hand-holding-heart"></i>
                                </div>
                                <div class="ppb-jenis-info">
                                    <h4 class="ppb-jenis-name">{{ $jb->nama_bantuan }}</h4>
                                    <span class="ppb-jenis-kode">{{ $jb->kode_bantuan }}</span>
                                </div>
                            </div>
                            <div class="ppb-jenis-body">
                                <div class="ppb-jenis-row">
                                    <span class="ppb-jenis-label">Tahun Anggaran</span>
                                    <span class="ppb-jenis-value">{{ $jb->tahunAnggaran->tahun ?? '-' }}</span>
                                </div>
                                <div class="ppb-jenis-row">
                                    <span class="ppb-jenis-label">Sumber Dana</span>
                                    <span class="ppb-jenis-value">{{ $jb->sumber_dana ?? '-' }}</span>
                                </div>
                                <div class="ppb-jenis-row">
                                    <span class="ppb-jenis-label">Anggaran/KK</span>
                                    <span class="ppb-jenis-value ppb-jenis-money">Rp {{ number_format($jb->anggaran_per_kk, 0, ',', '.') }}</span>
                                </div>
                                <div class="ppb-jenis-row">
                                    <span class="ppb-jenis-label">Total Penerima</span>
                                    <span class="ppb-jenis-value ppb-jenis-highlight">{{ $jb->total_penerima }} KK</span>
                                </div>
                            </div>
                            <div class="ppb-jenis-footer">
                                <a href="{{ route('public.penerimabantuan.show', $jb->id) }}" class="ppb-btn-detail">
                                    <i class="fas fa-eye"></i> Lihat Detail Penerima
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="ppb-empty-state">
                        <div class="ppb-empty-icon"><i class="fas fa-inbox"></i></div>
                        <div class="ppb-empty-text">Belum ada data jenis bantuan</div>
                        <div class="ppb-empty-sub">Data akan muncul setelah admin menambahkan jenis bantuan</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/public/penerimabantuan/index.js') }}"></script>
@endpush