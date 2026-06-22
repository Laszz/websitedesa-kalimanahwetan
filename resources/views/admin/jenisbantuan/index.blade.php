@extends('layouts.admin')

@section('title', 'Jenis Bantuan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/jenisbantuan/index.css') }}">
@endpush

@section('content')
<div class="container-fluid">

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert jb-alert jb-alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert jb-alert jb-alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Page Header --}}
    <div class="jb-page-header">
        <h1 class="jb-page-title">Data Jenis Bantuan</h1>
        <a href="{{ route('admin.jenisbantuan.create') }}" class="jb-btn-primary">
            <i class="fas fa-plus"></i> Tambah Jenis Bantuan
        </a>
    </div>

    {{-- Table --}}
    <div class="card jb-table-card">
        <div class="card-body">
            <div class="table-responsive jb-table-responsive">
                <table class="table table-bordered table-hover align-middle jb-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama Bantuan</th>
                            <th>Sumber Dana</th>
                            <th>Tahun Anggaran</th>
                            <th>Anggaran/KK</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jenisBantuans as $index => $jb)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td><strong>{{ $jb->kode_bantuan }}</strong></td>
                                <td>{{ $jb->nama_bantuan }}</td>
                                <td>{{ $jb->sumber_dana ?? '-' }}</td>
                                <td class="text-center">{{ $jb->tahunAnggaran->tahun ?? '-' }}</td>
                                <td class="text-center">Rp {{ number_format($jb->anggaran_per_kk, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <div class="jb-action-group">
                                        <a href="{{ route('admin.jenisbantuan.edit', $jb->id) }}" class="btn btn-sm btn-warning jb-action-btn" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.jenisbantuan.destroy', $jb->id) }}" method="POST" class="jb-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger jb-action-btn" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="fas fa-inbox fa-2x mb-3 d-block"></i>
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/jenisbantuan/index.js') }}"></script>
@endpush