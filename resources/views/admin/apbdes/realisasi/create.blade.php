@extends('layouts.admin')

@section('title', 'Tambah Realisasi')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/realisasi.css') }}">
@endpush

@section('content')
<div class="realisasi-page realisasi-create">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Tambah Realisasi</h1>
            <p class="page-subtitle">Catat pemakaian dana bulanan</p>
        </div>
    </div>

    {{-- Alert Messages --}}
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

    <div class="card card-form">
        <div class="card-body">
            <form action="{{ route('admin.apbdes.realisasi.store') }}" method="POST" class="form-layout" id="formRealisasi" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="pengalokasian_dana_id" class="form-label required">
                        <i class="fas fa-tasks"></i> Kegiatan (Alokasi Disetujui)
                    </label>
                    <select name="pengalokasian_dana_id" id="pengalokasian_dana_id" class="form-select @error('pengalokasian_dana_id') is-invalid @enderror" required>
                        <option value="">Pilih Kegiatan</option>
                        @foreach($pengalokasians as $alokasi)
                            <option value="{{ $alokasi->id }}" 
                                    data-sisa="{{ $alokasi->sisa }}"
                                    data-sumber="{{ $alokasi->sumber_dana_id }}"
                                    {{ old('pengalokasian_dana_id') == $alokasi->id ? 'selected' : '' }}>
                                {{ $alokasi->nama_kegiatan }} - {{ $alokasi->bidangAnggaran->nama_bidang ?? '-' }} 
                                (Sisa: Rp {{ number_format($alokasi->sisa, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    @error('pengalokasian_dana_id')
                        <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                    @enderror
                </div>

                {{-- Sisa Info --}}
                <div class="sisa-info" id="sisaInfo" style="display: none;">
                    <span class="sisa-icon"><i class="fas fa-coins"></i></span>
                    <div class="sisa-content">
                        <span class="sisa-label">Sisa Alokasi Kegiatan:</span>
                        <span class="sisa-value" id="sisaValue">Rp 0</span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label for="tahun" class="form-label required">
                            <i class="fas fa-calendar-alt"></i> Tahun
                        </label>
                        <input type="number" name="tahun" id="tahun" class="form-input @error('tahun') is-invalid @enderror" value="{{ old('tahun', date('Y')) }}" min="2000" max="2100" required>
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
                                <option value="{{ $bulan }}" {{ old('bulan') == $bulan ? 'selected' : '' }}>
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
                            <option value="I" {{ old('triwulan') == 'I' ? 'selected' : '' }}>Triwulan I (Jan-Mar)</option>
                            <option value="II" {{ old('triwulan') == 'II' ? 'selected' : '' }}>Triwulan II (Apr-Jun)</option>
                            <option value="III" {{ old('triwulan') == 'III' ? 'selected' : '' }}>Triwulan III (Jul-Sep)</option>
                            <option value="IV" {{ old('triwulan') == 'IV' ? 'selected' : '' }}>Triwulan IV (Okt-Des)</option>
                        </select>
                        @error('triwulan')
                            <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group form-group-half">
                        <label for="nominal_digunakan" class="form-label required">
                            <i class="fas fa-money-bill-wave"></i> Nominal Digunakan (Rp)
                        </label>
                        <div class="input-rupiah">
                            <span class="rupiah-prefix">Rp</span>
                            <input type="text" name="nominal_digunakan" id="nominal_digunakan" 
                                class="form-input rupiah-input @error('nominal_digunakan') is-invalid @enderror" 
                                value="{{ old('nominal_digunakan') }}" 
                                placeholder="0" 
                                inputmode="numeric" 
                                autocomplete="off" 
                                required>
                        </div>
                        @error('nominal_digunakan')
                            <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                        @enderror
                        <span class="form-hint" id="nominalHint"><i class="fas fa-info-circle"></i> Maksimal sesuai sisa alokasi</span>
                    </div>
                </div>  

                <div class="form-group">
                    <label for="keterangan_pemakaian" class="form-label required">
                        <i class="fas fa-align-left"></i> Keterangan Pemakaian
                    </label>
                    <textarea name="keterangan_pemakaian" id="keterangan_pemakaian" class="form-textarea @error('keterangan_pemakaian') is-invalid @enderror" rows="3" placeholder="Jelaskan detail penggunaan dana..." required>{{ old('keterangan_pemakaian') }}</textarea>
                    @error('keterangan_pemakaian')
                        <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bukti_transaksi" class="form-label">
                        <i class="fas fa-file-upload"></i> Bukti Transaksi
                    </label>
                    <input type="file" name="bukti_transaksi" id="bukti_transaksi" class="form-file @error('bukti_transaksi') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                    @error('bukti_transaksi')
                        <span class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                    @enderror
                    <span class="form-hint"><i class="fas fa-info-circle"></i> PDF, JPG, JPEG, PNG. Maksimal 2MB</span>
                    <div class="file-preview" id="filePreview"></div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.apbdes.realisasi.index') }}" class="btn btn-outline">Batal</a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-floppy-disk"></i> Simpan
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