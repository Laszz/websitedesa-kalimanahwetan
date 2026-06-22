@extends('layouts.admin')

@section('title', 'Edit Realisasi')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/realisasi.css') }}">
@endpush

@section('content')
<div class="realisasi-page realisasi-edit">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title"><i class="fas fa-edit"></i> Edit Realisasi</h1>
            <p class="page-subtitle"><i class="fas fa-info-circle"></i> Perbarui data pemakaian dana</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span class="alert-icon"><i class="fas fa-times-circle"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup"><i class="fas fa-times"></i></button>
        </div>
    @endif

    <div class="card card-form">
        <div class="card-body">
            <form action="{{ route('admin.apbdes.realisasi.update', $realisasi->id) }}" method="POST" class="form-layout" id="formEditRealisasi" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="pengalokasian_dana_id" class="form-label required">
                        <i class="fas fa-tasks"></i> Kegiatan
                    </label>
                    <select name="pengalokasian_dana_id" id="pengalokasian_dana_id" class="form-select @error('pengalokasian_dana_id') is-invalid @enderror" required>
                        <option value=""><i class="fas fa-hand-pointer"></i> Pilih Kegiatan</option>
                        @foreach($pengalokasians as $alokasi)
                            <option value="{{ $alokasi->id }}" {{ old('pengalokasian_dana_id', $realisasi->pengalokasian_dana_id) == $alokasi->id ? 'selected' : '' }}>
                                {{ $alokasi->nama_kegiatan }} - {{ $alokasi->bidangAnggaran->nama_bidang ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                    @error('pengalokasian_dana_id')
                        <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="tahun" class="form-label required">
                            <i class="fas fa-calendar-alt"></i> Tahun
                        </label>
                        <input type="number" name="tahun" id="tahun" class="form-input @error('tahun') is-invalid @enderror" value="{{ old('tahun', $realisasi->tahun) }}" min="2000" max="2100" required>
                        @error('tahun')
                            <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group-half">
                        <label for="bulan" class="form-label required">
                            <i class="fas fa-calendar"></i> Bulan
                        </label>
                        <select name="bulan" id="bulan" class="form-select @error('bulan') is-invalid @enderror" required>
                            <option value="">Pilih Bulan</option>
                            @foreach(range(1, 12) as $bulan)
                                <option value="{{ $bulan }}" {{ old('bulan', $realisasi->bulan) == $bulan ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                        @error('bulan')
                            <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="triwulan" class="form-label required">
                            <i class="fas fa-chart-pie"></i> Triwulan
                        </label>
                        <select name="triwulan" id="triwulan" class="form-select @error('triwulan') is-invalid @enderror" required>
                            <option value="">Pilih Triwulan</option>
                            <option value="I" {{ old('triwulan', $realisasi->triwulan) == 'I' ? 'selected' : '' }}>Triwulan I</option>
                            <option value="II" {{ old('triwulan', $realisasi->triwulan) == 'II' ? 'selected' : '' }}>Triwulan II</option>
                            <option value="III" {{ old('triwulan', $realisasi->triwulan) == 'III' ? 'selected' : '' }}>Triwulan III</option>
                            <option value="IV" {{ old('triwulan', $realisasi->triwulan) == 'IV' ? 'selected' : '' }}>Triwulan IV</option>
                        </select>
                        @error('triwulan')
                            <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group-half">
                        <label for="nominal_digunakan" class="form-label required">
                            <i class="fas fa-money-bill-wave"></i> Nominal Digunakan (Rp)
                        </label>
                        <input type="number" name="nominal_digunakan" id="nominal_digunakan" class="form-input @error('nominal_digunakan') is-invalid @enderror" value="{{ old('nominal_digunakan', $realisasi->nominal_digunakan) }}" min="0" step="0.01" required>
                        @error('nominal_digunakan')
                            <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="keterangan_pemakaian" class="form-label required">
                        <i class="fas fa-align-left"></i> Keterangan Pemakaian
                    </label>
                    <textarea name="keterangan_pemakaian" id="keterangan_pemakaian" class="form-textarea @error('keterangan_pemakaian') is-invalid @enderror" rows="3" required>{{ old('keterangan_pemakaian', $realisasi->keterangan_pemakaian) }}</textarea>
                    @error('keterangan_pemakaian')
                        <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bukti_transaksi" class="form-label">
                        <i class="fas fa-file-upload"></i> Bukti Transaksi
                    </label>
                    @if($realisasi->bukti_transaksi)
                    <div class="current-file">
                        <span class="current-file-label"><i class="fas fa-paperclip"></i> File saat ini:</span>
                        <a href="{{ Storage::url($realisasi->bukti_transaksi) }}" target="_blank" class="btn btn-sm btn-primary">
                            <i class="fas fa-file-pdf"></i> Lihat
                        </a>
                    </div>
                    @endif
                    <input type="file" name="bukti_transaksi" id="bukti_transaksi" class="form-file @error('bukti_transaksi') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('bukti_transaksi')
                        <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                    @enderror
                    <span class="form-hint"><i class="fas fa-info-circle"></i> Upload file baru untuk mengganti. PDF, JPG, JPEG, PNG. Maksimal 2MB</span>
                    <div class="file-preview" id="filePreview"></div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.realisasi.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
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