@extends('layouts.app')

@section('title', 'Perangkat Desa')

@section('content')
<div class="perangkatdesa-container">
    <h2 class="title">Perangkat Desa</h2>

    <div class="perangkatdesa-grid">
        {{-- Kepala Desa --}}
        @if ($kepalaDesa)
            <div class="perangkat-card kepala">
                @if ($kepalaDesa->foto_url)
                    <img src="{{ $kepalaDesa->foto_url }}" alt="{{ $kepalaDesa->nama }}" class="foto">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default" class="foto">
                @endif
                <div class="info"> 
                <h3 class="nama">{{ $kepalaDesa->nama }}</h3>
                <p class="jabatan">{{ $kepalaDesa->jabatan }}</p>
                </div>
            </div>
        @endif

        {{-- Perangkat Desa Lainnya --}}
        @forelse ($perangkatLain as $perangkat)
            <div class="perangkat-card">
                @if ($perangkat->foto_url)
                    <img src="{{ $perangkat->foto_url }}" alt="{{ $perangkat->nama }}" class="foto">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="Default" class="foto">
                @endif
                <div class="info">
                <h3 class="nama">{{ $perangkat->nama }}</h3>
                <p class="jabatan">{{ $perangkat->jabatan }}</p>
                </div>
            </div>
        @empty
            <p class="empty">Belum ada data perangkat desa lainnya.</p>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/perangkatdesa/index.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/warga/perangkatdesa/index.js') }}"></script>
@endpush
