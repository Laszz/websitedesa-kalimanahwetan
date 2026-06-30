@extends('layouts.admin')

@section('title', 'Edit Aduan')

@section('content')
<div class="edit-form-container">
    <div class="edit-form">
        <h2>Edit Aduan</h2>

        <form action="{{ route('admin.aduan.update', $aduan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="form-group">
                <label>Nama</label>
                <input type="text" value="{{ $aduan->user->nama ?? $aduan->nama }}" readonly class="form-control">
            </div>

            {{-- Judul --}}
            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ old('judul', $aduan->judul) }}" class="form-control" required>
            </div>

            {{-- Nomor WA --}}
            <div class="form-group">
                <label>Nomor WA</label>
                <input type="text" name="nomor_wa" value="{{ old('nomor_wa', $aduan->nomor_wa) }}" class="form-control" required>
            </div>

            {{-- Detail --}}
            <div class="form-group">
                <label>Detail Aduan</label>
                <textarea name="detail" class="form-control" rows="4" required>{{ old('detail', $aduan->detail) }}</textarea>
            </div>

            {{-- Gambar --}}
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control">
                @if($aduan->gambar)
                    <div class="preview-wrapper">
                        <img src="{{ asset('storage/'.$aduan->gambar) }}" class="preview-img" alt="Preview">
                    </div>
                @endif
            </div>

            {{-- Alamat --}}
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" value="{{ old('alamat', $aduan->alamat) }}" class="form-control" required>
            </div>

            {{-- Kategori --}}
            <div class="form-group">
                <label>Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori', $aduan->kategori) }}" class="form-control">
            </div>

            {{-- Prioritas --}}
            <div class="form-group">
                <label>Prioritas</label>
                <select name="prioritas" class="form-select">
                    <option value="normal" {{ old('prioritas', $aduan->prioritas) == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="penting" {{ old('prioritas', $aduan->prioritas) == 'penting' ? 'selected' : '' }}>Penting</option>
                    <option value="darurat" {{ old('prioritas', $aduan->prioritas) == 'darurat' ? 'selected' : '' }}>Darurat</option>
                </select>
            </div>

            {{-- Status --}}
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option value="menunggu" {{ old('status', $aduan->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ old('status', $aduan->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ old('status', $aduan->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- Tampilkan --}}
            <div class="form-check">
                <input type="hidden" name="tampilkan" value="0">
                <input type="checkbox" name="tampilkan" value="1" id="tampilkan"
                    {{ old('tampilkan', $aduan->tampilkan) ? 'checked' : '' }}>
                <label for="tampilkan">Tampilkan di publik</label>
            </div>

            {{-- Tombol --}}
            <div class="form-actions">
                <button type="submit" class="btn-update">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.aduan.index') }}" class="btn-back">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/aduan/edit.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/admin/aduan/edit.js') }}"></script>
@endpush