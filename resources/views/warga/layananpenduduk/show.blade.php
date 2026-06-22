@extends('layouts.app')

@section('title', 'Detail Layanan')

@section('content')
<div class="detail-container">
    <div class="detail-box">
        <div class="detail-header">
            <div class="detail-icon">
                @switch($layanan->kategori)
                    @case('layanan_administrasi_penduduk')
                        @break
                    @case('layanan_administrasi_umum')
                        @break
                    @case('layanan_hukum_tanah')
                        @break
                    @default
                @endswitch
            </div>
            
            <span class="detail-kategori">
                {{ str_replace('_', ' ', $layanan->kategori) }}
            </span>
            
            <h1 class="detail-title">{{ $layanan->nama_layanan }}</h1>
        </div>

        <div class="detail-section">
            <h3>Deskripsi Layanan</h3>
            <div class="detail-deskripsi">
                <p>{{ $layanan->deskripsi }}</p>
            </div>
        </div>

        <div class="detail-section">
            <h3>Persyaratan</h3>
            
            @if(count($requirements) > 0)
            <div class="timeline">
                @foreach ($requirements as $index => $req)
                <div class="timeline-item">
                    <div class="timeline-number">{{ $index + 1 }}</div>
                    <div class="timeline-content">
                        <span class="req-text">{{ $req->nama_syarat }}</span>
                        <span class="req-type {{ $req->tipe }}">{{ strtoupper($req->tipe) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-req">
                <p>Tidak ada persyaratan khusus untuk layanan ini.</p>
            </div>
            @endif
        </div>

        <div class="detail-action">
            <a href="{{ route('warga.pendudukrequest.create', $layanan->id) }}" class="btn-ajukan">
                <span>Ajukan Permohonan</span>
            </a>
        </div>

        {{-- Tombol Kembali --}}
        <div class="detail-footer">
            <a href="{{ route('warga.layananpenduduk.index') }}" class="btn-back">
                <span>Kembali ke Daftar Layanan</span>
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/layananpenduduk/show.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/warga/layananpenduduk/show.js') }}"></script>
@endpush