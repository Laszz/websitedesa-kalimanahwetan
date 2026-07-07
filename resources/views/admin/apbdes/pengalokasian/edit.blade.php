@extends('layouts.admin')

@section('title', 'Edit Pengalokasian - ' . $pengalokasian->nama_kegiatan)

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/pengalokasian.css') }}">
@endpush

@section('content')
<div class="pengalokasian-page pengalokasian-edit">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Edit Pengalokasian</h1>
            <p class="page-subtitle">{{ $pengalokasian->nama_kegiatan }}</p>
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
            <form action="{{ route('admin.apbdes.pengalokasian.update', $pengalokasian->id) }}" method="POST" class="form-layout" id="formEditAlokasi">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="sumber_dana_id" class="form-label required">Sumber Dana</label>
                        <select name="sumber_dana_id" id="sumber_dana_id" class="form-select @error('sumber_dana_id') is-invalid @enderror" required>
                            <option value="">Pilih Sumber Dana</option>
                            @foreach($sumberDanas as $sumber)
                                <option value="{{ $sumber->id }}" {{ old('sumber_dana_id', $pengalokasian->sumber_dana_id) == $sumber->id ? 'selected' : '' }}>
                                    {{ $sumber->nama_sumber }} ({{ strtoupper($sumber->jenis) }})
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
                                <option value="{{ $bidang->id }}" {{ old('bidang_anggaran_id', $pengalokasian->bidang_anggaran_id) == $bidang->id ? 'selected' : '' }}>
                                    {{ $bidang->kode_bidang }}. {{ $bidang->nama_bidang }}
                                </option>
                            @endforeach
                        </select>
                        @error('bidang_anggaran_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_kegiatan" class="form-label required">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" id="nama_kegiatan" class="form-input @error('nama_kegiatan') is-invalid @enderror" value="{{ old('nama_kegiatan', $pengalokasian->nama_kegiatan) }}" required>
                    @error('nama_kegiatan')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="detail_kegiatan" class="form-label">Detail Kegiatan</label>
                    <textarea name="detail_kegiatan" id="detail_kegiatan" class="form-textarea @error('detail_kegiatan') is-invalid @enderror" rows="3">{{ old('detail_kegiatan', $pengalokasian->detail_kegiatan) }}</textarea>
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
                                   value="{{ old('nominal', number_format($pengalokasian->nominal, 0, ',', '.')) }}" 
                                   placeholder="0" 
                                   inputmode="numeric" 
                                   autocomplete="off" 
                                   required>
                        </div>
                        @error('nominal')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group-half">
                        <label for="triwulan_target" class="form-label">Target Triwulan</label>
                        <select name="triwulan_target" id="triwulan_target" class="form-select @error('triwulan_target') is-invalid @enderror">
                            <option value="">Pilih Triwulan</option>
                            <option value="I" {{ old('triwulan_target', $pengalokasian->triwulan_target) == 'I' ? 'selected' : '' }}>Triwulan I</option>
                            <option value="II" {{ old('triwulan_target', $pengalokasian->triwulan_target) == 'II' ? 'selected' : '' }}>Triwulan II</option>
                            <option value="III" {{ old('triwulan_target', $pengalokasian->triwulan_target) == 'III' ? 'selected' : '' }}>Triwulan III</option>
                            <option value="IV" {{ old('triwulan_target', $pengalokasian->triwulan_target) == 'IV' ? 'selected' : '' }}>Triwulan IV</option>
                        </select>
                        @error('triwulan_target')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label required">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="direncanakan" {{ old('status', $pengalokasian->status) == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
                        <option value="disetujui" {{ old('status', $pengalokasian->status) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ old('status', $pengalokasian->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="revisi" {{ old('status', $pengalokasian->status) == 'revisi' ? 'selected' : '' }}>Revisi</option>
                    </select>
                    @error('status')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alasan_perubahan" class="form-label required">Alasan Perubahan</label>
                    <textarea name="alasan_perubahan" id="alasan_perubahan" class="form-textarea @error('alasan_perubahan') is-invalid @enderror" rows="3" placeholder="Jelaskan alasan perubahan minimal 10 karakter..." required>{{ old('alasan_perubahan') }}</textarea>
                    @error('alasan_perubahan')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">Perubahan akan dicatat di audit log</span>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.pengalokasian.index') }}" class="btn btn-outline">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
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