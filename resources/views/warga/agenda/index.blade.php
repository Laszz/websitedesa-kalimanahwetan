@extends('layouts.app')

@section('title', 'Agenda Kegiatan Desa - Desa Kalimanah Wetan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/warga/agenda/index.css') }}">
@endpush

@section('content')

<div class="container agenda-container">
    
    {{-- Header --}}
    <div class="agenda-header">
        <h1><i class="fa-solid fa-calendar-days"></i> Agenda Kegiatan Desa</h1>
        <p>Jadwal kegiatan dan acara di Desa Kalimanah Wetan</p>
    </div>

    {{-- Kalender Google (Visual) --}}
    <div class="calendar-wrapper">
        <iframe
            src="https://calendar.google.com/calendar/embed?src={{ urlencode(env('GOOGLE_CALENDAR_ID', 'admindesakalimanahwetan@gmail.com')) }}&ctz=Asia%2FJakarta&hl=id&showTz=1&showCalendars=0&mode=MONTH"
            style="border:0" 
            width="100%" 
            height="600" 
            frameborder="0" 
            scrolling="no">
        </iframe>
    </div>

    {{-- Daftar Agenda dari Database --}}
    <div class="agenda-list-section">
        <h2><i class="fa-solid fa-list-ul"></i> Daftar Kegiatan Mendatang</h2>
        
        <div class="agenda-list">
            @forelse($daftarAgenda as $agenda)
                <div class="agenda-item">
                    <div class="agenda-date">
                        <span class="date-month">{{ $agenda->mulai->timezone('Asia/Jakarta')->format('M') }}</span>
                        <span class="date-day">{{ $agenda->mulai->timezone('Asia/Jakarta')->format('d') }}</span>
                        <span class="date-year">{{ $agenda->mulai->timezone('Asia/Jakarta')->format('Y') }}</span>
                    </div>
                    <div class="agenda-content">
                        <div class="agenda-meta">
                            <h3>{{ $agenda->judul }}</h3>
                            @if($agenda->seharian)
                                <span class="badge badge-seharian"><i class="fa-solid fa-sun"></i> Seharian</span>
                            @endif
                        </div>
                        <div class="agenda-details">
                            <span class="detail-item">
                                <i class="fa-solid fa-clock"></i>
                                @if($agenda->seharian)
                                    Seharian penuh
                                @else
                                    {{ $agenda->mulai->timezone('Asia/Jakarta')->format('H:i') }}
                                    @if($agenda->selesai)
                                        - {{ $agenda->selesai->timezone('Asia/Jakarta')->format('H:i') }}
                                    @endif
                                @endif
                            </span>
                            @if($agenda->lokasi)
                                <span class="detail-item">
                                    <i class="fa-solid fa-location-dot"></i> {{ $agenda->lokasi }}
                                </span>
                            @endif
                        </div>
                        @if($agenda->deskripsi)
                            <p class="agenda-desc">{{ $agenda->deskripsi }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fa-solid fa-calendar-xmark"></i>
                    <p>Belum ada agenda terbaru</p>
                    <span>Agenda akan muncul setelah ditambahkan oleh admin desa</span>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/agenda/index.js') }}"></script>
@endpush