@extends('layouts.admin')

@section('title', 'Edit Jenis Bantuan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/jenisbantuan/edit.css') }}">
@endpush

@section('content')
<div class="container-fluid">

    {{-- Alerts --}}
    @if(session('error'))
        <div class="alert jb-alert jb-alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="jb-page-header">
        <h1 class="jb-page-title">Edit Jenis Bantuan</h1>
        <a href="{{ route('admin.jenisbantuan.index') }}" class="jb-btn-secondary">
        </a>
    </div>

    {{-- Form Card --}}
    <div class="card jb-form-card">
        <div class="card-header jb-form-card-header">
            <h5><i class="fas fa-edit"></i> Form Edit Jenis Bantuan</h5>
        </div>
        <div class="card-body jb-form-card-body">
            <form action="{{ route('admin.jenisbantuan.update', $jenisBantuan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label jb-form-label">Kode Bantuan <span class="jb-required">*</span></label>
                        <input type="text" name="kode_bantuan" class="form-control jb-form-input @error('kode_bantuan') is-invalid @enderror" value="{{ old('kode_bantuan', $jenisBantuan->kode_bantuan) }}" required>
                        @error('kode_bantuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label jb-form-label">Nama Bantuan <span class="jb-required">*</span></label>
                        <input type="text" name="nama_bantuan" class="form-control jb-form-input @error('nama_bantuan') is-invalid @enderror" value="{{ old('nama_bantuan', $jenisBantuan->nama_bantuan) }}" required>
                        @error('nama_bantuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label jb-form-label">Sumber Dana</label>
                        <input type="text" name="sumber_dana" class="form-control jb-form-input @error('sumber_dana') is-invalid @enderror" value="{{ old('sumber_dana', $jenisBantuan->sumber_dana) }}">
                        @error('sumber_dana')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label jb-form-label">Tahun Anggaran <span class="jb-required">*</span></label>
                        <select name="tahun_anggaran_id" class="form-select jb-form-select @error('tahun_anggaran_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Tahun Anggaran --</option>
                            @foreach($tahunAnggarans as $ta)
                                <option value="{{ $ta->id }}" {{ old('tahun_anggaran_id', $jenisBantuan->tahun_anggaran_id) == $ta->id ? 'selected' : '' }}>
                                    {{ $ta->tahun }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_anggaran_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label jb-form-label">Anggaran per KK (Rp) <span class="jb-required">*</span></label>
                        <input type="number" name="anggaran_per_kk" class="form-control jb-form-input @error('anggaran_per_kk') is-invalid @enderror" value="{{ old('anggaran_per_kk', $jenisBantuan->anggaran_per_kk) }}" required>
                        @error('anggaran_per_kk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="jb-form-actions">
                    <button type="submit" class="jb-btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('admin.jenisbantuan.index') }}" class="jb-btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/jenisbantuan/edit.js') }}"></script>
@endpush