@extends('layouts.app')

@section('title', Auth::check() ? 'Daftar Aduan Saya' : 'Aduan Masyarakat')

@section('content')
<link rel="stylesheet" href="{{ asset('css/warga/aduan/index.css') }}">

<div class="aduan-container">
    
    {{--JUDUL BEDA: Login = "Aduan Saya", Publik = "Aduan Masyarakat" --}}
    <div class="aduan-header">
        <h2 class="aduan-title">
            {{ Auth::check() ? 'Aduan Saya' : 'Aduan Masyarakat' }}
        </h2>
        
        {{--TOMBOL BUAT ADUAN CUMA KALAU LOGIN --}}
        @auth
            <a href="{{ route('warga.aduan.create') }}" class="btn-add">
                + Buat Aduan
            </a>
        @endauth
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="aduan-list">
        @forelse($aduans as $aduan)
            <div class="aduan-card {{ strtolower($aduan->prioritas) }}">
                
                {{--BADGE PUBLIK KALAU BUKAN MILIK USER LOGIN --}}
                @auth
                    @if($aduan->user_id !== Auth::id())
                        <span class="badge-publik">Publik</span>
                    @endif
                @endauth

                {{-- Judul --}}
                <p class="aduan-judul">
                    <strong>Judul:</strong> {{ $aduan->judul }}
                </p>

                {{-- Nama Pelapor (Publik) --}}
                @guest
                    <p class="aduan-pelapor">
                        <strong>Oleh:</strong> {{ $aduan->nama ?? 'Anonim' }}
                    </p>
                @endguest

                {{-- Prioritas & Status --}}
                <div class="meta">
                    <span class="meta-item">
                        <strong>Prioritas:</strong>
                        <span class="prioritas {{ strtolower($aduan->prioritas) }}">
                            {{ ucfirst($aduan->prioritas) }}
                        </span>
                    </span>
                    <span class="meta-divider">|</span>
                    <span class="meta-item">
                        <strong>Status:</strong>
                        <span class="status {{ strtolower($aduan->status) }}">
                            {{ ucfirst($aduan->status) }}
                        </span>
                    </span>
                </div>

                {{-- Detail --}}
                <p class="aduan-detail">
                    <strong>Detail:</strong> 
                    {{ \Illuminate\Support\Str::limit($aduan->detail, 150) }}
                </p>

                {{-- Lokasi --}}
                <p class="aduan-lokasi">
                    {{ $aduan->alamat }}
                </p>

                {{-- Gambar (jika ada) --}}
                @if($aduan->gambar)
                    <div class="aduan-image">
                        <img src="{{ asset('storage/' . $aduan->gambar) }}"
                             alt="Gambar Aduan"
                             class="img-preview"
                             loading="lazy">
                    </div>
                @endif

                {{-- TANGGAL --}}
                <p class="aduan-tanggal">
                    {{ $aduan->created_at->diffForHumans() }}
                </p>
            </div>
        @empty
            <div class="empty-state">
                <p class="empty-text">
                    {{ Auth::check() ? 'Belum ada aduan yang dibuat.' : 'Belum ada aduan dari masyarakat.' }}
                </p>
            </div>
        @endforelse
    </div>
</div>

<script src="{{ asset('js/warga/aduan/index.js') }}"></script>
@endsection