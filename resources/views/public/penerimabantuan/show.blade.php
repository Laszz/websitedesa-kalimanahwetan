@extends('layouts.app')

@section('title', 'Detail Penerima - ' . ($jenisBantuan->nama_bantuan ?? 'Bantuan'))

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/public/penerimabantuan/show.css') }}">
@endpush

@section('content')
<div class="ppb-container">

    {{-- Header --}}
    <div class="ppb-header">
        <div class="ppb-header-text">
            <h1 class="ppb-title">{{ $jenisBantuan->nama_bantuan ?? 'Bantuan' }}</h1>
            <p class="ppb-subtitle">Daftar penerima bantuan aktif</p>
        </div>
    </div>

    {{-- Info Jenis Bantuan --}}
    <div class="ppb-info-card">
        <div class="ppb-info-grid">
            <div class="ppb-info-item">
                <span class="ppb-info-label">Kode Bantuan</span>
                <span class="ppb-info-value">{{ $jenisBantuan->kode_bantuan ?? '-' }}</span>
            </div>
            <div class="ppb-info-item">
                <span class="ppb-info-label">Tahun Anggaran</span>
                <span class="ppb-info-value">{{ $jenisBantuan->tahunAnggaran->tahun ?? '-' }}</span>
            </div>
            <div class="ppb-info-item">
                <span class="ppb-info-label">Sumber Dana</span>
                <span class="ppb-info-value">{{ $jenisBantuan->sumber_dana ?? '-' }}</span>
            </div>
            <div class="ppb-info-item">
                <span class="ppb-info-label">Anggaran per KK</span>
                <span class="ppb-info-value ppb-info-money">Rp {{ number_format($jenisBantuan->anggaran_per_kk ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- Statistik Desil --}}
    @if($statistikDesil->count() > 0)
    <div class="ppb-card ppb-card-stat">
        <div class="ppb-card-header">
            <h3 class="ppb-card-title"><i class="fas fa-chart-bar"></i> Distribusi Desil</h3>
        </div>
        <div class="ppb-card-body">
            <div class="ppb-stat-grid">
                @foreach($statistikDesil as $desil => $jumlah)
                    <div class="ppb-stat-item">
                        <div class="ppb-stat-desil">Desil {{ $desil }}</div>
                        <div class="ppb-stat-bar-bg">
                            <div class="ppb-stat-bar" data-width="{{ ($jumlah / $penerima->total()) * 100 }}"></div>
                        </div>
                        <div class="ppb-stat-count">{{ $jumlah }} KK</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Daftar Penerima — Flexbox List (bukan Table) --}}
    <div class="ppb-card">
        <div class="ppb-card-header">
            <h3 class="ppb-card-title"><i class="fas fa-users"></i> Daftar Penerima</h3>
            <span class="ppb-card-badge">{{ $penerima->total() }} KK</span>
        </div>
        <div class="ppb-card-body">
            
            {{-- Header List --}}
            <div class="ppb-list-header">
                <div class="ppb-list-col ppb-list-no">No</div>
                <div class="ppb-list-col ppb-list-nama">Nama</div>
                <div class="ppb-list-col ppb-list-desil">Desil</div>
                <div class="ppb-list-col ppb-list-status">Status</div>
                <div class="ppb-list-col ppb-list-tanggal">Tanggal Terima</div>
            </div>

            {{-- Body List --}}
            @forelse($penerima as $index => $p)
                <div class="ppb-list-row">
                    <div class="ppb-list-col ppb-list-no">{{ $penerima->firstItem() + $index }}</div>
                    <div class="ppb-list-col ppb-list-nama">{{ $p->warga->name ?? '-' }}</div>
                    <div class="ppb-list-col ppb-list-desil">
                        <span class="ppb-desil-badge {{ $p->desil <= 3 ? 'ppb-desil-prioritas' : ($p->desil <= 7 ? 'ppb-desil-menengah' : 'ppb-desil-tinggi') }}">
                            Desil {{ $p->desil }}
                        </span>
                    </div>
                    <div class="ppb-list-col ppb-list-status">{!! $p->status_badge !!}</div>
                    <div class="ppb-list-col ppb-list-tanggal">{{ $p->tanggal_terima ? $p->tanggal_terima->format('d/m/Y') : '-' }}</div>
                </div>
            @empty
                <div class="ppb-empty-state">
                    <div class="ppb-empty-icon"><i class="fas fa-inbox"></i></div>
                    <div class="ppb-empty-text">Belum ada penerima aktif</div>
                </div>
            @endforelse

            {{-- Pagination --}}
            @if($penerima->hasPages())
                <div class="ppb-pagination">
                    {{ $penerima->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Tombol Kembali di Bawah --}}
    <div class="ppb-back-section">
        <a href="{{ route('public.penerimabantuan.index') }}" class="ppb-btn-back-bottom">
            Kembali ke Daftar Bantuan
        </a>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/public/penerimabantuan/show.js') }}"></script>
@endpush