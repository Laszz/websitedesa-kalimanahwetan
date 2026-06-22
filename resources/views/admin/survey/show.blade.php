@extends('layouts.admin')

@section('title', 'Detail Survey - ' . $survey->user->name)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/survey/show.css') }}">
@endpush

@section('content')
<div class="survey-page survey-show">

    {{-- Header --}}
    <div class="survey-header">
        <div class="header-content">
            <h1 class="survey-title">
                <span class="survey-icon"><i class="fa-solid fa-circle-info"></i></span>
                Detail Survey
            </h1>
            <p class="survey-subtitle">Hasil survei kepuasan warga</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="survey-alert survey-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="survey-alert survey-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Detail Card --}}
    <div class="survey-card detail-card">

        {{-- User Profile --}}
        <div class="user-profile">
            <div class="user-avatar-large">
                <span>{{ strtoupper(substr($survey->user->name, 0, 1)) }}</span>
            </div>
            <div class="user-info-detail">
                <h2>{{ $survey->user->name }}</h2>
                <p><i class="fa-regular fa-clock"></i> {{ $survey->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>

        {{-- Ratings --}}
        <div class="ratings-detail">
            <div class="rating-row" data-rating="{{ $survey->q1_speed }}">
                <span class="rating-label">
                    <i class="fa-solid fa-bolt"></i> Kecepatan Pelayanan
                </span>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $survey->q1_speed ? 'filled' : '' }}">
                            <i class="fa-solid fa-star"></i>
                        </span>
                    @endfor
                    <span class="rating-value">{{ $survey->q1_speed }}/5</span>
                </div>
            </div>

            <div class="rating-row" data-rating="{{ $survey->q2_friendly }}">
                <span class="rating-label">
                    <i class="fa-solid fa-face-smile"></i> Keramahan Petugas
                </span>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $survey->q2_friendly ? 'filled' : '' }}">
                            <i class="fa-solid fa-star"></i>
                        </span>
                    @endfor
                    <span class="rating-value">{{ $survey->q2_friendly }}/5</span>
                </div>
            </div>

            <div class="rating-row" data-rating="{{ $survey->q3_clarity }}">
                <span class="rating-label">
                    <i class="fa-solid fa-list-check"></i> Kejelasan Informasi
                </span>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $survey->q3_clarity ? 'filled' : '' }}">
                            <i class="fa-solid fa-star"></i>
                        </span>
                    @endfor
                    <span class="rating-value">{{ $survey->q3_clarity }}/5</span>
                </div>
            </div>

            <div class="rating-row" data-rating="{{ $survey->q4_ease }}">
                <span class="rating-label">
                    <i class="fa-solid fa-file-pen"></i> Kemudahan Administrasi
                </span>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $survey->q4_ease ? 'filled' : '' }}">
                            <i class="fa-solid fa-star"></i>
                        </span>
                    @endfor
                    <span class="rating-value">{{ $survey->q4_ease }}/5</span>
                </div>
            </div>

            <div class="rating-row" data-rating="{{ $survey->q5_overall }}">
                <span class="rating-label">
                    <i class="fa-solid fa-bullseye"></i> Kualitas Keseluruhan
                </span>
                <div class="rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="star {{ $i <= $survey->q5_overall ? 'filled' : '' }}">
                            <i class="fa-solid fa-star"></i>
                        </span>
                    @endfor
                    <span class="rating-value">{{ $survey->q5_overall }}/5</span>
                </div>
            </div>

            <div class="rating-row rating-total" data-rating="{{ $survey->average_rating }}">
                <span class="rating-label">
                    <i class="fa-solid fa-chart-pie"></i> Rata-rata Total
                </span>
                <div class="rating-stars">
                    <span class="rating-value highlight">{{ $survey->average_rating }}/5</span>
                </div>
            </div>
        </div>

        {{-- Saran & Masukan --}}
        @if($survey->improvement || $survey->suggestion)
        <div class="saran-detail">
            <h3>
                <i class="fa-solid fa-comments"></i> Saran & Masukan
            </h3>

            @if($survey->improvement)
            <div class="saran-box">
                <span class="saran-title">
                    <i class="fa-solid fa-triangle-exclamation"></i> Yang Perlu Diperbaiki
                </span>
                <p>{{ $survey->improvement }}</p>
            </div>
            @endif

            @if($survey->suggestion)
            <div class="saran-box">
                <span class="saran-title">
                    <i class="fa-solid fa-lightbulb"></i> Saran untuk Pelayanan
                </span>
                <p>{{ $survey->suggestion }}</p>
            </div>
            @endif
        </div>
        @endif

        {{-- Footer --}}
        <div class="detail-footer">
            <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/survey/show.js') }}"></script>
@endpush