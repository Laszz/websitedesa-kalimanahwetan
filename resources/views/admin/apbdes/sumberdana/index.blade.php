@extends('layouts.admin')

@section('title', 'Sumber Dana')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/sumberdana.css') }}">
@endpush

@section('content')
<div class="sumberdana-page sumberdana-index">
    
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Sumber Dana</h1>
            <p class="page-subtitle">Kelola sumber pendapatan desa</p>
        </div>
        <a href="{{ route('admin.apbdes.sumberdana.create') }}" class="btn btn-primary">
            <span class="btn-icon">+</span> Tambah Sumber Dana
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
            @if($sumberDanas->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Jenis</th>
                            <th>Nama Sumber</th>
                            <th>Tahun</th>
                            <th>Nominal Awal</th>
                            <th>Terpakai</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Dibuat Oleh</th>
                            <th class="th-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sumberDanas as $index => $sumber)
                        <tr>
                            <td class="text-center">{{ $sumberDanas->firstItem() + $index }}</td>
                            <td>
                                <span class="jenis-badge jenis-{{ $sumber->jenis }}">
                                    {{ strtoupper($sumber->jenis) }}
                                </span>
                            </td>
                            <td class="fw-bold">{{ $sumber->nama_sumber }}</td>
                            <td>{{ $sumber->tahunAnggaran->tahun ?? '-' }}</td>
                            <td class="text-right" data-counter>Rp {{ number_format($sumber->nominal_awal, 0, ',', '.') }}</td>
                            <td class="text-right" data-counter>Rp {{ number_format($sumber->nominal_terpakai, 0, ',', '.') }}</td>
                            <td class="text-right {{ $sumber->sisa <= 0 ? 'text-danger' : 'text-success' }}" data-counter>
                                Rp {{ number_format($sumber->sisa, 0, ',', '.') }}
                            </td>
                            <td>
                                <span class="status-badge status-{{ $sumber->status }}">
                                    {{ strtoupper($sumber->status) }}
                                </span>
                            </td>
                            <td>{{ $sumber->creator->name ?? '-' }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.apbdes.sumberdana.show', $sumber->id) }}" class="btn-icon-only btn-view" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.apbdes.sumberdana.edit', $sumber->id) }}" class="btn-icon-only btn-edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    <form action="{{ route('admin.apbdes.sumberdana.destroy', $sumber->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus sumber dana {{ $sumber->nama_sumber }}?')">
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
                {{ $sumberDanas->links() }}
            </div>
            @else
            <div class="empty-state">
                <p class="empty-text">Belum ada sumber dana</p>
                <a href="{{ route('admin.apbdes.sumberdana.create') }}" class="btn btn-primary">
                    <span class="btn-icon">+</span> Tambah Sumber Dana Pertama
                </a>
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
    <script src="{{ asset('js/admin/apbdes/sumberdana.js') }}"></script>
@endpush