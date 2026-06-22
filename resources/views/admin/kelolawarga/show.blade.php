@extends('layouts.admin')

@section('title', 'Detail Warga - ' . $warga->name)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/kelolawarga/show.css') }}">
@endpush

@section('content')
<div class="warga-page warga-show">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="warga-alert warga-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="warga-alert warga-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Profile Header --}}
    <div class="profile-header warga-card">
        <div class="profile-avatar">
            @if($warga->foto)
                <img src="{{ asset('storage/' . $warga->foto) }}" alt="{{ $warga->name }}">
            @else
                <span>{{ strtoupper(substr($warga->name, 0, 1)) }}</span>
            @endif
        </div>
        <div class="profile-info">
            <h1 class="profile-name">{{ $warga->name }}</h1>
            <div class="profile-meta">
                <span class="meta-badge">
                    <i class="fa-solid fa-id-card"></i>
                    NIK: {{ $warga->nik }}
                </span>
                <span class="meta-badge">
                    <i class="fa-solid fa-house-chimney-user"></i>
                    KK: {{ $warga->kk }}
                </span>
                <span class="status-badge {{ strtolower(str_replace(' ', '-', $warga->status)) }}">
                    <span class="status-dot"></span>
                    {{ $warga->status }}
                </span>
            </div>
        </div>
        <div class="profile-actions">
            <a href="{{ route('admin.kelolawarga.edit', $warga->id) }}" class="btn btn-edit-profile">
                <i class="fa-solid fa-pen"></i>
                Edit
            </a>
            <form action="{{ route('admin.kelolawarga.destroy', $warga->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Yakin ingin menghapus data {{ $warga->name }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-delete-profile">
                    <i class="fa-solid fa-trash"></i>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="info-grid">
        {{-- Data Pribadi --}}
        <div class="info-section warga-card">
            <h3 class="section-title">
                <span class="section-icon"><i class="fa-solid fa-user"></i></span>
                Data Pribadi
            </h3>
            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">User ID</span>
                    <span class="info-value">{{ $warga->user_id }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $warga->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Kelamin</span>
                    <span class="info-value">{{ $warga->jenis_kelamin }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tempat Lahir</span>
                    <span class="info-value">{{ $warga->tempat_lahir }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Lahir</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Umur</span>
                    <span class="info-value"><span class="umur-badge">{{ $warga->umur }} tahun</span></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Agama</span>
                    <span class="info-value">{{ $warga->agama }}</span>
                </div>
            </div>
        </div>

        {{-- Data Domisili --}}
        <div class="info-section warga-card">
            <h3 class="section-title">
                <span class="section-icon"><i class="fa-solid fa-map-location-dot"></i></span>
                Data Domisili
            </h3>
            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-value alamat-value">{{ $warga->alamat }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">RW / RT</span>
                    <span class="info-value"><span class="rwrt-badge">RW {{ $warga->rw }} / RT {{ $warga->rt }}</span></span>
                </div>
            </div>
        </div>

        {{-- Data Sosial --}}
        <div class="info-section warga-card">
            <h3 class="section-title">
                <span class="section-icon"><i class="fa-solid fa-heart"></i></span>
                Data Sosial
            </h3>
            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">Status Perkawinan</span>
                    <span class="info-value">
                        <span class="status-badge {{ strtolower(str_replace(' ', '-', $warga->status)) }}">
                            <span class="status-dot"></span>
                            {{ $warga->status }}
                        </span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pekerjaan</span>
                    <span class="info-value">{{ $warga->pekerjaan ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pendidikan Akhir</span>
                    <span class="info-value">{{ $warga->pendidikan_akhir ?? '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Back Button --}}
    <div class="back-wrapper">
        <a href="{{ route('admin.kelolawarga.index') }}" class="btn-back"> Kembali Ke Beranda</a>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/kelolawarga/show.js') }}"></script>
@endpush