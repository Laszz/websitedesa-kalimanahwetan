@extends('layouts.admin')

@section('title', 'Hasil Survey Kepuasan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/survey/index.css') }}">
@endpush

@section('content')
<div class="survey-page survey-index">

    {{-- Header --}}
    <div class="survey-header">
        <div class="header-content">
            <h1 class="survey-title">
                <span class="survey-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                Hasil Survey Kepuasan
            </h1>
            <p class="survey-subtitle">Data survei dan tingkat kepuasan warga</p>
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

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <span class="stat-card-icon"><i class="fa-solid fa-users"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $stats['total'] }}</span>
                <span class="stat-card-label">Total Responden</span>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-bolt"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $stats['avg_speed'] }}</span>
                <span class="stat-card-label">Kecepatan Pelayanan</span>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-face-smile"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $stats['avg_friendly'] }}</span>
                <span class="stat-card-label">Keramahan Petugas</span>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-list-check"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $stats['avg_clarity'] }}</span>
                <span class="stat-card-label">Kejelasan Informasi</span>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-file-pen"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $stats['avg_ease'] }}</span>
                <span class="stat-card-label">Kemudahan Administrasi</span>
            </div>
        </div>

        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-bullseye"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $stats['avg_overall'] }}</span>
                <span class="stat-card-label">Keseluruhan Keseluruhan</span>
            </div>
        </div>

        <div class="stat-card stat-highlight">
            <span class="stat-card-icon"><i class="fa-solid fa-star"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $stats['overall'] }}</span>
                <span class="stat-card-label">Rata-rata Total</span>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="survey-card table-card">
        <div class="table-header">
            <h2>
                <i class="fa-solid fa-table-list"></i> Daftar Responden
            </h2>
        </div>

        <div class="table-wrapper">
            <table class="survey-table" id="surveyTable">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th width="90">Kecepatan</th>
                        <th width="90">Keramahan</th>
                        <th width="90">Kejelasan</th>
                        <th width="90">Kemudahan</th>
                        <th width="90">Keseluruhan</th>
                        <th width="90">Rata-rata</th>
                        <th width="100">Tanggal</th>
                        <th width="80" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surveys as $index => $survey)
                    <tr class="survey-row">
                        <td>
                            <span class="row-number">{{ $surveys->firstItem() + $index }}</span>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <span>{{ strtoupper(substr($survey->user->name ?? '-', 0, 1)) }}</span>
                                </div>
                                <span class="user-name">{{ $survey->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="rating-badge">{{ $survey->q1_speed }}</span>
                        </td>
                        <td>
                            <span class="rating-badge">{{ $survey->q2_friendly }}</span>
                        </td>
                        <td>
                            <span class="rating-badge">{{ $survey->q3_clarity }}</span>
                        </td>
                        <td>
                            <span class="rating-badge">{{ $survey->q4_ease }}</span>
                        </td>
                        <td>
                            <span class="rating-badge">{{ $survey->q5_overall }}</span>
                        </td>
                        <td>
                            <span class="rating-badge rating-avg">{{ $survey->average_rating }}</span>
                        </td>
                        <td>
                            <span class="tanggal-text">{{ $survey->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.surveys.show', $survey) }}"
                                   class="btn-action btn-view" title="Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="empty-cell">
                            <div class="empty-state">
                                <span class="empty-icon"><i class="fa-solid fa-clipboard-question"></i></span>
                                <p>Belum ada data survey</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="table-footer">
            <span class="table-info">Menampilkan {{ $surveys->count() }} data survey</span>
            {{ $surveys->links() }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/survey/index.js') }}"></script>
@endpush