@extends('layouts.app')

@section('title', 'Dashboard Warga - Desa Kalimanah Wetan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endpush

@section('content')

{{-- Hero Section --}}
<section class="relative welcome-hero">
    <img src="{{ asset('images/sawah.jpg') }}" alt="Desa Kalimanah Wetan" class="w-full h-[500px] object-cover absolute inset-0 z-0">
    <div class="absolute inset-0 bg-black/50 z-10 flex flex-col items-center justify-center text-center text-white px-4">
        <h1>Selamat Datang di Desa Kalimanah Wetan</h1>
        <p>Website resmi desa untuk informasi pelayanan, berita, dan kegiatan masyarakat.</p>
    </div>
</section>

{{-- BANTUAN SAYA CARD — BARU --}}
@if($bantuanStats['total'] > 0)
<section class="py-8 bg-gradient-to-r from-blue-50 to-indigo-50">
    <div class="container mx-auto px-4">
        <div class="bantuan-card">
            <div class="bantuan-card-header">
                <div class="bantuan-card-title">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span>Bantuan Saya</span>
                </div>
                <a href="{{ route('warga.penerimabantuan.index') }}" class="bantuan-card-link">
                    Lihat Semua
                </a>
            </div>
            <div class="bantuan-card-body">
                <div class="bantuan-stats">
                    <div class="bantuan-stat">
                        <span class="bantuan-stat-value">{{ $bantuanStats['total'] }}</span>
                        <span class="bantuan-stat-label">Total Bantuan</span>
                    </div>
                    <div class="bantuan-stat">
                        <span class="bantuan-stat-value text-green-600">{{ $bantuanStats['aktif'] }}</span>
                        <span class="bantuan-stat-label">Aktif</span>
                    </div>
                </div>
                
                @if($bantuanStats['terbaru'])
                <div class="bantuan-alert">
                    <div class="bantuan-alert-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="bantuan-alert-content">
                        <p class="bantuan-alert-title">Bantuan Terbaru</p>
                        <p class="bantuan-alert-text">
                            {{ $bantuanStats['terbaru']->jenisBantuan->nama_bantuan ?? 'Bantuan' }}
                            <span class="bantuan-alert-badge {{ $bantuanStats['terbaru']->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($bantuanStats['terbaru']->status) }}
                            </span>
                        </p>
                    </div>
                    <a href="{{ route('warga.penerimabantuan.show', $bantuanStats['terbaru']->id) }}" class="bantuan-alert-btn">
                        Detail
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

{{-- Berita Terbaru --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="section-header-flex">
            <h2 class="section-title" style="text-align: left;">📰 Berita Terbaru</h2>
            <a href="{{ route('berita.index') }}" class="btn-cta">Lihat Semua Berita</a>
        </div>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($beritas as $berita)
                <a href="{{ route('berita.show', $berita->slug) }}" class="card-custom block">
                    @if ($berita->gambar)
                        <img src="{{ asset('storage/' . $berita->gambar) }}"
                             alt="{{ $berita->judul }}"
                             class="w-full h-40 object-cover rounded-t-lg">
                    @else
                        <div class="bg-gray-200 h-40 rounded-t-lg flex items-center justify-center text-gray-500 text-sm">
                            Tidak ada gambar
                        </div>
                    @endif

                    <div class="p-5">
                        <h3 class="font-semibold text-lg text-gray-800 hover:text-blue-600 transition">
                            {{ $berita->judul }}
                        </h3>
                        <p class="text-sm mt-2 text-gray-600 line-clamp-3">
                            {{ $berita->deskripsi }}
                        </p>
                        <p class="text-xs mt-3 text-gray-500">🗓 {{ $berita->created_at->format('d M Y') }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-4 text-center text-gray-500">Belum ada berita terbaru.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Aduan Terbaru --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="section-header-flex">
            <h2 class="section-title" style="text-align: left;">Aduan Terbaru Masyarakat</h2>
            <a href="{{ route('warga.aduan.create') }}" class="btn-cta">+ Buat Aduan</a>
        </div>
        
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
            @forelse ($aduans as $aduan)
                <a href="{{ route('aduan.show', $aduan->id) }}" class="card-custom block">
                    @if ($aduan->gambar)
                        <img src="{{ asset('storage/' . $aduan->gambar) }}"
                             alt="{{ $aduan->judul ?? 'Aduan Masyarakat' }}"
                             class="w-full h-40 object-cover rounded-t-lg">
                    @else
                        <div class="bg-gray-200 h-40 rounded-t-lg flex items-center justify-center text-gray-500 text-sm">
                            Tidak ada gambar
                        </div>
                    @endif

                    <div class="p-5">
                        <h3 class="font-semibold text-lg text-gray-800 hover:text-blue-600 transition">
                            {{ $aduan->judul ?? 'Tanpa Judul' }}
                        </h3>
                        <p class="text-sm mt-2 text-gray-600 line-clamp-3">
                            {{ $aduan->detail ?? 'Tidak ada detail aduan.' }}
                        </p>
                        @if ($aduan->alamat)
                            <p class="text-xs mt-3 text-gray-500">{{ $aduan->alamat }}</p>
                        @endif
                    </div>
                </a>
            @empty
                <p class="col-span-4 text-center text-gray-500">Belum ada aduan terbaru.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- Youtube Desa --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="section-title">Youtube Desa Kalimanah Wetan</h2>
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-2 justify-center">
            <div class="video-frame w-full aspect-video rounded-lg shadow-lg overflow-hidden">
                <iframe src="https://www.youtube.com/embed/gCiNmg6UA5E" frameborder="0" allowfullscreen class="w-full h-full"></iframe>
            </div>
            <div class="video-frame w-full aspect-video rounded-lg shadow-lg overflow-hidden">
                <iframe src="https://www.youtube.com/embed/eOcMm89lgOI" frameborder="0" allowfullscreen class="w-full h-full"></iframe>
            </div>
            <div class="video-frame w-full aspect-video rounded-lg shadow-lg overflow-hidden">
                <iframe src="https://www.youtube.com/embed/dSXXm953jbU" frameborder="0" allowfullscreen class="w-full h-full"></iframe>
            </div>
            <div class="video-frame w-full aspect-video rounded-lg shadow-lg overflow-hidden">
                <iframe src="https://www.youtube.com/embed/pSLQGLw5Lv0" frameborder="0" allowfullscreen class="w-full h-full"></iframe>
            </div>
        </div>
        <p class="text-center mt-6">
            <a href="https://www.youtube.com/@pemdeskalwet" target="_blank" class="text-blue-600 font-semibold hover:underline">
                Lihat Channel Resmi Desa Kalimanah Wetan
            </a>
        </p>
    </div>
</section>

{{-- Jadwal Kegiatan --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="section-title">Jadwal Kegiatan Desa</h2>
        <div class="calendar-container">
            <iframe
                src="https://calendar.google.com/calendar/embed?src=desakalimanahwetan@gmail.com&ctz=Asia/Jakarta"
                style="border:0"
                width="100%"
                height="600"
                frameborder="0"
                scrolling="no">
            </iframe>
        </div>
    </div>
</section>

{{-- Peta --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 text-center">
        <h2 class="section-title">Temukan Kami</h2>
        <div id="map"></div>
    </div>
</section>

@endsection

@push('scripts')
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush