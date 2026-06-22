@extends('layouts.admin')

@section('title', 'Tambah Tahun Anggaran')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/tahunanggaran.css') }}">
@endpush

@section('content')
<div class="tahunanggaran-page tahunanggaran-create">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Tambah Tahun Anggaran</h1>
            <p class="page-subtitle">Buat periode anggaran baru dengan 6 bidang default</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    <div class="card card-form">
        <div class="card-body">
            <form action="{{ route('admin.apbdes.tahun.store') }}" method="POST" class="form-layout">
                @csrf

                <div class="form-group">
                    <label for="tahun" class="form-label required">
                        Tahun Anggaran
                    </label>
                    <span class="form-hint">Tahun anggaran harus unik (2000 - 2100)</span>
                    <input type="number" 
                           name="tahun" 
                           id="tahun" 
                           class="form-input @error('tahun') is-invalid @enderror"
                           value="{{ old('tahun', date('Y')) }}"
                           min="2000" 
                           max="2100"
                           placeholder="Contoh: 2026"
                           required>
                    @error('tahun')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label required">Status</label>
                    <span class="form-hint">Jika diaktifkan, tahun lain akan otomatis ditutup</span>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="ditutup" {{ old('status') == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                    @error('status')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="info-box">
                    <span class="info-icon">ℹ️</span>
                    <div class="info-content">
                        <strong>6 Bidang Default akan otomatis dibuat:</strong>
                        <ol class="bidang-list">
                            <li>Bid. Penyelenggaraan Pemerintahan Desa</li>
                            <li>Bid. Pelaksanaan Pembangunan Desa</li>
                            <li>Bid. Pembinaan Kemasyarakatan</li>
                            <li>Bid. Pemberdayaan Masyarakat</li>
                            <li>Bid. Penanggulangan Bencana, Darurat & Mendesak</li>
                            <li>Bid. Lainnya</li>
                        </ol>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.tahun.index') }}" class="btn btn-outline">
                        <span class="btn-icon"></span> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon"></span> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/tahunanggaran.js') }}"></script>
@endpush