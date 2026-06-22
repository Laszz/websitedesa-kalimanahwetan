@extends('layouts.admin')

@section('title', 'Kelola Akun Warga')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/kelolaakun/index.css') }}">
@endpush

@section('content')
<div class="akun-page akun-index">

    {{-- Header --}}
    <div class="akun-header">
        <div class="header-content">
            <h1 class="akun-title">
                <span class="akun-icon"><i class="fa-solid fa-users-gear"></i></span>
                Kelola Akun Warga
            </h1>
            <p class="akun-subtitle">Verifikasi dan kelola status akun warga</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="akun-alert akun-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="akun-alert akun-alert-error">
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
                <span class="stat-card-value" data-counter>{{ $users->count() }}</span>
                <span class="stat-card-label">Total Akun</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-clock"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $users->where('status', 'menunggu')->count() }}</span>
                <span class="stat-card-label">Menunggu</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-check-circle"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $users->where('status', 'disetujui')->count() }}</span>
                <span class="stat-card-label">Disetujui</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-xmark-circle"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $users->where('status', 'ditolak')->count() }}</span>
                <span class="stat-card-label">Ditolak</span>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="akun-card table-card">
        <div class="table-responsive">
            <table class="akun-table" id="akunTable">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th width="160">Status</th>
                        <th width="100" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="akun-row" data-status="{{ $user->status }}">
                        <td>
                            <span class="row-number">{{ $loop->iteration }}</span>
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <div class="user-detail">
                                    <span class="user-name">{{ $user->name }}</span>
                                    <span class="user-id">ID: {{ $user->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="email-text">{{ $user->email }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.kelolaakun.updateStatus', $user->id) }}" method="POST" class="status-form">
                                @csrf
                                <select name="status" class="status-select" onchange="this.form.submit()">
                                    <option value="menunggu" {{ $user->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="disetujui" {{ $user->status == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="ditolak" {{ $user->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                <span class="status-badge {{ $user->status }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($user->status) }}
                                </span>
                            </form>
                        </td>
                        <td>
                            <div class="action-group">
                                <form action="{{ route('admin.kelolaakun.destroy', $user->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
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
                        <td colspan="5" class="empty-cell">
                            <div class="empty-state">
                                <span class="empty-icon"><i class="fa-solid fa-inbox"></i></span>
                                <p>Belum ada akun warga</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <span class="table-info">Menampilkan {{ $users->count() }} data akun warga</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/kelolaakun/index.js') }}"></script>
@endpush