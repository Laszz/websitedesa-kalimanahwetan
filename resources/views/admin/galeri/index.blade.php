@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/galeri/index.css') }}">
@endpush

@section('content')
<div class="galeri-page galeri-index">

    {{-- Header --}}
    <div class="galeri-header">
        <div class="header-content">
            <h1 class="galeri-title">
                <span class="galeri-icon"><i class="fa-solid fa-images"></i></span>
                Kelola Galeri
            </h1>
            <p class="galeri-subtitle">Kelola foto dan album galeri desa</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary btn-tambah">
            <i class="fa-solid fa-plus"></i> Tambah Foto
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="galeri-alert galeri-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="galeri-alert galeri-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <span class="stat-card-icon"><i class="fa-solid fa-images"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $galeris->total() }}</span>
                <span class="stat-card-label">Total Foto</span>
            </div>
        </div>
        <div class="stat-card stat-tampil">
            <span class="stat-card-icon"><i class="fa-solid fa-eye"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $galeris->where('tampilkan', 'tampilkan')->count() }}</span>
                <span class="stat-card-label">Foto Ditampilkan</span>
            </div>
        </div>
        <div class="stat-card stat-draf">
            <span class="stat-card-icon"><i class="fa-solid fa-eye-slash"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $galeris->where('tampilkan', 'draf')->count() }}</span>
                <span class="stat-card-label">Foto Draf</span>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="galeri-card table-card">
        <div class="table-wrapper">
            <table class="galeri-table" id="galeriTable">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th width="120">Tanggal</th>
                        <th width="110">Status</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($galeris as $key => $item)
                        <tr class="galeri-row">
                            <td>
                                <span class="row-number">{{ $galeris->firstItem() + $key }}</span>
                            </td>
                            <td>
                                <div class="galeri-thumb">
                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                         alt="{{ $item->judul }}"
                                         class="thumbnail"
                                         onerror="this.style.display='none'; this.parentElement.querySelector('.thumb-error').style.display='flex';">
                                    <div class="thumb-error" style="display: none;">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="judul-text" title="{{ $item->judul }}">{{ Str::limit($item->judul, 40) }}</span>
                            </td>
                            <td>
                                <span class="deskripsi-text" title="{{ $item->deskripsi }}">{{ Str::limit($item->deskripsi, 50) }}</span>
                            </td>
                            <td>
                                <span class="tanggal-text">
                                    <i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
                                </span>
                            </td>
                            <td>
                                @if($item->tampilkan === 'tampilkan')
                                    <span class="status-badge status-tampil">
                                        <span class="status-dot"></span> Tampil
                                    </span>
                                @else
                                    <span class="status-badge status-draf">
                                        <span class="status-dot"></span> Draf
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.galeri.show', $item->id) }}"
                                       class="btn-action btn-view" title="Lihat">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.galeri.edit', $item->id) }}"
                                       class="btn-action btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.galeri.destroy', $item->id) }}"
                                          method="POST"
                                          class="delete-form"
                                          data-name="{{ Str::limit($item->judul, 30) }}"
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
                            <td colspan="7" class="empty-cell">
                                <div class="empty-state">
                                    <span class="empty-icon"><i class="fa-solid fa-images"></i></span>
                                    <p>Belum ada foto di galeri</p>
                                    <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-plus"></i> Tambah Foto Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <span class="table-info">Menampilkan {{ $galeris->count() }} dari {{ $galeris->total() }} foto</span>
            {{ $galeris->links() }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/galeri/index.js') }}"></script>
@endpush