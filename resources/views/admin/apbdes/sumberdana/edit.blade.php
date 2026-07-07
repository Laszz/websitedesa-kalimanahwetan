@extends('layouts.admin')

@section('title', 'Edit Sumber Dana')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/sumberdana.css') }}">
@endpush

@section('content')
<div class="sumberdana-page sumberdana-edit">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Edit Sumber Dana</h1>
            <p class="page-subtitle">Perbarui data sumber dana</p>
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
            <form action="{{ route('admin.apbdes.sumberdana.update', $sumber->id) }}" method="POST" class="form-layout" id="formEditSumberDana">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="tahun_anggaran_id" class="form-label required">Tahun Anggaran</label>
                        <select name="tahun_anggaran_id" id="tahun_anggaran_id" class="form-select @error('tahun_anggaran_id') is-invalid @enderror" required>
                            <option value="">Pilih Tahun</option>
                            @foreach($tahunAnggarans as $tahun)
                                <option value="{{ $tahun->id }}" {{ old('tahun_anggaran_id', $sumber->tahun_anggaran_id) == $tahun->id ? 'selected' : '' }}>
                                    {{ $tahun->tahun }} {{ $tahun->status === 'aktif' ? '(Aktif)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_anggaran_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group-half">
                        <label for="jenis" class="form-label required">Jenis Sumber Dana</label>
                        <select name="jenis" id="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                            <option value="">Pilih Jenis</option>
                            @php
                                $jenisList = [
                                    'apbn' => 'APBN',
                                    'apbd_provinsi' => 'APBD Provinsi',
                                    'bkk' => 'BKK',
                                    'pad' => 'PAD',
                                    'add' => 'ADD',
                                    'dd' => 'DD',
                                    'silpa' => 'SILPA',
                                    'lainnya' => 'Lainnya'
                                ];
                            @endphp
                            @foreach($jenisList as $key => $label)
                                <option value="{{ $key }}" {{ old('jenis', $sumber->jenis) == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_sumber" class="form-label required">Nama Sumber</label>
                    <input type="text" name="nama_sumber" id="nama_sumber" class="form-input @error('nama_sumber') is-invalid @enderror" value="{{ old('nama_sumber', $sumber->nama_sumber) }}" required>
                    @error('nama_sumber')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nominal_awal" class="form-label required">Nominal Awal (Rp)</label>
                    <div class="input-rupiah">
                        <span class="rupiah-prefix">Rp</span>
                        <input type="text" name="nominal_awal" id="nominal_awal" 
                               class="form-input rupiah-input @error('nominal_awal') is-invalid @enderror" 
                               value="{{ old('nominal_awal', number_format($sumber->nominal_awal, 0, ',', '.')) }}" 
                               placeholder="0" 
                               inputmode="numeric" 
                               autocomplete="off" 
                               required>
                    </div>
                    @error('nominal_awal')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <span class="form-hint">Minimal: Rp {{ number_format($sumber->nominal_terpakai, 0, ',', '.') }} (sudah terpakai)</span>
                </div>

                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-textarea @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan', $sumber->keterangan) }}</textarea>
                    @error('keterangan')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="alasan_perubahan" class="form-label required">Alasan Perubahan</label>
                    <textarea name="alasan_perubahan" id="alasan_perubahan" class="form-textarea @error('alasan_perubahan') is-invalid @enderror" rows="3" placeholder="Jelaskan alasan perubahan data..." required>{{ old('alasan_perubahan') }}</textarea>
                    @error('alasan_perubahan')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    <span class="form-hint warning">Wajib diisi untuk keperluan audit trail</span>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.sumberdana.index') }}" class="btn btn-outline">
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
    <script src="{{ asset('js/admin/apbdes/sumberdana.js') }}"></script>
@endpush