@extends('layouts.admin')

@section('title', 'Kelola Aduan Warga')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/aduan/index.css') }}">
@endpush

@section('content')
<div class="aduan-page aduan-index">

    {{-- Header --}}
    <div class="aduan-header">
        <div class="header-content">
            <h1 class="aduan-title">
                <span class="aduan-icon"><i class="fa-solid fa-bullhorn"></i></span>
                Kelola Aduan Warga
            </h1>
            <p class="aduan-subtitle">Verifikasi dan tindak lanjuti aduan dari warga</p>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="aduan-alert aduan-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="aduan-alert aduan-alert-error">
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
                <span class="stat-card-value" data-counter>{{ $aduan->count() }}</span>
                <span class="stat-card-label">Total Aduan</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-clock"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $aduan->where('status', 'pending')->count() }}</span>
                <span class="stat-card-label">Aduan Pending</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-spinner"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $aduan->where('status', 'proses')->count() }}</span>
                <span class="stat-card-label">Aduan Diproses</span>
            </div>
        </div>
        <div class="stat-card">
            <span class="stat-card-icon"><i class="fa-solid fa-check-circle"></i></span>
            <div class="stat-card-info">
                <span class="stat-card-value" data-counter>{{ $aduan->where('status', 'selesai')->count() }}</span>
                <span class="stat-card-label">Aduan Selesai</span>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="aduan-card table-card">
        <div class="table-responsive">
            <table class="aduan-table" id="aduanTable">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Judul</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th width="120">Prioritas</th>
                        <th width="120">Status</th>
                        <th width="80">Gambar</th>
                        <th width="120">Tanggal</th>
                        <th width="140" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aduan as $index => $item)
                        @php
                            $aduanData = [
                                'judul' => $item->judul,
                                'nama' => $item->nama ?? $item->user->nama ?? '-',
                                'nomor_wa' => $item->nomor_wa,
                                'alamat' => $item->alamat,
                                'kategori' => $item->kategori ?? '-',
                                'prioritas' => ucfirst($item->prioritas ?? 'normal'),
                                'status' => ucfirst($item->status),
                                'detail' => $item->detail,
                                'tanggal' => $item->created_at->format('d F Y H:i'),
                                'gambar' => $item->gambar ? asset('storage/'.$item->gambar) : null,
                            ];
                        @endphp
                        <tr class="aduan-row" data-status="{{ $item->status }}">
                            <td>
                                <span class="row-number">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <span class="judul-text" title="{{ $item->judul }}">{{ Str::limit($item->judul, 30) }}</span>
                            </td>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        <span>{{ strtoupper(substr($item->nama ?? $item->user->nama ?? '-', 0, 1)) }}</span>
                                    </div>
                                    <span class="user-name">{{ $item->nama ?? $item->user->nama ?? '-' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="kategori-badge">{{ $item->kategori ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="prioritas-badge prioritas-{{ $item->prioritas ?? 'normal' }}">
                                    <span class="prioritas-dot"></span>
                                    {{ ucfirst($item->prioritas ?? 'normal') }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $item->status }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar" class="img-preview">
                                @else
                                    <span class="no-image"><i class="fa-solid fa-image"></i></span>
                                @endif
                            </td>
                            <td>
                                <span class="tanggal-text">{{ $item->created_at->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <button class="btn-action btn-show" data-aduan='@json($aduanData)' title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                    <a href="{{ route('admin.aduan.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.aduan.destroy', $item->id) }}" method="POST" class="delete-form" onsubmit="return confirmDelete(event)">
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
                            <td colspan="9" class="empty-cell">
                                <div class="empty-state">
                                    <span class="empty-icon"><i class="fa-solid fa-inbox"></i></span>
                                    <p>Belum ada aduan dari warga</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <span class="table-info">Menampilkan {{ $aduan->count() }} data aduan</span>
        </div>
    </div>

</div>

{{-- Modal Detail --}}
<div class="modal-overlay" id="detailModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>
                <span class="modal-icon"><i class="fa-solid fa-circle-info"></i></span>
                Detail Aduan
            </h3>
            <button class="modal-close" id="modalClose" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-heading"></i> Judul</div>
                <div class="detail-value" id="modalJudul"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-user"></i> Nama</div>
                <div class="detail-value" id="modalNama"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-phone"></i> Nomor WA</div>
                <div class="detail-value" id="modalWa"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-location-dot"></i> Alamat</div>
                <div class="detail-value" id="modalAlamat"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-tag"></i> Kategori</div>
                <div class="detail-value" id="modalKategori"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-triangle-exclamation"></i> Prioritas</div>
                <div class="detail-value" id="modalPrioritas"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-circle-check"></i> Status</div>
                <div class="detail-value" id="modalStatus"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-align-left"></i> Detail</div>
                <div class="detail-value detail-long" id="modalDetail"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-calendar"></i> Tanggal</div>
                <div class="detail-value" id="modalTanggal"></div>
            </div>
            <div class="detail-row">
                <div class="detail-label"><i class="fa-solid fa-image"></i> Gambar</div>
                <div class="detail-value" id="modalGambar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/aduan/index.js') }}"></script>
@endpush