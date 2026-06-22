@extends('layouts.admin')

@section('title', 'Tambah Penerima Bantuan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/penerimabantuan/create.css') }}">
@endpush

@section('content')
<div class="container-fluid">

    {{-- Alerts --}}
    @if(session('error'))
        <div class="alert pb-alert pb-alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="pb-page-header">
        <h1 class="pb-page-title">Tambah Penerima Bantuan</h1>
    </div>

    {{-- Form Card --}}
    <div class="card pb-form-card">
        <div class="card-header pb-form-card-header">
            <h5><i class="fas fa-user-plus"></i> Form Penerima Bantuan</h5>
        </div>
        <div class="card-body pb-form-card-body">
            <form action="{{ route('admin.penerimabantuan.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label pb-form-label">Warga <span class="pb-required">*</span></label>
                        <select name="warga_id" class="form-select pb-form-select @error('warga_id') is-invalid @enderror" id="warga-select" required>
                            <option value="">-- Pilih Warga --</option>
                            @foreach($wargas as $w)
                                <option value="{{ $w->id }}" data-desil="{{ $w->desil }}" {{ old('warga_id') == $w->id ? 'selected' : '' }}>
                                    {{ $w->nik }} - {{ $w->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('warga_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label pb-form-label">Jenis Bantuan <span class="pb-required">*</span></label>
                        <select name="jenis_bantuan_id" class="form-select pb-form-select @error('jenis_bantuan_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis Bantuan --</option>
                            @foreach($jenisBantuans as $jb)
                                <option value="{{ $jb->id }}" {{ old('jenis_bantuan_id') == $jb->id ? 'selected' : '' }}>
                                    {{ $jb->kode_bantuan }} - {{ $jb->nama_bantuan }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_bantuan_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label pb-form-label">Desil <span class="pb-required">*</span></label>
                        <select name="desil" class="form-select pb-form-select @error('desil') is-invalid @enderror" id="desil-select" required>
                            <option value="">-- Pilih Desil --</option>
                            @foreach($desilList as $d)
                                <option value="{{ $d }}" {{ old('desil') == $d ? 'selected' : '' }}>
                                    Desil {{ $d }} {{ $d <= 3 ? '(Prioritas)' : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('desil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="pb-form-hint">Auto-isi dari data warga, bisa diubah manual</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label pb-form-label">Status <span class="pb-required">*</span></label>
                        <select name="status" class="form-select pb-form-select @error('status') is-invalid @enderror" required>
                            <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="dicabut" {{ old('status') == 'dicabut' ? 'selected' : '' }}>Dicabut</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label pb-form-label">Tanggal Terima</label>
                        <input type="date" name="tanggal_terima" class="form-control pb-form-input @error('tanggal_terima') is-invalid @enderror" value="{{ old('tanggal_terima') }}">
                        @error('tanggal_terima')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label pb-form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control pb-form-input @error('keterangan') is-invalid @enderror" rows="3">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="pb-form-actions">
                    <button type="submit" class="pb-btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.penerimabantuan.index') }}" class="pb-btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/penerimabantuan/create.js') }}"></script>
@endpush