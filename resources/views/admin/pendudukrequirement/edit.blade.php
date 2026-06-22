@extends('layouts.admin')

@section('title', 'Edit Syarat - ' . $layanan->nama_layanan)

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/pendudukrequirement/edit.css') }}">
<script src="{{ asset('js/admin/pendudukrequirement/edit.js') }}" defer></script>

<div class="admin-container">

    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                Edit Syarat
            </h1>
            <p class="page-subtitle">{{ $layanan->nama_layanan }}</p>
        </div>
    </div>

    <div class="card-glass form-card">
        <form action="{{ route('admin.pendudukrequirement.update', $requirement->id) }}" method="POST" id="syaratForm">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group full-width">
                    <label class="form-label">Nama Syarat <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <input type="text" name="nama_syarat" class="input-modern" value="{{ old('nama_syarat', $requirement->nama_syarat) }}" required>
                    </div>
                    @error('nama_syarat')<div class="error-box">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Tipe <span class="required">*</span></label>
                    <div class="input-wrapper">
                        <select name="tipe" class="input-modern" required>
                            <option value="file" {{ old('tipe', $requirement->tipe) == 'file' ? 'selected' : '' }}>📎 File Upload</option>
                            <option value="text" {{ old('tipe', $requirement->tipe) == 'text' ? 'selected' : '' }}>📝 Input Teks</option>
                        </select>
                    </div>
                    @error('tipe')<div class="error-box">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div class="checkbox-wrapper">
                        <label class="checkbox-label">
                            <input type="checkbox" name="wajib" value="1" {{ old('wajib', $requirement->wajib) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span class="checkbox-text">Wajib diisi oleh warga</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.pendudukrequirement.index', $layanan->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success" id="btnSubmit">
                    <span class="btn-text">Update Syarat</span>
                    <div class="btn-loader" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </button>
            </div>

        </form>
    </div>

</div>
@endsection