@extends('layouts.admin')

@section('title', 'Penerima Bantuan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/penerimabantuan/index.css') }}">
@endpush

@section('content')

    {{-- Alerts --}}
    @if(session('success'))
        <div class="alert pb-alert pb-alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert pb-alert pb-alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Header --}}
    <div class="pb-page-header">
        <h1 class="pb-page-title">Data Penerima Bantuan</h1>
        <div class="pb-header-actions">
            <a href="{{ route('admin.penerimabantuan.export', request()->query()) }}" class="pb-btn-export">
                <i class="fas fa-file-excel"></i> Rekap Excel
            </a>
            <a href="{{ route('admin.penerimabantuan.create') }}" class="pb-btn-primary">
                <i class="fas fa-plus"></i> Tambah Penerima
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="card pb-filter-card">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.penerimabantuan.index') }}" class="pb-filter-form">
                <div class="pb-filter-row">
                    <div class="pb-filter-col">
                        <select name="desil" class="form-select pb-form-select">
                            <option value="">-- Semua Desil --</option>
                            @foreach($desilList as $d)
                                <option value="{{ $d }}" {{ request('desil') == $d ? 'selected' : '' }}>
                                    Desil {{ $d }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pb-filter-col">
                        <select name="jenis_bantuan_id" class="form-select pb-form-select">
                            <option value="">-- Semua Jenis Bantuan --</option>
                            @foreach($jenisBantuans as $jb)
                                <option value="{{ $jb->id }}" {{ request('jenis_bantuan_id') == $jb->id ? 'selected' : '' }}>
                                    {{ $jb->nama_bantuan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="pb-filter-col">
                        <select name="status" class="form-select pb-form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="dicabut" {{ request('status') == 'dicabut' ? 'selected' : '' }}>Dicabut</option>
                        </select>
                    </div>
                    <div class="pb-filter-col pb-filter-col-grow">
                        <input type="text" name="keyword" class="form-control pb-form-input" placeholder="Cari NIK / Nama..." value="{{ request('keyword') }}">
                    </div>
                    <div class="pb-filter-col pb-filter-col-btn">
                        <button type="submit" class="pb-btn-search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Data Counter --}}
    <div class="pb-counter-row">
        <div class="pb-counter-grid">
            <div class="pb-counter-item">
                <div class="card pb-counter-card pb-counter-total text-white">
                    <div class="card-body text-center">
                        <h5 class="pb-counter-value" data-target="{{ $penerimaBantuans->count() }}">{{ $penerimaBantuans->count() }}</h5>
                        <small>Total Penerima</small>
                    </div>
                </div>
            </div>
            <div class="pb-counter-item">
                <div class="card pb-counter-card pb-counter-aktif text-white">
                    <div class="card-body text-center">
                        <h5 class="pb-counter-value" data-target="{{ $penerimaBantuans->where('status', 'aktif')->count() }}">{{ $penerimaBantuans->where('status', 'aktif')->count() }}</h5>
                        <small>Penerima Aktif</small>
                    </div>
                </div>
            </div>
            <div class="pb-counter-item">
                <div class="card pb-counter-card pb-counter-nonaktif text-white">
                    <div class="card-body text-center">
                        <h5 class="pb-counter-value" data-target="{{ $penerimaBantuans->where('status', 'nonaktif')->count() }}">{{ $penerimaBantuans->where('status', 'nonaktif')->count() }}</h5>
                        <small>Penerima Nonaktif</small>
                    </div>
                </div>
            </div>
            <div class="pb-counter-item">
                <div class="card pb-counter-card pb-counter-dicabut text-white">
                    <div class="card-body text-center">
                        <h5 class="pb-counter-value" data-target="{{ $penerimaBantuans->where('status', 'dicabut')->count() }}">{{ $penerimaBantuans->where('status', 'dicabut')->count() }}</h5>
                        <small>Penerima Dicabut</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card pb-table-card">
        <div class="card-body">
            <div class="table-responsive pb-table-responsive">
                <table class="table table-bordered table-hover align-middle pb-table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>NIK</th>
                            <th>Nama Warga</th>
                            <th>Jenis Bantuan</th>
                            <th>Desil</th>
                            <th>Status</th>
                            <th>Tanggal Terima</th>
                            <th width="12%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penerimaBantuans as $index => $pb)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $pb->warga->nik ?? '-' }}</td>
                                <td>{{ $pb->warga->name ?? '-' }}</td>
                                <td>{{ $pb->jenisBantuan->nama_bantuan ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge pb-desil-badge {{ $pb->desil <= 3 ? 'pb-desil-prioritas' : ($pb->desil <= 7 ? 'pb-desil-menengah' : 'pb-desil-tinggi') }}">
                                        Desil {{ $pb->desil }}
                                    </span>
                                </td>
                                <td class="text-center">{!! $pb->status_badge !!}</td>
                                <td class="text-center">{{ $pb->tanggal_terima ? $pb->tanggal_terima->format('d/m/Y') : '-' }}</td>
                                <td class="text-center">
                                    <div class="pb-action-group">
                                        <a href="{{ route('admin.penerimabantuan.show', $pb->id) }}" class="btn btn-sm btn-info pb-action-btn" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.penerimabantuan.edit', $pb->id) }}" class="btn btn-sm btn-warning pb-action-btn" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.penerimabantuan.destroy', $pb->id) }}" method="POST" class="pb-delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger pb-action-btn" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
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
    <script src="{{ asset('js/admin/penerimabantuan/index.js') }}"></script>
@endpush