@extends('layouts.app')

@section('title', 'Visi dan Misi Desa Kalimanah Wetan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/visimisi/index.css') }}">
@endpush

@section('content')
<div class="visi-misi-page">

    <!-- Hero Section -->
    <div class="visi-misi-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="visi-misi-title">Visi dan Misi</h1>
            <p class="visi-misi-subtitle">Desa Kalimanah Wetan</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-16 space-y-16">

        {{-- Visi --}}
        <div class="visi-section fade-section">
            <div class="section-badge">
                <i class="fas fa-eye"></i>
                <span>Visi</span>
            </div>
            <div class="visi-card">
                <div class="visi-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <div class="visi-content">
                    <h2 class="visi-heading">Visi Desa Kalimanah Wetan</h2>
                    <p class="visi-text">
                        Terwujudnya Kalimanah Wetan yang <strong>Maju</strong>, <strong>Sehat</strong>, <strong>Mandiri</strong>, <strong>Berdaya Saing</strong> menuju masyarakat yang <strong>Sejahtera</strong> dan <strong>Berakhlak Mulia</strong>
                    </p>
                    <div class="visi-tags">
                        <span class="tag tag-maju"><i class="fas fa-arrow-trend-up"></i> Maju</span>
                        <span class="tag tag-sehat"><i class="fas fa-heart-pulse"></i> Sehat</span>
                        <span class="tag tag-mandiri"><i class="fas fa-hand-fist"></i> Mandiri</span>
                        <span class="tag tag-dayasaing"><i class="fas fa-trophy"></i> Berdaya Saing</span>
                        <span class="tag tag-sejahtera"><i class="fas fa-gem"></i> Sejahtera</span>
                        <span class="tag tag-akhlak"><i class="fas fa-praying-hands"></i> Berakhlak Mulia</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="section-divider fade-section">
            <div class="divider-line"></div>
            <i class="fas fa-star divider-icon"></i>
            <div class="divider-line"></div>
        </div>

        {{-- Misi --}}
        <div class="misi-section fade-section">
            <div class="section-badge">
                <i class="fas fa-rocket"></i>
                <span>Misi</span>
            </div>
            <div class="misi-card">
                <div class="misi-icon">
                    <i class="fas fa-list-check"></i>
                </div>
                <div class="misi-content">
                    <h2 class="misi-heading">Misi Kami</h2>
                    <div class="misi-list">
                        @php
                            $misiItems = [
                                ['icon' => 'fa-chart-line', 'color' => 'blue', 'title' => 'Maju', 'desc' => 'Berwawasan, produktif, kreatif dan inovatif.'],
                                ['icon' => 'fa-hand-holding-heart', 'color' => 'green', 'title' => 'Mandiri', 'desc' => 'Usaha aktif untuk memenuhi kebutuhan tanpa ketergantungan pihak lain.'],
                                ['icon' => 'fa-trophy', 'color' => 'yellow', 'title' => 'Berdaya Saing', 'desc' => 'Mampu berkompetisi dalam segala bidang serta mempunyai sumber daya manusia yang berkualitas.'],
                                ['icon' => 'fa-shield-heart', 'color' => 'purple', 'title' => 'Sejahtera', 'desc' => 'Terpenuhinya kebutuhan materi dan spiritual, masyarakat yang merasa aman, nyaman, asri dan lestari.'],
                                ['icon' => 'fa-praying-hands', 'color' => 'red', 'title' => 'Berakhlak Mulia', 'desc' => 'Berperilaku baik atau tidak melakukan perbuatan yang merugikan kepentingan umum.'],
                            ];
                        @endphp

                        @foreach($misiItems as $index => $item)
                            <div class="misi-item" style="--delay: {{ $index * 0.1 }}s">
                                <div class="misi-number">{{ $index + 1 }}</div>
                                <div class="misi-icon-small bg-{{ $item['color'] }}">
                                    <i class="fas {{ $item['icon'] }}"></i>
                                </div>
                                <div class="misi-text-content">
                                    <h3 class="misi-item-title">{{ $item['title'] }}</h3>
                                    <p class="misi-item-desc">{{ $item['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- CTA Section --}}
        <div class="cta-section fade-section">
            <div class="cta-card">
                <h3 class="cta-title"><i class="fas fa-hands-holding-circle"></i> Mari Bersama Membangun Desa</h3>
                <p class="cta-text">Bergabunglah dengan kami untuk mewujudkan visi dan misi Desa Kalimanah Wetan</p>
                <a href="{{ route('warga.survey.create') }}" class="cta-button">
                    <i class="fas fa-paper-plane"></i>
                    Ikut Survei Kepuasan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/visimisi/index.js') }}"></script>
@endpush