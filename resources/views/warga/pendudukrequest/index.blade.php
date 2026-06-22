@extends('layouts.app')

@section('content')

<div class="request-container" id="requestApp">

    <div class="header-section">
        <h2 class="title">
            Riwayat Pengajuan Layanan
        </h2>
        <p class="subtitle">Kelola dan pantau status pengajuan layanan Anda</p>
    </div>

    {{-- NOTIF SUCCESS (FLASH) --}}
    @if(session('success'))
        <div class="toast-notif" id="toastNotif">
            <div class="toast-icon">✅</div>
            <div class="toast-content">
                <strong>Berhasil!</strong>
                <p>{{ session('success') }}</p>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif

    @if($requests->isEmpty())
        <div class="empty-state">
            <h3>Belum ada pengajuan</h3>
            <p>Anda belum mengajukan layanan apapun. Mulai ajukan layanan pertama Anda!</p>
            <a href="{{ route('warga.layananpenduduk.index') }}" class="btn-primary">
                <span>+</span> Ajukan Layanan
            </a>
        </div>
    @else

    {{-- FILTER & SEARCH --}}
    <div class="toolbar">
        <div class="search-box">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari layanan..." autocomplete="off">
        </div>
        
        <div class="filter-group">
            <button class="filter-btn active" data-filter="all">Semua</button>
            <button class="filter-btn" data-filter="pending">Pending</button>
            <button class="filter-btn" data-filter="review">Review</button>
            <button class="filter-btn" data-filter="approved">Disetujui</button>
            <button class="filter-btn" data-filter="selesai">Selesai</button>
            <button class="filter-btn" data-filter="rejected">Ditolak</button>
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-bar">
        <div class="stat-item">
            <span class="stat-number" id="totalCount">{{ $requests->count() }}</span>
            <span class="stat-label">Total</span>
        </div>
        <div class="stat-item">
            <span class="stat-number" id="pendingCount">{{ $requests->where('status', 'pending')->count() }}</span>
            <span class="stat-label">Pending</span>
        </div>
        <div class="stat-item">
            <span class="stat-number" id="processCount">{{ $requests->whereIn('status', ['review', 'approved'])->count() }}</span>
            <span class="stat-label">Diproses</span>
        </div>
        <div class="stat-item">
            <span class="stat-number" id="doneCount">{{ $requests->where('status', 'selesai')->count() }}</span>
            <span class="stat-label">Selesai</span>
        </div>
    </div>

    {{-- DESKTOP: TABLE VIEW --}}
    <div class="desktop-view card-glass">
        <table class="custom-table" id="dataTable">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Layanan</th>
                    <th width="120">Tanggal</th>
                    <th width="120">Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requests as $index => $req)
                <tr class="request-row" data-status="{{ $req->status }}" data-layanan="{{ strtolower($req->layanan->nama_layanan ?? '') }}">
                    <td>
                        <span class="row-number">{{ $index + 1 }}</span>
                    </td>
                    <td>
                        <div class="layanan-info">
                            <div class="layanan-icon">{{ substr($req->layanan->nama_layanan ?? 'L', 0, 1) }}</div>
                            <div class="layanan-detail">
                                <span class="layanan-name">{{ $req->layanan->nama_layanan ?? '-' }}</span>
                                <span class="layanan-id">#{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="date-info">
                            <span class="date-day">{{ $req->created_at->format('d') }}</span>
                            <span class="date-month">{{ $req->created_at->format('M Y') }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="status-wrap">
                            @if($req->status == 'pending')
                                <span class="badge badge-pending">
                                    <span class="badge-dot"></span> Pending
                                </span>
                            @elseif($req->status == 'review')
                                <span class="badge badge-review">
                                    <span class="badge-dot pulse"></span> Review
                                </span>
                            @elseif($req->status == 'approved')
                                <span class="badge badge-approved">
                                    <span class="badge-dot"></span> Disetujui
                                </span>
                            @elseif($req->status == 'selesai')
                                <span class="badge badge-selesai">
                                    <span class="badge-dot"></span> Selesai
                                </span>
                            @elseif($req->status == 'rejected')
                                <span class="badge badge-rejected">
                                    <span class="badge-dot"></span> Ditolak
                                </span>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('warga.pendudukrequest.show', $req->id) }}" class="btn-detail">
                            <span>Lihat</span>
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MOBILE: CARD VIEW --}}
    <div class="mobile-view" id="mobileCards">
        @foreach($requests as $index => $req)
        <div class="request-card" data-status="{{ $req->status }}" data-layanan="{{ strtolower($req->layanan->nama_layanan ?? '') }}">
            <div class="card-header">
                <div class="card-id">#{{ str_pad($req->id, 4, '0', STR_PAD_LEFT) }}</div>
                @if($req->status == 'pending')
                    <span class="badge badge-pending"><span class="badge-dot"></span> Pending</span>
                @elseif($req->status == 'review')
                    <span class="badge badge-review"><span class="badge-dot pulse"></span> Review</span>
                @elseif($req->status == 'approved')
                    <span class="badge badge-approved"><span class="badge-dot"></span> Disetujui</span>
                @elseif($req->status == 'selesai')
                    <span class="badge badge-selesai"><span class="badge-dot"></span> Selesai</span>
                @elseif($req->status == 'rejected')
                    <span class="badge badge-rejected"><span class="badge-dot"></span> Ditolak</span>
                @endif
            </div>
            <div class="card-body">
                <div class="card-layanan">
                    <div class="layanan-icon">{{ substr($req->layanan->nama_layanan ?? 'L', 0, 1) }}</div>
                    <span class="layanan-name">{{ $req->layanan->nama_layanan ?? '-' }}</span>
                </div>
                <div class="card-meta">
                    <div class="meta-item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $req->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('warga.pendudukrequest.show', $req->id) }}" class="btn-detail btn-full">
                    Lihat Detail
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- NO RESULTS --}}
    <div class="no-results" id="noResults" style="display: none;">
        <h3>Tidak ditemukan</h3>
        <p>Tidak ada pengajuan yang cocok dengan pencarian Anda</p>
    </div>

    @endif

</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/pendudukrequest/index.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/warga/pendudukrequest/index.js') }}"></script>
@endpush