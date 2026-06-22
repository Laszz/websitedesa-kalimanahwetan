@extends('layouts.admin')

@section('title', 'Kelola Permohonan Penduduk')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/pendudukrequest/index.css') }}">
@endpush

@section('content')
<div class="request-page request-index">
    
    {{-- Header --}}
    <div class="request-header">
        <div class="header-content">
            <h1 class="request-title">
                <span class="request-icon"><i class="fa-solid fa-file-signature"></i></span>
                Kelola Permohonan Penduduk
            </h1>
            <p class="request-subtitle">Data pengajuan layanan dari warga</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="request-alert request-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="request-alert request-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Stats Bar --}}
    <div class="stats-grid">
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-inbox"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $requests->count() }}</span>
                <span class="stat-card-label">Total Permohonan</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-clock"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $requests->where('status', 'pending')->count() }}</span>
                <span class="stat-card-label">Permohonan Pending</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-magnifying-glass"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $requests->where('status', 'review')->count() }}</span>
                <span class="stat-card-label">Permohonan Direview</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-check-circle"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $requests->whereIn('status', ['approved', 'selesai'])->count() }}</span>
                <span class="stat-card-label">Permohonan Selesai</span>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="request-card table-card">
        <div class="table-wrapper">
            <table class="request-table" id="requestTable">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Pemohon</th>
                        <th>Layanan</th>
                        <th width="120">Tanggal</th>
                        <th width="120">Status</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($requests as $key => $req)
                        <tr class="request-row" data-status="{{ $req->status }}">
                            <td>
                                <span class="row-number">{{ $key + 1 }}</span>
                            </td>

                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <span>{{ strtoupper(substr($req->user->warga->name ?? '-', 0, 1)) }}</span>
                                    </div>
                                    <div class="user-detail">
                                        <span class="user-name">{{ $req->user->warga->name ?? '-' }}</span>
                                        <span class="user-id">ID: {{ $req->user_id }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="layanan-text">{{ $req->layanan->nama_layanan ?? '-' }}</span>
                            </td>

                            <td>
                                <span class="tanggal-text">{{ $req->created_at->format('d/m/Y') }}</span>
                            </td>

                            <td>
                                @if ($req->status === 'pending')
                                    <span class="status-badge status-pending">
                                        <span class="status-dot"></span>
                                        Pending
                                    </span>
                                @elseif ($req->status === 'review')
                                    <span class="status-badge status-review">
                                        <span class="status-dot"></span>
                                        Direview
                                    </span>
                                @elseif ($req->status === 'approved')
                                    <span class="status-badge status-approved">
                                        <span class="status-dot"></span>
                                        Disetujui
                                    </span>
                                @elseif ($req->status === 'selesai')
                                    <span class="status-badge status-selesai">
                                        <span class="status-dot"></span>
                                        Selesai
                                    </span>
                                @else
                                    <span class="status-badge status-rejected">
                                        <span class="status-dot"></span>
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.pendudukrequest.show', $req->id) }}"
                                       class="btn-action btn-view" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.pendudukrequest.edit', $req->id) }}"
                                       class="btn-action btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form action="{{ route('admin.pendudukrequest.destroy', $req->id) }}"
                                          method="POST"
                                          class="delete-form"
                                          data-name="{{ $req->user->warga->name ?? 'item' }}"
                                          onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-cell">
                                <div class="empty-state">
                                    <span class="empty-icon"><i class="fa-solid fa-inbox"></i></span>
                                    <p>Belum ada permohonan dari warga</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <span class="table-info">Menampilkan {{ $requests->count() }} data permohonan</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/pendudukrequest/index.js') }}"></script>
@endpush