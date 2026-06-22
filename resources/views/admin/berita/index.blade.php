@extends('layouts.admin')

@section('title', 'Daftar Berita')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/berita/index.css') }}">
@endpush

@section('content')
<div class="berita-page berita-index">

    {{-- Header --}}
    <div class="berita-header">
        <div class="header-content">
            <h1 class="berita-title">
                <span class="berita-icon"><i class="fa-solid fa-newspaper"></i></span>
                Daftar Berita
            </h1>
            <p class="berita-subtitle">Kelola berita dan pengumuman desa</p>
        </div>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-tambah">
            <i class="fa-solid fa-plus"></i> Tambah Berita
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="berita-alert berita-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="berita-alert berita-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <span class="stat-card-icon"><i class="fa-solid fa-newspaper"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $beritas->total() }}</span>
                <span class="stat-card-label">Total Berita</span>
            </div>
        </div>
        <div class="stat-card stat-tampil">
            <span class="stat-card-icon"><i class="fa-solid fa-eye"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $beritas->where('tampilkan', 'tampilkan')->count() }}</span>
                <span class="stat-card-label">Berita Ditampilkan</span>
            </div>
        </div>
        <div class="stat-card stat-draf">
            <span class="stat-card-icon"><i class="fa-solid fa-eye-slash"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $beritas->where('tampilkan', 'draf')->count() }}</span>
                <span class="stat-card-label">Berita Draf</span>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="berita-card table-card">
        <div class="table-wrapper">
            <table class="berita-table" id="beritaTable">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Gambar</th>
                        <th>Judul</th>
                        <th width="120">Tanggal</th>
                        <th width="110">Status</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($beritas as $key => $berita)
                    <tr class="berita-row">
                        <td>
                            <span class="row-number">{{ $beritas->firstItem() + $key }}</span>
                        </td>
                        <td>
                            <div class="berita-thumb">
                                <img src="{{ asset('storage/'.$berita->gambar) }}"
                                     alt="{{ $berita->judul }}"
                                     class="gambar-berita">
                            </div>
                        </td>
                        <td>
                            <span class="judul-text" title="{{ $berita->judul }}">{{ Str::limit($berita->judul, 50) }}</span>
                        </td>
                        <td>
                            <span class="tanggal-text">
                                <i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($berita->tanggal)->format('d/m/Y') }}
                            </span>
                        </td>
                        <td>
                            @if($berita->tampilkan == 'tampilkan')
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
                                <a href="{{ route('admin.berita.show', $berita->slug) }}"
                                   class="btn-action btn-view" title="Lihat">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.berita.edit', $berita->id) }}"
                                   class="btn-action btn-edit" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $berita->id) }}"
                                      method="POST"
                                      class="delete-form"
                                      data-name="{{ Str::limit($berita->judul, 30) }}"
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
                                <span class="empty-icon"><i class="fa-solid fa-newspaper"></i></span>
                                <p>Belum ada berita</p>
                                <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fa-solid fa-plus"></i> Buat Berita Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <span class="table-info">Menampilkan {{ $beritas->count() }} dari {{ $beritas->total() }} berita</span>
            {{ $beritas->links() }}
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/berita/index.js') }}"></script>
@endpush