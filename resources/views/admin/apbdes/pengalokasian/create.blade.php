@extends('layouts.admin')

@section('title', 'Tambah Pengalokasian')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/pengalokasian.css') }}">
@endpush

@section('content')
<div class="pengalokasian-page pengalokasian-create">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Tambah Pengalokasian</h1>
            <p class="page-subtitle">Alokasikan dana ke kegiatan bidang</p>
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
            <form action="{{ route('admin.apbdes.pengalokasian.store') }}" method="POST" class="form-layout" id="formAlokasi">
                @csrf

                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="sumber_dana_id" class="form-label required">Sumber Dana</label>
                        <select name="sumber_dana_id" id="sumber_dana_id" class="form-select @error('sumber_dana_id') is-invalid @enderror" required>
                            <option value="">Pilih Sumber Dana</option>
                            @foreach($sumberDanas as $sumber)
                                <option value="{{ $sumber->id }}" 
                                        data-sisa="{{ $sumber->sisa }}"
                                        {{ old('sumber_dana_id') == $sumber->id ? 'selected' : '' }}>
                                    {{ $sumber->nama_sumber }} ({{ strtoupper($sumber->jenis) }}) - Sisa: Rp {{ number_format($sumber->sisa, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('sumber_dana_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group-half">
                        <label for="bidang_anggaran_id" class="form-label required">Bidang Anggaran</label>
                        <select name="bidang_anggaran_id" id="bidang_anggaran_id" class="form-select @error('bidang_anggaran_id') is-invalid @enderror" required>
                            <option value="">Pilih Bidang</option>
                            @foreach($bidangs as $bidang)
                                <option value="{{ $bidang->id }}" {{ old('bidang_anggaran_id') == $bidang->id ? 'selected' : '' }}>
                                    {{ $bidang->kode_bidang }}. {{ $bidang->nama_bidang }} ({{ $bidang->tahunAnggaran->tahun ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('bidang_anggaran_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- Sisa Info --}}
                <div class="sisa-info" id="sisaInfo" style="display: none;">
                    <span class="sisa-icon">💰</span>
                    <div class="sisa-content">
                        <span class="sisa-label">Sisa Sumber Dana:</span>
                        <span class="sisa-value" id="sisaValue">Rp 0</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_kegiatan" class="form-label required">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-input @error('nama_kegiatan') is-invalid @enderror" value="{{ old('nama_kegiatan') }}" placeholder="Contoh: Pembangunan Jalan Desa" required>
                    @error('nama_kegiatan')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="detail_kegiatan" class="form-label">Detail Kegiatan</label>
                    <textarea name="detail_kegiatan" id="detail_kegiatan" class="form-textarea @error('detail_kegiatan') is-invalid @enderror" rows="3" placeholder="Deskripsi detail kegiatan...">{{ old('detail_kegiatan') }}</textarea>
                    @error('detail_kegiatan')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="nominal" class="form-label required">Nominal Alokasi (Rp)</label>
                        <div class="input-rupiah">
                            <span class="rupiah-prefix">Rp</span>
                            <input type="text" name="nominal" id="nominal" 
                                class="form-input rupiah-input @error('nominal') is-invalid @enderror" 
                                value="{{ old('nominal') }}" 
                                placeholder="0" 
                                inputmode="numeric" 
                                autocomplete="off" 
                                required>
                        </div>
                        @error('nominal')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                        <span class="form-hint" id="nominalHint">Maksimal sesuai sisa sumber dana</span>
                    </div>

                    <div class="form-group form-group-half">
                        <label for="triwulan_target" class="form-label">Target Triwulan</label>
                        <select name="triwulan_target" id="triwulan_target" class="form-select @error('triwulan_target') is-invalid @enderror">
                            <option value="">Pilih Triwulan</option>
                            <option value="I" {{ old('triwulan_target') == 'I' ? 'selected' : '' }}>Triwulan I (Jan-Mar)</option>
                            <option value="II" {{ old('triwulan_target') == 'II' ? 'selected' : '' }}>Triwulan II (Apr-Jun)</option>
                            <option value="III" {{ old('triwulan_target') == 'III' ? 'selected' : '' }}>Triwulan III (Jul-Sep)</option>
                            <option value="IV" {{ old('triwulan_target') == 'IV' ? 'selected' : '' }}>Triwulan IV (Okt-Des)</option>
                        </select>
                        @error('triwulan_target')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.pengalokasian.index') }}" class="btn btn-outline">
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
    <script src="{{ asset('js/admin/apbdes/pengalokasian.js') }}"></script>
@endpush