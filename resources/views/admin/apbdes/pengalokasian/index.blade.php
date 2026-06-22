@extends('layouts.admin')

@section('title', 'Pengalokasian Dana')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/pengalokasian.css') }}">
@endpush

@section('content')
<div class="pengalokasian-page pengalokasian-index">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Pengalokasian Dana</h1>
            <p class="page-subtitle">Alokasi dana ke kegiatan per bidang</p>
        </div>
        <a href="{{ route('admin.apbdes.pengalokasian.create') }}" class="btn btn-primary">
            <span class="btn-icon">+</span> Tambah Alokasi
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <span class="alert-icon">✅</span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <span class="alert-icon">❌</span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($pengalokasians->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Kegiatan</th>
                            <th>Bidang</th>
                            <th>Sumber Dana</th>
                            <th>Nominal</th>
                            <th>Realisasi</th>
                            <th>Sisa</th>
                            <th>Target</th>
                            <th>Status</th>
                            <th class="th-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengalokasians as $index => $alokasi)
                        <tr>
                            <td class="text-center">{{ $pengalokasians->firstItem() + $index }}</td>
                            <td class="fw-bold">
                                {{ $alokasi->nama_kegiatan }}
                                @if($alokasi->detail_kegiatan)
                                    <span class="sub-text">{{ Str::limit($alokasi->detail_kegiatan, 40) }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="bidang-badge">
                                    {{ $alokasi->bidangAnggaran->kode_bidang ?? '-' }}
                                </span>
                                {{ Str::limit($alokasi->bidangAnggaran->nama_bidang ?? '-', 25) }}
                            </td>
                            <td>
                                <span class="jenis-badge jenis-{{ $alokasi->sumberDana->jenis ?? 'lainnya' }}">
                                    {{ strtoupper($alokasi->sumberDana->jenis ?? '-') }}
                                </span>
                                <span class="sub-text">{{ $alokasi->sumberDana->nama_sumber ?? '-' }}</span>
                            </td>
                            <td class="text-right fw-bold">Rp {{ number_format($alokasi->nominal, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($alokasi->total_realisasi, 0, ',', '.') }}</td>
                            <td class="text-right {{ $alokasi->sisa < 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($alokasi->sisa, 0, ',', '.') }}
                            </td>
                            <td class="text-center">TW {{ $alokasi->triwulan_target ?? '-' }}</td>
                            <td>
                                <span class="status-badge status-{{ $alokasi->status }}">
                                    {{ strtoupper($alokasi->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.apbdes.pengalokasian.show', $alokasi->id) }}" class="btn-icon-only btn-view" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                    
                                    @if($alokasi->status === 'direncanakan')
                                        <form action="{{ route('admin.apbdes.pengalokasian.approve', $alokasi->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-icon-only btn-approve" title="Setujui" onclick="return confirm('Setujui pengalokasian ini?')"><i class="fa-solid fa-check"></i></button>
                                        </form>
                                        <form action="{{ route('admin.apbdes.pengalokasian.reject', $alokasi->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-icon-only btn-reject" title="Tolak" onclick="return confirm('Tolak pengalokasian ini?')"><i class="fa-solid fa-xmark"></i></button>
                                        </form>
                                    @elseif($alokasi->status === 'disetujui')
                                        <form action="{{ route('admin.apbdes.pengalokasian.revisi', $alokasi->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-icon-only btn-revisi" title="Minta Revisi" onclick="return confirm('Minta revisi pengalokasian ini?')"><i class="fa-solid fa-pen-to-square"></i></button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('admin.apbdes.pengalokasian.edit', $alokasi->id) }}" class="btn-icon-only btn-edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form action="{{ route('admin.apbdes.pengalokasian.destroy', $alokasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus alokasi {{ $alokasi->nama_kegiatan }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon-only btn-delete" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pagination-wrap">
                {{ $pengalokasians->links() }}
            </div>
            
            <div class="back-actions">
                <a href="{{ route('admin.apbdes.index') }}" class="btn btn-outline">
                    <span class="btn-icon"></span> Kembali ke Dashboard APBDES
                </a>
            </div>
            
            @else
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <p class="empty-text">Belum ada pengalokasian dana</p>
                <a href="{{ route('admin.apbdes.pengalokasian.create') }}" class="btn btn-primary">Buat Alokasi Pertama</a>
            </div>
            
            <div class="back-actions">
                <a href="{{ route('admin.apbdes.index') }}" class="btn btn-outline">Kembali ke Dashboard APBDES</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/pengalokasian.js') }}"></script>
@endpush