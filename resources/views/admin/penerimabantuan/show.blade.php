@extends('layouts.admin')

@section('title', 'Detail Penerima Bantuan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/penerimabantuan/show.css') }}">
@endpush

@section('content')
<div class="pb-page pb-show">

    {{-- Header --}}
    <div class="pb-header">
        <div class="header-content">
            <h1 class="pb-title">
                <span class="pb-icon"><i class="fa-solid fa-circle-info"></i></span>
                Detail Penerima Bantuan
            </h1>
            <p class="pb-subtitle">Informasi lengkap penerima bantuan desa</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="pb-alert pb-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="pb-alert pb-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Detail Card --}}
    <div class="pb-card detail-card">

        {{-- Info Grid --}}
        <div class="pb-grid">

            {{-- Warga Info --}}
            <div class="pb-section">
                <h6 class="pb-section-title">
                    <i class="fa-solid fa-user"></i> Data Warga
                </h6>
                <div class="pb-item">
                    <span class="pb-label">NIK</span>
                    <span class="pb-value">{{ $penerima->warga->nik ?? '-' }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Nama</span>
                    <span class="pb-value">{{ $penerima->warga->name ?? '-' }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Alamat</span>
                    <span class="pb-value">{{ $penerima->warga->alamat ?? '-' }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">RT / RW</span>
                    <span class="pb-value">{{ $penerima->warga->rt ?? '-' }} / {{ $penerima->warga->rw ?? '-' }}</span>
                </div>
            </div>

            {{-- Bantuan Info --}}
            <div class="pb-section">
                <h6 class="pb-section-title">
                    <i class="fa-solid fa-hand-holding-dollar"></i> Data Bantuan
                </h6>
                <div class="pb-item">
                    <span class="pb-label">Jenis Bantuan</span>
                    <span class="pb-value">{{ $penerima->jenisBantuan->nama_bantuan ?? '-' }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Kode Bantuan</span>
                    <span class="pb-value">{{ $penerima->jenisBantuan->kode_bantuan ?? '-' }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Tahun Anggaran</span>
                    <span class="pb-value">{{ $penerima->jenisBantuan->tahunAnggaran->tahun ?? '-' }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Anggaran per KK</span>
                    <span class="pb-value">Rp {{ number_format($penerima->jenisBantuan->anggaran_per_kk ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

        </div>

        {{-- Divider --}}
        <hr class="pb-divider">

        {{-- Status Grid --}}
        <div class="pb-grid">

            <div class="pb-section">
                <h6 class="pb-section-title">
                    <i class="fa-solid fa-circle-info"></i> Status Penerimaan
                </h6>
                <div class="pb-item">
                    <span class="pb-label">Desil</span>
                    <span class="pb-value">
                        <span class="desil-badge {{ $penerima->desil <= 3 ? 'desil-prioritas' : ($penerima->desil <= 7 ? 'desil-menengah' : 'desil-tinggi') }}">
                            Desil {{ $penerima->desil }}
                        </span>
                    </span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Status</span>
                    <span class="pb-value">{!! $penerima->status_badge !!}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Tanggal Terima</span>
                    <span class="pb-value">{{ $penerima->tanggal_terima ? $penerima->tanggal_terima->format('d F Y') : '-' }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Keterangan</span>
                    <span class="pb-value">{{ $penerima->keterangan ?? '-' }}</span>
                </div>
            </div>

            <div class="pb-section">
                <h6 class="pb-section-title">
                    <i class="fa-regular fa-clock"></i> Informasi Sistem
                </h6>
                <div class="pb-item">
                    <span class="pb-label">Dibuat Oleh</span>
                    <span class="pb-value">{{ $penerima->creator->name ?? '-' }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Tanggal Dibuat</span>
                    <span class="pb-value">{{ $penerima->created_at->format('d F Y H:i') }}</span>
                </div>
                <div class="pb-item">
                    <span class="pb-label">Terakhir Diupdate</span>
                    <span class="pb-value">{{ $penerima->updated_at->format('d F Y H:i') }}</span>
                </div>
            </div>

        </div>

        {{-- Actions --}}
        <div class="pb-actions">
            <a href="{{ route('admin.penerimabantuan.edit', $penerima->id) }}" class="btn btn-edit">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
            <a href="{{ route('admin.penerimabantuan.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/penerimabantuan/show.js') }}"></script>
@endpush