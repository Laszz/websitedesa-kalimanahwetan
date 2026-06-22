@extends('layouts.app')

@section('title', 'Sejarah Desa Kalimanah Wetan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/sejarahdesa/index.css') }}">
@endpush

@section('content')
<div class="sejarah-page w-full">

    {{-- Hero Section --}}
    <section class="hero-gradient flex items-center justify-center h-64 md:h-80 text-center px-6 relative">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-5xl font-bold text-white fade-text">Desa Kalimanah Wetan</h1>
            <p class="mt-2 text-lg md:text-xl text-white/90 fade-text">Maju dan Sejahtera</p>
        </div>
    </section>

    {{-- Data Singkat Desa --}}
    <section class="data-desa-section py-12 md:py-16">
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 text-center px-6">

            {{-- Card 1 --}}
            <div class="card-sejarah fade-text" data-delay="0">
                <span class="icon"><i class="fas fa-map"></i></span>
                <h3>Luas Wilayah</h3>
                <p>± 325 Ha</p>
            </div>

            {{-- Card 2 --}}
            <div class="card-sejarah fade-text" data-delay="150">
                <span class="icon"><i class="fas fa-users"></i></span>
                <h3>Data Penduduk</h3>
                <p>± 8.520 Jiwa</p>
            </div>

            {{-- Card 3 --}}
            <div class="card-sejarah fade-text" data-delay="300">
                <span class="icon"><i class="fas fa-city"></i></span>
                <h3>Jumlah RT dan RW</h3>
                <p>12 RT & 5 RW</p>
            </div>
        </div>
    </section>

    {{-- Sejarah Desa --}}
    <section class="sejarah-section py-12 md:py-16">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="fade-text mb-8"><i class="fas fa-book-open"></i> Sejarah Desa Kalimanah Wetan</h2>
            
            <div class="sejarah-content fade-text">
                <p>
                    <i class="fas fa-quote-left"></i> Desa Kalimanah Wetan mendapat namanya berdasarkan legenda abad ke-1700-an,
                    yakni Kadipaten Wilahan yang dipimpin oleh Ki Wilah, mantan panglima Kerajaan Mataram yang terkenal bijaksana.
                    Suatu hari kadipaten diserang perampok. Setelah dikalahkan, jasad mereka dibuang ke sungai.
                    Mayat-mayat itu membusuk dan mengeluarkan nanah, dalam bahasa Jawa disebut <em>"manah"</em>,
                    sehingga sungai itu dikenal sebagai <strong>Kali Manah</strong>, yang kemudian berkembang menjadi Kalimanah.
                    Karena desa ini berada di sebelah timur sungai, maka diberi nama lengkap <strong>Kalimanah Wetan</strong> 
                    (<em>"Wetan"</em> artinya timur). <i class="fas fa-quote-right"></i>
                </p>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/sejarahdesa/index.js') }}"></script>
@endpush