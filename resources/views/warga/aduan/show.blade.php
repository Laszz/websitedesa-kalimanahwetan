@extends('layouts.app')

@section('title', $aduan->judul)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/aduan/show.css') }}">
@endpush

@section('content')
<div class="aduan-container">
    <div class="aduan-card">
        {{-- Judul --}}
        <h1 class="aduan-title">{{ $aduan->judul }}</h1>

        {{-- Detail Aduan --}}
        <div class="aduan-detail">
            <p>{{ $aduan->detail }}</p>
        </div>

        {{-- Info Tambahan --}}
        <div class="aduan-info">
            <p><strong>Kategori</strong> <span>{{ ucfirst($aduan->kategori) }}</span></p>
            <p>
                <strong>Prioritas</strong>
                <span class="prioritas {{ strtolower($aduan->prioritas) }}">
                    {{ ucfirst($aduan->prioritas) }}
                </span>
            </p>
        </div>

        {{-- Gambar Aduan --}}
        @if($aduan->gambar)
            <div class="aduan-image">
                <img src="{{ asset('storage/' . $aduan->gambar) }}" alt="Gambar Aduan">
            </div>
        @endif

        {{-- Status Aduan --}}
        <p class="aduan-status {{ strtolower($aduan->status) }}">
            {{ ucfirst($aduan->status) }}
        </p>

        {{-- Tombol Kembali di paling bawah --}}
        <div class="aduan-back">
            <a href="{{ url()->previous() }}" class="btn-back">Kembali</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/warga/aduan/show.js') }}"></script>
@endpush
