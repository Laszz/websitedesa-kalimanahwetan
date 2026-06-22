@extends('layouts.app')

@section('title', 'Berita Warga')

@section('content')
<div class="berita-container">

    <div class="berita-header">
        <h1 class="judul-halaman">Berita Warga</h1>
        <p class="sub-judul">Informasi terkini seputar Desa Kalimanah Wetan</p>
    </div>

    {{-- Search --}}
    <div class="search-box">
        <div class="search-icon">🔍</div>
        <input type="text" id="searchInput" placeholder="Cari berita..." autocomplete="off">
    </div>

    {{-- Hasil pencarian --}}
    <div id="searchResults" class="search-results"></div>

    {{-- Default News --}}
    <div id="defaultNews">
        @if($beritas->count() > 0)

            {{-- Headline --}}
            @php $headline = $beritas->first(); @endphp
            <div class="headline">
                <div class="headline-image">
                    <img src="{{ asset('storage/'.$headline->gambar) }}" alt="{{ $headline->judul }}" loading="lazy">
                    <div class="headline-badge">Berita Terbaru</div>
                </div>
                <div class="headline-info">
                    <span class="headline-tanggal">
                        {{ \Carbon\Carbon::parse($headline->tanggal)->translatedFormat('d F Y') }}
                    </span>
                    <h2>{{ $headline->judul }}</h2>
                    <p class="ringkasan">{{ $headline->ringkasan }}</p>
                    <a href="{{ route('berita.show', $headline->slug) }}" class="btn-selengkapnya">
                        Baca Selengkapnya
                    </a>
                </div>
            </div>

            {{-- Grid --}}
            <div class="grid-berita">
                @foreach($beritas->skip(1) as $berita)
                <div class="card-berita">
                    <div class="card-image">
                        <img src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}" loading="lazy">
                        <div class="card-overlay"></div>
                    </div>
                    <div class="card-body">
                        <span class="card-tanggal">
                            {{ \Carbon\Carbon::parse($berita->tanggal)->translatedFormat('d M Y') }}
                        </span>
                        <h3>{{ $berita->judul }}</h3>
                        <p class="ringkasan">{{ Str::limit($berita->ringkasan, 120) }}</p>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="btn-selengkapnya">
                            Baca Selengkapnya
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

        @else
            <div class="kosong">
                <span>Belum ada berita.</span>
            </div>
        @endif

        {{-- Pagination --}}
        <div class="pagination">
            {{ $beritas->links() }}
        </div>
    </div>

</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/warga/berita/index.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/warga/berita/index.js') }}"></script>
@endpush