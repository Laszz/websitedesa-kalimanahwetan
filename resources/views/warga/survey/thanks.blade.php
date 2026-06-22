@extends('layouts.app')

@section('title', 'Terima Kasih - Survey Kepuasan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/warga/survey/thanks.css') }}">
@endpush

@section('content')
<div class="survey-wrapper">
    <div class="thanks-card">
        @if($alreadyFilled ?? false)
            {{-- Sudah isi survey sebelumnya --}}
            <div class="thanks-icon">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
            <h1 class="thanks-title">Anda Sudah Mengisi Survey!</h1>
            <p class="thanks-message">Survey kepuasan hanya bisa diisi sekali per bulan.</p>
            <p class="thanks-submessage">Terima kasih atas partisipasi Anda.</p>
            
            <div class="info-badge">
                <i class="fa-regular fa-clock"></i>
                <span>Bisa isi lagi bulan depan</span>
            </div>
        @else
            {{-- Baru isi survey --}}
            <div class="thanks-icon icon-success">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <h1 class="thanks-title">Terima Kasih!</h1>
            <p class="thanks-message">Survey kepuasan Anda telah berhasil dikirim.</p>
            <p class="thanks-submessage">Masukan Anda sangat berarti untuk perbaikan pelayanan desa.</p>
            
            <div class="info-badge">
                <i class="fa-regular fa-calendar"></i>
                <span>Survey dapat diisi kembali setiap 1 bulan sekali</span>
            </div>
        @endif
        
        <a href="{{ route('warga.dashboard') }}" class="btn-back">
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/survey/thanks.js') }}"></script>
@endpush