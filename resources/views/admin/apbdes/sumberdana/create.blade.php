@extends('layouts.admin')

@section('title', 'Tambah Sumber Dana')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/sumberdana.css') }}">
@endpush

@section('content')
<div class="sumberdana-page sumberdana-create">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Tambah Sumber Dana</h1>
            <p class="page-subtitle">Tambah sumber pendapatan baru</p>
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
            <form action="{{ route('admin.apbdes.sumberdana.store') }}" method="POST" class="form-layout">
                @csrf

                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="tahun_anggaran_id" class="form-label required">Tahun Anggaran</label>
                        <select name="tahun_anggaran_id" id="tahun_anggaran_id" class="form-select @error('tahun_anggaran_id') is-invalid @enderror" required>
                            <option value="">Pilih Tahun</option>
                            @foreach($tahunAnggarans as $tahun)
                                <option value="{{ $tahun->id }}" {{ old('tahun_anggaran_id') == $tahun->id ? 'selected' : '' }}>
                                    {{ $tahun->tahun }} ({{ strtoupper($tahun->status) }})
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
                            <option value="apbn" {{ old('jenis') == 'apbn' ? 'selected' : '' }}>APBN (Anggaran Pendapatan Belanja Negara)</option>
                            <option value="apbd_provinsi" {{ old('jenis') == 'apbd_provinsi' ? 'selected' : '' }}>APBD Provinsi</option>
                            <option value="bkk" {{ old('jenis') == 'bkk' ? 'selected' : '' }}>BKK (Bantuan Keuangan Khusus)</option>
                            <option value="pad" {{ old('jenis') == 'pad' ? 'selected' : '' }}>PAD (Pendapatan Asli Desa)</option>
                            <option value="add" {{ old('jenis') == 'add' ? 'selected' : '' }}>ADD (Alokasi Dana Desa)</option>
                            <option value="dd" {{ old('jenis') == 'dd' ? 'selected' : '' }}>DD (Dana Desa)</option>
                            <option value="silpa" {{ old('jenis') == 'silpa' ? 'selected' : '' }}>SILPA (Sisa Lebih Perhitungan Anggaran)</option>
                            <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="nama_sumber" class="form-label required">Nama Sumber</label>
                    <input type="text" name="nama_sumber" id="nama_sumber" class="form-input @error('nama_sumber') is-invalid @enderror" value="{{ old('nama_sumber') }}" placeholder="Contoh: Dana Desa 2026" required>
                    @error('nama_sumber')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nominal_awal" class="form-label required">Nominal Awal (Rp)</label>
                    <span class="form-hint">Nominal akan otomatis menambah total anggaran tahun terkait</span>
                    <div class="input-rupiah">
                        <span class="rupiah-prefix">Rp</span>
                        <input type="text" name="nominal_awal" id="nominal_awal" 
                            class="form-input rupiah-input @error('nominal_awal') is-invalid @enderror" 
                            value="{{ old('nominal_awal') }}" 
                            placeholder="0" 
                            inputmode="numeric" 
                            autocomplete="off" 
                            required>
                    </div>
                    @error('nominal_awal')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" class="form-textarea @error('keterangan') is-invalid @enderror" rows="3" placeholder="Keterangan tambahan...">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.sumberdana.index') }}" class="btn btn-outline">
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
    <script src="{{ asset('js/admin/apbdes/sumberdana.js') }}"></script>
@endpush