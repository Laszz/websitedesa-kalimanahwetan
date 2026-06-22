@extends('layouts.app')

@section('title', 'Buat Aduan Baru')

@section('content')
<link rel="stylesheet" href="{{ asset('css/warga/aduan/create.css') }}">
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<div class="aduan-form-container">
    <h2 class="form-title">Buat Aduan Baru</h2>

    <form action="{{ route('warga.aduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="judul">Judul Aduan <span class="text-danger">*</span></label>
        <input type="text" id="judul" name="judul"
               value="{{ old('judul') }}"
               required placeholder="Masukkan judul aduan">

        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama"
               value="{{ Auth::user()->name ?? '' }}"
               readonly>

        <label for="nomor_wa">Nomor WhatsApp <span class="text-danger">*</span></label>
        <input type="tel" id="nomor_wa" name="nomor_wa"
               value="{{ old('nomor_wa') }}"
               required placeholder="08xxxxxxxxxx"
               pattern="^08[0-9]{8,13}$"
               title="Nomor WA harus diawali 08 dan panjang 10–13 digit">

        <label for="detail">Detail Aduan <span class="text-danger">*</span></label>
        <textarea id="detail" name="detail" rows="5" required
                  placeholder="Tulis detail aduanmu di sini...">{{ old('detail') }}</textarea>

        <label for="kategori">Kategori Aduan <span class="text-danger">*</span></label>
        <select id="kategori" name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="infrastruktur" {{ old('kategori') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
            <option value="lingkungan" {{ old('kategori') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
            <option value="pelayanan" {{ old('kategori') == 'pelayanan' ? 'selected' : '' }}>Pelayanan Publik</option>
            <option value="keamanan" {{ old('kategori') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
            <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>

        <label for="prioritas">Prioritas <span class="text-danger">*</span></label>
        <select id="prioritas" name="prioritas" required>
            <option value="darurat" {{ old('prioritas') == 'darurat' ? 'selected' : '' }}>Darurat</option>
            <option value="penting" {{ old('prioritas') == 'penting' ? 'selected' : '' }}>Penting</option>
            <option value="normal" {{ old('prioritas') == 'normal' ? 'selected' : '' }}>Normal</option>
        </select>

        <label for="gambar">Gambar (opsional)</label>
        <input type="file" id="gambar" name="gambar" accept="image/*">
        <small class="text-muted d-block">Maksimal ukuran file 10 MB (jpg, jpeg, png)</small>

        <label for="map">Pilih Lokasi di Peta</label>
        <div id="map" style="height: 300px; margin-bottom: 10px;"></div>

        <label for="alamat">Alamat <span class="text-danger">*</span></label>
        <input type="text" id="alamat" name="alamat"
               value="{{ old('alamat') }}"
               required placeholder="Geser peta atau ketik alamat">

        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">

        <button type="submit" class="btn-submit mt-3">Kirim Aduan</button>
    </form>
</div>

{{-- Custom Popup --}}
<div class="popup-overlay" id="popupOverlay">
    <div class="popup-box">
        <div class="popup-icon" id="popupIcon"><i class="fa-solid fa-circle-info"></i></div>
        <div class="popup-title" id="popupTitle">Informasi</div>
        <div class="popup-text" id="popupText">Pesan</div>
        <div class="popup-actions" id="popupActions">
            <button class="popup-btn popup-btn-primary" onclick="window.closePopup()">OK</button>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="{{ asset('js/warga/aduan/create.js') }}"></script>
@endsection