@extends('layouts.admin')

@section('title', 'Tahun Anggaran')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/tahunanggaran.css') }}">
@endpush

@section('content')
<div class="tahunanggaran-page tahunanggaran-index">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Tahun Anggaran</h1>
            <p class="page-subtitle">Kelola periode anggaran desa</p>
        </div>
        <a href="{{ route('admin.apbdes.tahun.create') }}" class="btn btn-primary">
            <span class="btn-icon">+</span> Tambah Tahun
        </a>
    </div>

    {{-- Alert Messages --}}
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
            @if($tahunAnggarans->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Tahun</th>
                            <th>Status</th>
                            <th>Total Anggaran</th>
                            <th>Total Realisasi</th>
                            <th>Sisa</th>
                            <th>Sumber Dana</th>
                            <th>Bidang</th>
                            <th class="th-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tahunAnggarans as $index => $tahun)
                        <tr>
                            <td class="text-center">{{ $tahunAnggarans->firstItem() + $index }}</td>
                            <td class="fw-bold text-lg">{{ $tahun->tahun }}</td>
                            <td>
                                <span class="status-badge status-{{ $tahun->status }}">
                                    {{ strtoupper($tahun->status) }}
                                </span>
                            </td>
                            <td class="text-right">Rp {{ number_format($tahun->total_anggaran, 0, ',', '.') }}</td>
                            <td class="text-right">Rp {{ number_format($tahun->total_realisasi, 0, ',', '.') }}</td>
                            <td class="text-right {{ $tahun->sisa < 0 ? 'text-danger' : 'text-success' }}">
                                Rp {{ number_format($tahun->sisa, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <span class="count-badge">{{ $tahun->sumber_danas_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="count-badge">{{ $tahun->bidang_anggarans_count }}</span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.apbdes.tahun.show', $tahun->id) }}" class="btn-icon-only btn-view" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.apbdes.tahun.edit', $tahun->id) }}" class="btn-icon-only btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.apbdes.tahun.destroy', $tahun->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus tahun {{ $tahun->tahun }}? Semua data terkait akan ikut terhapus.')">
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
                {{ $tahunAnggarans->links() }}
            </div>
            @else
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <p class="empty-text">Belum ada tahun anggaran</p>
                <a href="{{ route('admin.apbdes.tahun.create') }}" class="btn btn-primary">Buat Tahun Pertama</a>
            </div>
            @endif
            
            <div class="back-actions">
                <a href="{{ route('admin.apbdes.index') }}" class="btn btn-outline">
                    <span class="btn-icon"></span> Kembali ke Dashboard APBDES
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/apbdes/tahunanggaran.js') }}"></script>
@endpush