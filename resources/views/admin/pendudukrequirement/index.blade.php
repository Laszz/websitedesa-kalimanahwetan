@extends('layouts.admin')

@section('title', 'Syarat Layanan: ' . $layanan->nama_layanan)

@section('content')
<link rel="stylesheet" href="{{ asset('css/admin/pendudukrequirement/index.css') }}">
<script src="{{ asset('js/admin/pendudukrequirement/index.js') }}" defer></script>

<div class="admin-container">

    {{-- HEADER --}}
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                Syarat Layanan
            </h1>
            <p class="page-subtitle">{{ $layanan->nama_layanan }}</p>
        </div>
        <a href="{{ route('admin.pendudukrequirement.create', $layanan->id) }}" class="btn btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Syarat
        </a>
    </div>

        {{-- STATS --}}
        <div class="stats-bar">
            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-number">{{ $requirements->count() }}</span>
                    <span class="stat-label">Total Syarat</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-number" style="color: #10b981;">{{ $requirements->where('wajib', true)->count() }}</span>
                    <span class="stat-label">Syarat Wajib</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <span class="stat-number" style="color: #f59e0b;">{{ $requirements->where('wajib', false)->count() }}</span>
                    <span class="stat-label">Syarat Opsional</span>
                </div>
            </div>
        </div>

    {{-- DESKTOP TABLE --}}
    <div class="card-glass table-wrapper desktop-view">
        <table class="data-table" id="syaratTable">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Syarat</th>
                    <th width="100">Tipe</th>
                    <th width="100">Wajib?</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requirements as $key => $item)
                <tr>
                    <td>
                        <span class="row-number">{{ $key + 1 }}</span>
                    </td>
                    <td>
                        <div class="syarat-info">
                            <div class="syarat-icon">
                                @if($item->tipe == 'file')
                                    📎
                                @else
                                    📝
                                @endif
                            </div>
                            <span class="syarat-name">{{ $item->nama_syarat }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="tipe-badge tipe-{{ $item->tipe }}">
                            {{ ucfirst($item->tipe) }}
                        </span>
                    </td>
                    <td>
                        @if ($item->wajib)
                            <span class="badge badge-success"><span class="badge-dot"></span> Wajib</span>
                        @else
                            <span class="badge badge-warning"><span class="badge-dot"></span> Opsional</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-group">
                            <a href="{{ route('admin.pendudukrequirement.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.pendudukrequirement.destroy', $item->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
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
                    <td colspan="5">
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <p>Belum ada syarat</p>
                            <a href="{{ route('admin.pendudukrequirement.create', $layanan->id) }}" class="btn btn-primary btn-sm">Tambah Syarat</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MOBILE CARDS --}}
    <div class="mobile-view" id="mobileCards">
        @forelse ($requirements as $key => $item)
        <div class="syarat-card">
            <div class="card-header">
                <div class="syarat-icon-lg">
                    @if($item->tipe == 'file')
                        📎
                    @else
                        📝
                    @endif
                </div>
                <div class="card-header-info">
                    <h3 class="card-name">{{ $item->nama_syarat }}</h3>
                    <span class="tipe-badge tipe-{{ $item->tipe }}">{{ ucfirst($item->tipe) }}</span>
                </div>
                @if ($item->wajib)
                    <span class="badge badge-success"><span class="badge-dot"></span> Wajib</span>
                @else
                    <span class="badge badge-warning"><span class="badge-dot"></span> Opsional</span>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.pendudukrequirement.edit', $item->id) }}" class="btn-card btn-edit-card">Edit</a>
                <form action="{{ route('admin.pendudukrequirement.destroy', $item->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-card btn-delete-card">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <p>Belum ada syarat</p>
        </div>
        @endforelse
    </div>

        {{-- BACK BUTTON --}}
    <a href="{{ route('admin.layananpenduduk.index') }}" class="btn-back">
        Kembali ke Layanan
    </a>

</div>
@endsection