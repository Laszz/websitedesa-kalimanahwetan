@extends('layouts.admin')

@section('title', 'Kelola Layanan Penduduk')

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/layananpenduduk/index.css') }}">
<script src="{{ asset('js/admin/layananpenduduk/index.js') }}" defer></script>

<div class="admin-container">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                Kelola Layanan Penduduk
            </h1>
            <p class="page-subtitle">Manajemen data layanan untuk warga</p>
        </div>
        <a href="{{ route('admin.layananpenduduk.create') }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Layanan
        </a>
    </div>

    {{-- STATS --}}
    <div class="stats-bar">
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-number">{{ $layanan->count() }}</span>
                <span class="stat-label">Total Layanan</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-number" style="color: var(--success);">{{ $layanan->where('status', true)->count() }}</span>
                <span class="stat-label">Layanan Aktif</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <span class="stat-number" style="color: var(--danger);">{{ $layanan->where('status', false)->count() }}</span>
                <span class="stat-label">Layanan Nonaktif</span>
            </div>
        </div>
    </div>

    {{-- TOOLBAR --}}
    <div class="toolbar card-glass">
        <div class="search-box">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari nama layanan...">
        </div>
        <div class="filter-group">
            <select id="filterKategori" class="filter-select">
                <option value="">Semua Kategori</option>
                <option value="layanan_administrasi_penduduk">Administrasi Penduduk</option>
                <option value="layanan_administrasi_umum">Administrasi Umum</option>
                <option value="layanan_hukum_tanah">Hukum Tanah</option>
            </select>
            <select id="filterStatus" class="filter-select">
                <option value="">Semua Status</option>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
        </div>
    </div>

    {{-- DESKTOP TABLE --}}
    <div class="card-glass table-wrapper desktop-view">
        <table class="data-table" id="layananTable">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Layanan</th>
                    <th>Kategori</th>
                    <th>Output</th>
                    <th width="100">Status</th>
                    <th width="100">Syarat</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($layanan as $key => $item)
                <tr class="layanan-row" data-nama="{{ strtolower($item->nama_layanan) }}" data-kategori="{{ $item->kategori }}" data-status="{{ $item->status ? '1' : '0' }}">
                    <td>
                        <span class="row-number">{{ $key + 1 }}</span>
                    </td>
                    <td>
                        <div class="layanan-info">
                            <div class="layanan-icon">{{ strtoupper(substr($item->nama_layanan, 0, 1)) }}</div>
                            <span class="layanan-name">{{ $item->nama_layanan }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="kategori-badge">{{ str_replace('_', ' ', $item->kategori) }}</span>
                    </td>
                    <td>{{ $item->output ?? '-' }}</td>
                    <td>
                        @if ($item->status)
                            <span class="badge badge-success"><span class="badge-dot"></span> Aktif</span>
                        @else
                            <span class="badge badge-danger"><span class="badge-dot"></span> Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.pendudukrequirement.index', $item->id) }}" class="btn-syarat">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Kelola
                        </a>
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.layananpenduduk.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.layananpenduduk.destroy', $item->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <p>Belum ada layanan</p>
                            <a href="{{ route('admin.layananpenduduk.create') }}" class="btn btn-primary btn-sm">Tambah Layanan</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARDS --}}
    <div class="mobile-view" id="mobileCards">
        @forelse ($layanan as $key => $item)
        <div class="layanan-card" data-nama="{{ strtolower($item->nama_layanan) }}" data-kategori="{{ $item->kategori }}" data-status="{{ $item->status ? '1' : '0' }}">
            <div class="card-header">
                <div class="layanan-icon-lg">{{ strtoupper(substr($item->nama_layanan, 0, 1)) }}</div>
                <div class="card-header-info">
                    <h3 class="card-name">{{ $item->nama_layanan }}</h3>
                    <span class="card-kategori">{{ str_replace('_', ' ', $item->kategori) }}</span>
                </div>
                @if ($item->status)
                    <span class="badge badge-success"><span class="badge-dot"></span> Aktif</span>
                @else
                    <span class="badge badge-danger"><span class="badge-dot"></span> Nonaktif</span>
                @endif
            </div>
            <div class="card-body">
                <div class="card-info-row">
                    <span class="info-label">Output</span>
                    <span class="info-value">{{ $item->output ?? '-' }}</span>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.pendudukrequirement.index', $item->id) }}" class="btn-card btn-syarat-card">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Syarat
                </a>
                <a href="{{ route('admin.layananpenduduk.edit', $item->id) }}" class="btn-card btn-edit-card">Edit</a>
                <form action="{{ route('admin.layananpenduduk.destroy', $item->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-card btn-delete-card">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p>Belum ada layanan</p>
        </div>
        @endforelse
    </div>

    {{-- NO RESULTS --}}
    <div class="no-results" id="noResults" style="display: none;">
        <h3>Tidak ditemukan</h3>
        <p>Tidak ada layanan yang cocok dengan filter</p>
    </div>

</div>
@endsection