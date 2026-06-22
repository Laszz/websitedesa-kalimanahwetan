@extends('layouts.app')

@section('title', 'Riwayat Bantuan Saya')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/warga/penerimabantuan/index.css') }}">
@endpush

@section('content')
<div class="wpb-container">

    {{-- Header --}}
    <div class="wpb-header">
        <div class="wpb-header-text">
            <h1 class="wpb-title">Riwayat Bantuan Saya</h1>
            <p class="wpb-subtitle">Daftar bantuan yang pernah atau sedang Anda terima</p>
        </div>
    </div>

    {{-- Data Counter --}}
    <div class="wpb-counter-row">
        <div class="wpb-counter-grid">
            <div class="wpb-counter-item">
                <div class="wpb-counter-card wpb-counter-total">
                    <div class="wpb-counter-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <div class="wpb-counter-body">
                        <h3 class="wpb-counter-value" data-target="{{ $bantuans->count() }}">{{ $bantuans->count() }}</h3>
                        <span class="wpb-counter-label">Total Bantuan</span>
                    </div>
                </div>
            </div>
            <div class="wpb-counter-item">
                <div class="wpb-counter-card wpb-counter-aktif">
                    <div class="wpb-counter-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="wpb-counter-body">
                        <h3 class="wpb-counter-value" data-target="{{ $bantuans->where('status', 'aktif')->count() }}">{{ $bantuans->where('status', 'aktif')->count() }}</h3>
                        <span class="wpb-counter-label">Bantuan Aktif</span>
                    </div>
                </div>
            </div>
            <div class="wpb-counter-item">
                <div class="wpb-counter-card wpb-counter-nonaktif">
                    <div class="wpb-counter-icon"><i class="fas fa-pause-circle"></i></div>
                    <div class="wpb-counter-body">
                        <h3 class="wpb-counter-value" data-target="{{ $bantuans->where('status', 'nonaktif')->count() }}">{{ $bantuans->where('status', 'nonaktif')->count() }}</h3>
                        <span class="wpb-counter-label">Bantuan Nonaktif</span>
                    </div>
                </div>
            </div>
            <div class="wpb-counter-item">
                <div class="wpb-counter-card wpb-counter-dicabut">
                    <div class="wpb-counter-icon"><i class="fas fa-times-circle"></i></div>
                    <div class="wpb-counter-body">
                        <h3 class="wpb-counter-value" data-target="{{ $bantuans->where('status', 'dicabut')->count() }}">{{ $bantuans->where('status', 'dicabut')->count() }}</h3>
                        <span class="wpb-counter-label">Bantuan Dicabut</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="wpb-card">
        <div class="wpb-card-header">
            <h3 class="wpb-card-title"><i class="fas fa-list"></i> Daftar Bantuan</h3>
        </div>
        <div class="wpb-card-body">
            <div class="wpb-table-responsive">
                <table class="wpb-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Jenis Bantuan</th>
                            <th>Tahun Anggaran</th>
                            <th>Desil</th>
                            <th>Status</th>
                            <th>Tanggal Terima</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bantuans as $index => $b)
                            <tr>
                                <td class="wpb-text-center">{{ $bantuans->firstItem() + $index }}</td>
                                <td>
                                    <div class="wpb-bantuan-name">{{ $b->jenisBantuan->nama_bantuan ?? '-' }}</div>
                                    <div class="wpb-bantuan-kode">{{ $b->jenisBantuan->kode_bantuan ?? '-' }}</div>
                                </td>
                                <td class="wpb-text-center">{{ $b->jenisBantuan->tahunAnggaran->tahun ?? '-' }}</td>
                                <td class="wpb-text-center">
                                    <span class="wpb-desil-badge {{ $b->desil <= 3 ? 'wpb-desil-prioritas' : ($b->desil <= 7 ? 'wpb-desil-menengah' : 'wpb-desil-tinggi') }}">
                                        Desil {{ $b->desil }}
                                    </span>
                                </td>
                                <td class="wpb-text-center">{!! $b->status_badge !!}</td>
                                <td class="wpb-text-center">{{ $b->tanggal_terima ? $b->tanggal_terima->format('d/m/Y') : '-' }}</td>
                                <td class="wpb-text-center">
                                    <a href="{{ route('warga.penerimabantuan.show', $b->id) }}" class="wpb-btn-detail" title="Lihat Detail">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="wpb-empty-state">
                                    <div class="wpb-empty-icon"><i class="fas fa-inbox"></i></div>
                                    <div class="wpb-empty-text">Belum ada data bantuan</div>
                                    <div class="wpb-empty-sub">Data bantuan yang Anda terima akan muncul di sini</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($bantuans->hasPages())
                <div class="wpb-pagination">
                    {{ $bantuans->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/penerimabantuan/index.js') }}"></script>
@endpush