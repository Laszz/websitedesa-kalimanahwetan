@extends('layouts.admin')

@section('title', 'Kelola Perangkat Desa')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/perangkatdesa/index.css') }}">
@endpush

@section('content')
<div class="perangkat-page perangkat-index">

    {{-- Header --}}
    <div class="perangkat-header">
        <div class="header-content">
            <h1 class="perangkat-title">
                <span class="perangkat-icon"><i class="fa-solid fa-users-gear"></i></span>
                Kelola Perangkat Desa
            </h1>
            <p class="perangkat-subtitle">Data perangkat dan jabatan desa</p>
        </div>
        <a href="{{ route('admin.perangkatdesa.create') }}" class="btn btn-primary btn-tambah">
            <i class="fa-solid fa-plus"></i> Tambah Perangkat
        </a>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="perangkat-alert perangkat-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="perangkat-alert perangkat-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card stat-total">
            <span class="stat-card-icon"><i class="fa-solid fa-users"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $perangkat->count() }}</span>
                <span class="stat-card-label">Total Perangkat</span>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="perangkat-card table-card">
        <div class="table-wrapper">
            <table class="perangkat-table" id="perangkatTable">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="70">Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th width="80">Urutan</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($perangkat as $key => $item)
                        <tr class="perangkat-row">
                            <td>
                                <span class="row-number">{{ $key + 1 }}</span>
                            </td>
                            <td>
                                <div class="foto-wrapper">
                                    @if($item->foto)
                                        <img src="{{ asset('storage/'.$item->foto) }}"
                                             alt="{{ $item->nama }}"
                                             class="foto-preview"
                                             onerror="this.style.display='none'; this.parentElement.querySelector('.foto-error').style.display='flex';">
                                        <div class="foto-error" style="display: none;">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @else
                                        <div class="foto-placeholder">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="nama-text">{{ $item->nama }}</span>
                            </td>
                            <td>
                                <span class="jabatan-badge">
                                    <i class="fa-solid fa-id-badge"></i> {{ $item->jabatan }}
                                </span>
                            </td>
                            <td>
                                <span class="urutan-badge">{{ $item->urutan }}</span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.perangkatdesa.edit', $item->id) }}"
                                       class="btn-action btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.perangkatdesa.destroy', $item->id) }}"
                                          method="POST"
                                          class="delete-form"
                                          data-name="{{ $item->nama }}"
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
                                    <span class="empty-icon"><i class="fa-solid fa-users-gear"></i></span>
                                    <p>Belum ada data perangkat desa</p>
                                    <a href="{{ route('admin.perangkatdesa.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-plus"></i> Tambah Perangkat Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <span class="table-info">Menampilkan {{ $perangkat->count() }} data perangkat desa</span>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/perangkatdesa/index.js') }}"></script>
@endpush