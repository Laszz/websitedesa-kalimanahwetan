@extends('layouts.app')

@section('title', 'Data Desa')

@section('content')
<div class="content-wrapper p-6">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Data Desa Kalimanah Wetan</h1>
        <p class="text-gray-500 text-sm mt-1">Ringkasan data penduduk dan informasi desa</p>
    </div>

    {{-- Dashboard Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Jumlah Penduduk --}}
        <div class="card-stat card-blue">
            <div>
                <p class="stat-title">Jumlah Penduduk</p>
                <p class="stat-value">{{ $jumlahPenduduk }}</p>
            </div>
            <i class="fas fa-users stat-icon"></i>
        </div>

        {{-- Laki-laki --}}
        <div class="card-stat card-indigo">
            <div>
                <p class="stat-title">Laki-laki</p>
                <p class="stat-value">{{ $jumlahLaki }}</p>
            </div>
            <i class="fas fa-male stat-icon"></i>
        </div>

        {{-- Perempuan --}}
        <div class="card-stat card-pink">
            <div>
                <p class="stat-title">Perempuan</p>
                <p class="stat-value">{{ $jumlahPerempuan }}</p>
            </div>
            <i class="fas fa-female stat-icon"></i>
        </div>

        {{-- Kartu Keluarga --}}
        <div class="card-stat card-green">
            <div>
                <p class="stat-title">Jumlah KK</p>
                <p class="stat-value">{{ $jumlahKK }}</p>
            </div>
            <i class="fas fa-home stat-icon"></i>
        </div>

    </div>

    {{-- RT/RW Summary --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <div class="mini-stat">
            <span class="mini-label">Total RT</span>
            <span class="mini-value">{{ $jumlahRT }}</span>
        </div>
        <div class="mini-stat">
            <span class="mini-label">Total RW</span>
            <span class="mini-value">{{ $jumlahRW }}</span>
        </div>
        <div class="mini-stat">
            <span class="mini-label">Rasio Gender</span>
            <span class="mini-value">{{ $jumlahLaki > 0 ? round($jumlahPerempuan / $jumlahLaki, 2) : 0 }}:1</span>
        </div>
        <div class="mini-stat">
            <span class="mini-label">KK Per RW/RT</span>
            <span class="mini-value">{{ $jumlahRW > 0 ? round($jumlahKK / $jumlahRW, 1) : 0 }}</span>
        </div>
    </div>

    {{-- Grafik --}}
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Statistik Penduduk</h2>
        <div class="chart-box">
            <canvas id="pendudukChart"></canvas>
        </div>
    </div>

    {{-- Tabel RT/RW --}}
    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Data per RT/RW</h2>
        <div class="table-wrapper">
            <table class="table-default">
                <thead>
                    <tr>
                        <th>RW</th>
                        <th>RT</th>
                        <th>Jumlah Penduduk</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rtRw as $item)
                        <tr>
                            <td>{{ $item->rw }}</td>
                            <td>{{ $item->rt }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-gray-400 py-4">Belum ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/datadesa/index.css') }}">
@endpush

@push('scripts')
<script>
    window.chartData = {
        laki: {{ $jumlahLaki }},
        perempuan: {{ $jumlahPerempuan }},
        kk: {{ $jumlahKK }},
        total: {{ $jumlahPenduduk }}
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/admin/datadesa/index.js') }}"></script>
@endpush