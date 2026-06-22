@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')
<div class="admin-dashboard">
    
    {{-- Header --}}
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Dashboard Admin</h1>
            <p class="dashboard-welcome">Selamat Datang Di Panel Admin Desa</p>
        </div>
        <div class="dashboard-date">
            {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- Stat Cards Row 1 --}}
    <div class="dashboard-cards">
        <div class="dashboard-card card-blue">
            <div class="card-icon"><i class="fa-solid fa-users"></i></div>
            <div class="card-info">
                <h3>Total Warga</h3>
                <p class="dashboard-value" data-counter>{{ $totalWarga }}</p>
            </div>
        </div>
        <div class="dashboard-card card-orange">
            <div class="card-icon"><i class="fa-solid fa-clock"></i></div>
            <div class="card-info">
                <h3>Layanan Diproses</h3>
                <p class="dashboard-value" data-counter>{{ $layananDiproses }}</p>
            </div>
        </div>
        <div class="dashboard-card card-green">
            <div class="card-icon"><i class="fa-solid fa-check-circle"></i></div>
            <div class="card-info">
                <h3>Layanan Selesai</h3>
                <p class="dashboard-value" data-counter>{{ $layananSelesai }}</p>
            </div>
        </div>
        <div class="dashboard-card card-purple">
            <div class="card-icon"><i class="fa-solid fa-newspaper"></i></div>
            <div class="card-info">
                <h3>Berita Aktif</h3>
                <p class="dashboard-value" data-counter>{{ $beritaAktif }}</p>
            </div>
        </div>
    </div>

    {{-- Stat Cards Row 2 --}}
    <div class="dashboard-cards">
        <div class="dashboard-card card-red">
            <div class="card-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
            <div class="card-info">
                <h3>Penerima Bantuan</h3>
                <p class="dashboard-value" data-counter>{{ $totalPenerimaBantuan }}</p>
            </div>
        </div>
        <div class="dashboard-card card-teal">
            <div class="card-icon"><i class="fa-solid fa-heart"></i></div>
            <div class="card-info">
                <h3>Bantuan Aktif</h3>
                <p class="dashboard-value" data-counter>{{ $bantuanAktif }}</p>
            </div>
        </div>
        <div class="dashboard-card card-indigo">
            <div class="card-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="card-info">
                <h3>Agenda Bulan Ini</h3>
                <p class="dashboard-value" data-counter>{{ $agendaBulanIni }}</p>
            </div>
        </div>
        <div class="dashboard-card card-yellow">
            <div class="card-icon"><i class="fa-solid fa-exclamation-triangle"></i></div>
            <div class="card-info">
                <h3>Aduan Pending</h3>
                <p class="dashboard-value" data-counter>{{ $aduanPending }}</p>
            </div>
        </div>
    </div>

    {{-- APBDes Progress Section --}}
    <div class="section-card">
        <div class="section-header">
            <h2><i class="fa-solid fa-chart-pie"></i> Realisasi APBDes {{ now()->year }}</h2>
            <span class="badge badge-blue">Tahun Anggaran: {{ now()->year }}</span>
        </div>
        
        <div class="apbdes-ringkasan">
            <div class="apbdes-item">
                <span class="apbdes-label">Total Anggaran</span>
                <span class="apbdes-value" data-counter>Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</span>
            </div>
            <div class="apbdes-item">
                <span class="apbdes-label">Total Realisasi</span>
                <span class="apbdes-value text-orange" data-counter>Rp {{ number_format($totalRealisasi, 0, ',', '.') }}</span>
            </div>
            <div class="apbdes-item">
                <span class="apbdes-label">Persentase</span>
                <span class="apbdes-value text-blue">{{ $persenRealisasi }}%</span>
            </div>
        </div>

        <div class="progress-bar-wrap">
            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: 0%" data-width="{{ $persenRealisasi }}"></div>
            </div>
            <span class="progress-text">{{ $persenRealisasi }}%</span>
        </div>
    </div>

    {{-- Grafik Section --}}
    <div class="dashboard-grid-2">
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fa-solid fa-chart-bar"></i> Realisasi per Triwulan</h2>
            </div>
            <div class="chart-container">
                <canvas id="chartApbdes"></canvas>
            </div>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h2><i class="fa-solid fa-chart-pie"></i> Penerima Bantuan per Desil</h2>
            </div>
            <div class="chart-container">
                <canvas id="chartDesil"></canvas>
            </div>
        </div>
    </div>

    {{-- Tables Section --}}
    <div class="dashboard-grid-2">
        {{-- Agenda Mendatang --}}
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fa-solid fa-calendar-days"></i> Agenda Mendatang</h2>
                <a href="{{ route('admin.agenda.index') }}" class="btn-link">Lihat Semua</a>
            </div>
            <div class="table-wrap">
                @if($agendaMendatang->count() > 0)
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($agendaMendatang as $agenda)
                        <tr>
                            <td>{{ $agenda->mulai->format('d M Y') }}</td>
                            <td>{{ Str::limit($agenda->judul, 30) }}</td>
                            <td>{{ $agenda->mulai->format('H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-small">Tidak ada agenda mendatang</div>
                @endif
            </div>
        </div>

        {{-- Aduan Pending --}}
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fa-solid fa-comments"></i> Aduan Belum Ditanggapi</h2>
                <a href="{{ route('admin.aduan.index') }}" class="btn-link">Lihat Semua</a>
            </div>
            <div class="table-wrap">
                @if($aduanTerbaru->count() > 0)
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($aduanTerbaru as $aduan)
                        <tr>
                            <td>{{ $aduan->created_at->format('d M Y') }}</td>
                            <td>{{ Str::limit($aduan->judul ?? 'Tanpa Judul', 30) }}</td>
                            <td><span class="badge badge-warning">Pending</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-small">Tidak ada aduan pending</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Penerima Bantuan Terbaru --}}
    <div class="section-card">
        <div class="section-header">
            <h2><i class="fa-solid fa-hand-holding-heart"></i> Penerima Bantuan Terbaru</h2>
            <a href="{{ route('admin.penerimabantuan.index') }}" class="btn-link">Lihat Semua</a>
        </div>
        <div class="table-wrap">
            @if($penerimaTerbaru->count() > 0)
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Warga</th>
                        <th>Jenis Bantuan</th>
                        <th>Desil</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penerimaTerbaru as $penerima)
                    <tr>
                        <td>{{ $penerima->warga->name ?? '-' }}</td>
                        <td>{{ $penerima->jenisBantuan->nama_bantuan ?? '-' }}</td>
                        <td>Desil {{ $penerima->desil }}</td>
                        <td>
                            <span class="badge badge-{{ $penerima->status === 'aktif' ? 'success' : ($penerima->status === 'dicabut' ? 'danger' : 'warning') }}">
                                {{ ucfirst($penerima->status) }}
                            </span>
                        </td>
                        <td>{{ $penerima->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-small">Belum ada data penerima bantuan</div>
            @endif
        </div>
    </div>

    {{-- Data Chart --}}
    <div id="dashboard-data"
        data-triwulan-labels="{{ json_encode($triwulanLabels) }}"
        data-triwulan-data="{{ json_encode($triwulanData) }}"
        data-desil-labels="{{ json_encode($desilLabels) }}"
        data-desil-data="{{ json_encode($desilData) }}"
        style="display:none;">
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush