@extends('layouts.admin')

@section('title', 'Detail Aduan')

@section('content')
<div class="aduan-detail-container">
    <div class="detail-card">
        <h2>Detail Aduan</h2>

        <div class="detail-item">
            <strong>Judul</strong>
            <span>{{ $aduan->judul }}</span>
        </div>

        <div class="detail-item">
            <strong>Nama</strong>
            <span>{{ $aduan->nama ?? $aduan->user->nama ?? '-' }}</span>
        </div>

        <div class="detail-item">
            <strong>Nomor WA</strong>
            <span>{{ $aduan->nomor_wa }}</span>
        </div>

        <div class="detail-item">
            <strong>Alamat</strong>
            <span>{{ $aduan->alamat }}</span>
        </div>

        <div class="detail-item">
            <strong>Kategori</strong>
            <span>{{ $aduan->kategori ?? '-' }}</span>
        </div>

        <div class="detail-item">
            <strong>Prioritas</strong>
            <span>{{ ucfirst($aduan->prioritas) }}</span>
        </div>

        <div class="detail-item">
            <strong>Status</strong>
            <span>{{ ucfirst($aduan->status) }}</span>
        </div>

        <div class="detail-item">
            <strong>Detail</strong>
            <span>{{ $aduan->detail }}</span>
        </div>

        @if($aduan->gambar)
            <div class="detail-item">
                <strong>Gambar</strong>
                <img src="{{ asset('storage/'.$aduan->gambar) }}" class="detail-img" alt="Gambar Aduan">
            </div>
        @endif

        <a href="{{ route('admin.aduan.index') }}" class="btn-kembali">
            ← Kembali
        </a>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/aduan/show.css') }}">
@endpush