@extends('layouts.app')

@section('title', 'Survey Kepuasan - Pelayanan Desa')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/warga/survey/create.css') }}">
@endpush

@section('content')
<div class="survey-container">
    <div class="survey-card">
        <div class="survey-header">
            <h1>Survey Kepuasan Pelayanan</h1>
            <p class="survey-subtitle">Bantu kami meningkatkan pelayanan dengan mengisi survey ini</p>
        </div>

        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <p class="user-name">{{ auth()->user()->name }}</p>
                <p class="user-label">Responden</p>
            </div>
        </div>

        <form action="{{ route('warga.survey.store') }}" method="POST" id="surveyForm">
            @csrf

            {{-- TOKEN ANTI DOUBLE SUBMIT --}}
            <input type="hidden" name="submission_token" value="{{ uniqid('srv_', true) }}">

            <div class="questions-list">
                {{-- Q1: Kecepatan --}}
                <div class="question-item" data-question="1">
                    <label class="question-label">1. Kecepatan Pelayanan</label>
                    <p class="question-desc">Seberapa cepat pelayanan yang Anda terima?</p>
                    <div class="star-rating" data-name="q1_speed">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn" data-value="{{ $i }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="q1_speed" id="q1_speed" required>
                    @error('q1_speed')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Q2: Keramahan --}}
                <div class="question-item" data-question="2">
                    <label class="question-label">2. Keramahan Petugas</label>
                    <p class="question-desc">Bagaimana sikap dan keramahan petugas?</p>
                    <div class="star-rating" data-name="q2_friendly">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn" data-value="{{ $i }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="q2_friendly" id="q2_friendly" required>
                    @error('q2_friendly')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Q3: Kejelasan --}}
                <div class="question-item" data-question="3">
                    <label class="question-label">3. Kejelasan Informasi</label>
                    <p class="question-desc">Seberapa jelas informasi/prosedur yang diberikan?</p>
                    <div class="star-rating" data-name="q3_clarity">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn" data-value="{{ $i }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="q3_clarity" id="q3_clarity" required>
                    @error('q3_clarity')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Q4: Kemudahan --}}
                <div class="question-item" data-question="4">
                    <label class="question-label">4. Kemudahan Administrasi</label>
                    <p class="question-desc">Seberapa mudah mengurus administrasi?</p>
                    <div class="star-rating" data-name="q4_ease">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn" data-value="{{ $i }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="q4_ease" id="q4_ease" required>
                    @error('q4_ease')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Q5: Keseluruhan --}}
                <div class="question-item" data-question="5">
                    <label class="question-label">5. Kualitas Keseluruhan</label>
                    <p class="question-desc">Seberapa puas Anda dengan pelayanan secara keseluruhan?</p>
                    <div class="star-rating" data-name="q5_overall">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" class="star-btn" data-value="{{ $i }}">★</button>
                        @endfor
                    </div>
                    <input type="hidden" name="q5_overall" id="q5_overall" required>
                    @error('q5_overall')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Saran --}}
            <div class="saran-section">
                <label class="question-label">Saran & Masukan</label>
                <p class="question-desc">Apa yang perlu kami perbaiki? (Opsional)</p>
                
                <div class="textarea-group">
                    <textarea name="improvement" id="improvement" rows="3" placeholder="Hal yang perlu diperbaiki...">{{ old('improvement') }}</textarea>
                </div>

                <div class="textarea-group">
                    <textarea name="suggestion" id="suggestion" rows="3" placeholder="Saran untuk pelayanan lebih baik...">{{ old('suggestion') }}</textarea>
                </div>
            </div>

            {{-- Submit --}}
            <div class="submit-section">
                <button type="submit" class="btn-submit" id="btnSubmit">
                    <span class="btn-text">Kirim Survey</span>
                </button>
                <p class="submit-hint">Survey hanya bisa diisi sekali per bulan</p>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/survey/create.js') }}"></script>
@endpush