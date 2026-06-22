@extends('layouts.admin')

@section('title', 'Detail Upload Penduduk')

@section('content')
<div class="upload-admin-container">

    <h1 class="page-title">Detail Pengajuan Penduduk</h1>

    <div class="info-card">
        <h2 class="info-title">Informasi Layanan</h2>

        <p><strong>Layanan:</strong> {{ $pendudukUpload->requirement->name }}</p>

        @if($pendudukUpload->requirement->description)
        <p><strong>Deskripsi:</strong> {{ $pendudukUpload->requirement->description }}</p>
        @endif

        @if($pendudukUpload->requirement->requirements)
        <p><strong>Persyaratan:</strong></p>
        <ul>
            @foreach(json_decode($pendudukUpload->requirement->requirements, true) as $req)
            <li>{{ $req }}</li>
            @endforeach
        </ul>
        @endif
    </div>

    <div class="info-card">
        <h2 class="info-title">Data Pengajuan</h2>

        <p><strong>Nama Penduduk:</strong> {{ $pendudukUpload->user->name }}</p>

        @if($pendudukUpload->note)
        <p><strong>Catatan Penduduk:</strong> {{ $pendudukUpload->note }}</p>
        @endif

        <p><strong>File Diupload:</strong></p>
        <a href="{{ asset('storage/penduduk_upload/' . $pendudukUpload->file) }}"
           target="_blank" class="file-link">
            Lihat File
        </a>
    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pendudukupload/show.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/pendudukupload/show.js') }}"></script>
@endpush
