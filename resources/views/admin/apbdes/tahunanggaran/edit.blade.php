@extends('layouts.admin')

@section('title', 'Edit Tahun Anggaran ' . $tahun->tahun)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/tahunanggaran.css') }}">
@endpush

@section('content')
<div class="tahunanggaran-page tahunanggaran-edit">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Edit Tahun Anggaran {{ $tahun->tahun }}</h1>
            <p class="page-subtitle">Perbarui status periode anggaran</p>
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
            <form action="{{ route('admin.apbdes.tahun.update', $tahun->id) }}" method="POST" class="form-layout">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="tahun" class="form-label required">Tahun Anggaran</label>
                    <input type="number" 
                           name="tahun" 
                           id="tahun" 
                           class="form-input @error('tahun') is-invalid @enderror"
                           value="{{ old('tahun', $tahun->tahun) }}"
                           min="2000" 
                           max="2100"
                           required>
                    @error('tahun')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="form-label required">Status</label>
                    @if($tahun->status !== 'aktif')
                    <span class="form-hint warning">Jika diaktifkan, tahun lain yang aktif akan otomatis ditutup</span>
                    @endif
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="draft" {{ old('status', $tahun->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="aktif" {{ old('status', $tahun->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="ditutup" {{ old('status', $tahun->status) == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                    @error('status')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="readonly-card">
                    <h3 class="readonly-title">Ringkasan Keuangan</h3>
                    <div class="readonly-info">
                        <div class="info-row">
                            <span class="info-label">Total Anggaran</span>
                            <span class="info-value">Rp {{ number_format($tahun->total_anggaran, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Total Realisasi</span>
                            <span class="info-value">Rp {{ number_format($tahun->total_realisasi, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Sisa Anggaran</span>
                            <span class="info-value {{ $tahun->sisa < 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($tahun->sisa, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.tahun.index') }}" class="btn btn-outline">
                        <span class="btn-icon"></span> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon"></span> Simpan Perubahan
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