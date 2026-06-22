@extends('layouts.admin')

@section('title', 'Verifikasi Realisasi')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/realisasi.css') }}">
@endpush

@section('content')
<div class="realisasi-page realisasi-verify">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title"><i class="fas fa-check-circle"></i> Verifikasi Realisasi</h1>
            <p class="page-subtitle"><i class="fas fa-info-circle"></i> Review dan verifikasi pemakaian dana</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon"><i class="fas fa-circle-check"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span class="alert-icon"><i class="fas fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
        </div>
    @endif

    {{-- Info Realisasi --}}
    <div class="verify-info-grid">
        <div class="verify-info-item">
            <span class="verify-info-label"><i class="fas fa-tasks"></i> Kegiatan</span>
            <span class="verify-info-value">{{ $realisasi->pengalokasian->nama_kegiatan ?? '-' }}</span>
        </div>
        <div class="verify-info-item">
            <span class="verify-info-label"><i class="fas fa-coins"></i> Sumber Dana</span>
            <span class="verify-info-value">{{ $realisasi->sumberDana->nama_sumber ?? '-' }}</span>
        </div>
        <div class="verify-info-item">
            <span class="verify-info-label"><i class="fas fa-calendar-alt"></i> Periode</span>
            <span class="verify-info-value">{{ $realisasi->bulan }}/{{ $realisasi->tahun }} (TW {{ $realisasi->triwulan }})</span>
        </div>
        <div class="verify-info-item">
            <span class="verify-info-label"><i class="fas fa-money-bill-wave"></i> Nominal Digunakan</span>
            <span class="verify-info-value highlight" data-counter>Rp {{ number_format($realisasi->nominal_digunakan, 0, ',', '.') }}</span>
        </div>
        <div class="verify-info-item">
            <span class="verify-info-label"><i class="fas fa-piggy-bank"></i> Sisa Alokasi Kegiatan</span>
            <span class="verify-info-value {{ $realisasi->pengalokasian->sisa >= 0 ? 'text-success' : 'text-danger' }}" data-counter>
                Rp {{ number_format($realisasi->pengalokasian->sisa ?? 0, 0, ',', '.') }}
            </span>
        </div>
        <div class="verify-info-item">
            <span class="verify-info-label"><i class="fas fa-user"></i> Dibuat Oleh</span>
            <span class="verify-info-value">{{ $realisasi->creator->name ?? '-' }}</span>
        </div>
    </div>

    {{-- Keterangan --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-align-left"></i> Keterangan Pemakaian</h2>
        </div>
        <div class="card-body">
            <p class="verify-keterangan-text">{{ $realisasi->keterangan_pemakaian }}</p>
        </div>
    </div>

    {{-- Bukti Transaksi --}}
    @if($realisasi->bukti_transaksi)
    <div class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-paperclip"></i> Bukti Transaksi</h2>
        </div>
        <div class="card-body">
            <div class="verify-bukti">
                <a href="{{ Storage::url($realisasi->bukti_transaksi) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-file-pdf"></i> Lihat Bukti
                </a>
                <span class="form-hint"><i class="fas fa-info-circle"></i> File akan dibuka di tab baru</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Form Verifikasi --}}
    <div class="card card-form">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-scale-balanced"></i> Keputusan Verifikasi</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.apbdes.realisasi.verify', $realisasi->id) }}" method="POST" class="form-layout" id="formVerifikasi">
                @csrf

                <div class="radio-group">
                    <label class="radio-card radio-approve">
                        <input type="radio" name="status" value="terverifikasi" {{ old('status') == 'terverifikasi' ? 'checked' : '' }}>
                        <span class="radio-icon"><i class="fas fa-check-circle"></i></span>
                        <span class="radio-label">Setujui</span>
                        <span class="radio-desc">Realisasi diterima dan dana dicatat terpakai</span>
                    </label>

                    <label class="radio-card radio-reject">
                        <input type="radio" name="status" value="ditolak" {{ old('status') == 'ditolak' ? 'checked' : '' }}>
                        <span class="radio-icon"><i class="fas fa-circle-xmark"></i></span>
                        <span class="radio-label">Tolak</span>
                        <span class="radio-desc">Realisasi ditolak, dana tidak dicatat terpakai</span>
                    </label>
                </div>
                @error('status')
                    <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                @enderror

                <div class="form-group" id="alasanGroup" style="display: none;">
                    <label for="alasan_penolakan" class="form-label required"><i class="fas fa-comment-dots"></i> Alasan Penolakan</label>
                    <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-textarea @error('alasan_penolakan') is-invalid @enderror" rows="3" placeholder="Jelaskan alasan penolakan...">{{ old('alasan_penolakan') }}</textarea>
                    @error('alasan_penolakan')
                        <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.realisasi.index') }}" class="btn btn-outline">
                        <i class="fas fa-xmark"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary" id="btnVerify">
                        <i class="fas fa-check-circle"></i> Proses Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/realisasi.js') }}"></script>
@endpush