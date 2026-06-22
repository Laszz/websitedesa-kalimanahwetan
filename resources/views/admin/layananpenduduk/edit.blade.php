@extends('layouts.admin')

@section('title', 'Edit Layanan Penduduk')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/layananpenduduk/edit.css') }}">
<script src="{{ asset('js/admin/layananpenduduk/edit.js') }}" defer></script>

<div class="admin-container">

    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                Edit Layanan Penduduk
            </h1>
            <p class="page-subtitle">Perbarui data layanan: {{ $layanan->nama_layanan }}</p>
        </div>
    </div>

    <div class="card-glass form-card">
        <form action="{{ route('admin.layananpenduduk.update', $layanan->id) }}" method="POST" id="layananForm">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">Nama Layanan <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_layanan" class="input-modern" value="{{ old('nama_layanan', $layanan->nama_layanan) }}" required>
                    </div>
                    @error('nama_layanan')<div class="error-box">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select name="kategori" class="input-modern" required>
                            <option value="">-- Pilih Kategori --</option>
                            <option value="layanan_administrasi_penduduk" {{ old('kategori', $layanan->kategori) == 'layanan_administrasi_penduduk' ? 'selected' : '' }}>Administrasi Penduduk</option>
                            <option value="layanan_administrasi_umum" {{ old('kategori', $layanan->kategori) == 'layanan_administrasi_umum' ? 'selected' : '' }}>Administrasi Umum</option>
                            <option value="layanan_hukum_tanah" {{ old('kategori', $layanan->kategori) == 'layanan_hukum_tanah' ? 'selected' : '' }}>Hukum Tanah</option>
                        </select>
                    </div>
                    @error('kategori')<div class="error-box">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Output</label>
                    <div class="input-wrapper">
                        <input type="text" name="output" class="input-modern" value="{{ old('output', $layanan->output) }}" placeholder="Contoh: Surat Keterangan">
                    </div>
                    @error('output')<div class="error-box">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="input-wrapper">
                        <select name="status" class="input-modern">
                            <option value="1" {{ old('status', $layanan->status) == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status', $layanan->status) == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    @error('status')<div class="error-box">{{ $message }}</div>@enderror
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Deskripsi</label>
                    <div class="input-wrapper">
                        <textarea name="deskripsi" class="input-modern textarea" rows="4" placeholder="Jelaskan layanan ini...">{{ old('deskripsi', $layanan->deskripsi) }}</textarea>
                    </div>
                    @error('deskripsi')<div class="error-box">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.layananpenduduk.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success" id="btnSubmit">
                    <span class="btn-text">Update Layanan</span>
                    <div class="btn-loader" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection