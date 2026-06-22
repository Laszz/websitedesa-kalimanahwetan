@extends('layouts.admin')

@section('title', 'Kelola Warga')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/kelolawarga/index.css') }}">
@endpush

@section('content')
<div class="warga-page warga-index">

    <div class="warga-header">
        <div class="header-content">
            <h1 class="warga-title">
                <span class="warga-icon"><i class="fa-solid fa-users"></i></span>
                Kelola Warga
            </h1>
            <p class="warga-subtitle">Daftar dan kelola data warga</p>
        </div>
        <a href="{{ route('admin.kelolawarga.create') }}" class="btn btn-primary">
            <span class="btn-icon"><i class="fa-solid fa-plus"></i></span>
            Tambah Warga
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="warga-alert warga-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="warga-alert warga-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Stats Bar --}}
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-users"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $wargas->count() }}</span>
                <span class="stat-card-label">Total Warga</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-building"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $wargas->unique('rw')->count() }}</span>
                <span class="stat-card-label">Jumlah RW</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-house"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $wargas->unique('rt')->count() }}</span>
                <span class="stat-card-label">Jumlah RT</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-briefcase"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $wargas->whereNotNull('pekerjaan')->count() }}</span>
                <span class="stat-card-label">Bekerja</span>
            </div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="warga-card toolbar-card">
        <div class="toolbar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass search-icon"></i>
                <input type="text" id="searchInput" placeholder="Cari nama, NIK, atau alamat...">
            </div>
            <div class="filter-group">
                <select id="filterRw" class="filter-select">
                    <option value="">Semua RW</option>
                    @foreach($wargas->unique('rw')->sortBy('rw') as $w)
                        <option value="{{ $w->rw }}">RW {{ $w->rw }}</option>
                    @endforeach
                </select>
                <select id="filterRt" class="filter-select">
                    <option value="">Semua RT</option>
                    @foreach($wargas->unique('rt')->sortBy('rt') as $w)
                        <option value="{{ $w->rt }}">RT {{ $w->rt }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Desktop Table --}}
    <div class="warga-card table-card desktop-view">
        <div class="table-responsive">
            <table class="warga-table" id="wargaTable">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="200">Warga</th>
                        <th width="140">NIK</th>
                        <th width="70">Umur</th>
                        <th>Alamat</th>
                        <th width="120">Status</th>
                        <th width="120">Pekerjaan</th>
                        <th width="100">RW/RT</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wargas as $index => $warga)
                    <tr class="warga-row" data-name="{{ strtolower($warga->name) }}" data-nik="{{ $warga->nik }}" data-alamat="{{ strtolower($warga->alamat) }}" data-rw="{{ $warga->rw }}" data-rt="{{ $warga->rt }}">
                        <td>
                            <span class="row-number">{{ $index + 1 }}</span>
                        </td>
                        <td>
                            <div class="warga-info">
                                <div class="warga-avatar">
                                    @if($warga->foto)
                                        <img src="{{ asset('storage/' . $warga->foto) }}" alt="{{ $warga->name }}">
                                    @else
                                        <span>{{ strtoupper(substr($warga->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div class="warga-detail">
                                    <span class="warga-name">{{ $warga->name }}</span>
                                    <span class="warga-id">ID: {{ $warga->user_id }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="nik-text">{{ $warga->nik }}</span>
                        </td>
                        <td>
                            <span class="umur-badge">{{ $warga->umur }} th</span>
                        </td>
                        <td>
                            <span class="alamat-text" title="{{ $warga->alamat }}">{{ Str::limit($warga->alamat, 35) }}</span>
                        </td>
                        <td>
                            <span class="status-badge {{ strtolower(str_replace(' ', '-', $warga->status)) }}">
                                <span class="status-dot"></span>
                                {{ $warga->status }}
                            </span>
                        </td>
                        <td>{{ $warga->pekerjaan ?? '-' }}</td>
                        <td>
                            <span class="rwrt-badge">RW {{ $warga->rw }} / RT {{ $warga->rt }}</span>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.kelolawarga.show', $warga->id) }}" class="btn-action btn-view" title="Lihat">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.kelolawarga.edit', $warga->id) }}" class="btn-action btn-edit" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.kelolawarga.destroy', $warga->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Pagination info --}}
        <div class="table-footer">
            <span class="table-info">Menampilkan {{ $wargas->count() }} data warga</span>
        </div>
    </div>

    {{-- Mobile Cards --}}
    <div class="mobile-view" id="mobileCards">
        @foreach($wargas as $warga)
        <div class="warga-card-item" data-name="{{ strtolower($warga->name) }}" data-nik="{{ $warga->nik }}" data-alamat="{{ strtolower($warga->alamat) }}" data-rw="{{ $warga->rw }}" data-rt="{{ $warga->rt }}">
            <div class="card-header">
                <div class="warga-avatar-lg">
                    @if($warga->foto)
                        <img src="{{ asset('storage/' . $warga->foto) }}" alt="{{ $warga->name }}">
                    @else
                        <span>{{ strtoupper(substr($warga->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="card-header-info">
                    <h3 class="card-name">{{ $warga->name }}</h3>
                    <span class="card-nik">NIK: {{ $warga->nik }}</span>
                </div>
                <span class="status-badge {{ strtolower(str_replace(' ', '-', $warga->status)) }}">
                    <span class="status-dot"></span>
                    {{ $warga->status }}
                </span>
            </div>
            <div class="card-body">
                <div class="card-info-grid">
                    <div class="card-info-item">
                        <span class="info-label">Umur</span>
                        <span class="info-value">{{ $warga->umur }} th</span>
                    </div>
                    <div class="card-info-item">
                        <span class="info-label">Pekerjaan</span>
                        <span class="info-value">{{ $warga->pekerjaan ?? '-' }}</span>
                    </div>
                    <div class="card-info-item">
                        <span class="info-label">RW/RT</span>
                        <span class="info-value">RW {{ $warga->rw }} / RT {{ $warga->rt }}</span>
                    </div>
                </div>
                <div class="card-alamat">
                    <span class="info-label">Alamat</span>
                    <p>{{ $warga->alamat }}</p>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.kelolawarga.show', $warga->id) }}" class="btn-card btn-view-card">
                    <i class="fa-solid fa-eye"></i> Lihat
                </a>
                <a href="{{ route('admin.kelolawarga.edit', $warga->id) }}" class="btn-card btn-edit-card">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
                <form action="{{ route('admin.kelolawarga.destroy', $warga->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-card btn-delete-card">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    {{-- No Results --}}
    <div class="no-results" id="noResults" style="display: none;">
        <div class="no-results-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
        <h3>Tidak ditemukan</h3>
        <p>Tidak ada warga yang cocok dengan pencarian Anda</p>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/kelolawarga/index.js') }}"></script>
@endpush