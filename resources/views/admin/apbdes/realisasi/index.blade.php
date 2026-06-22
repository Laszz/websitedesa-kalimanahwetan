@extends('layouts.admin')

@section('title', 'Realisasi Bulanan')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/apbdes/realisasi.css') }}">
@endpush

@section('content')
<div class="realisasi-page realisasi-index">

    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">Realisasi Bulanan</h1>
            <p class="page-subtitle">Pemakaian dana & verifikasi</p>
        </div>
        <a href="{{ route('admin.apbdes.realisasi.create') }}" class="btn btn-primary">
            <span class="btn-icon">+</span> Tambah Realisasi
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
            @if($realisasis->count() > 0)
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="th-no">No</th>
                            <th>Kegiatan</th>
                            <th>Bulan/Tahun</th>
                            <th>Triwulan</th>
                            <th>Nominal</th>
                            <th>Keterangan</th>
                            <th>Bukti</th>
                            <th>Status</th>
                            <th>Verifikator</th>
                            <th class="th-aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($realisasis as $index => $realisasi)
                        <tr class="row-status-{{ $realisasi->status }}">
                            <td class="text-center">{{ $realisasis->firstItem() + $index }}</td>
                            <td class="fw-bold">
                                {{ $realisasi->pengalokasian->nama_kegiatan ?? '-' }}
                                <span class="sub-text">{{ $realisasi->sumberDana->nama_sumber ?? '-' }}</span>
                            </td>
                            <td class="text-center">{{ $realisasi->bulan }}/{{ $realisasi->tahun }}</td>
                            <td class="text-center">TW {{ $realisasi->triwulan }}</td>
                            <td class="text-right fw-bold">Rp {{ number_format($realisasi->nominal_digunakan, 0, ',', '.') }}</td>
                            <td>{{ Str::limit($realisasi->keterangan_pemakaian, 30) }}</td>
                            <td class="text-center">
                                @if($realisasi->bukti_transaksi)
                                    <a href="{{ Storage::url($realisasi->bukti_transaksi) }}" target="_blank" class="btn-icon-only btn-view" title="Lihat Bukti"><i class="fa-solid fa-file"></i></a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge status-{{ $realisasi->status }}">
                                    {{ strtoupper($realisasi->status) }}
                                </span>
                            </td>
                            <td>
                                @if($realisasi->verifier)
                                    <span class="verifier-name">{{ $realisasi->verifier->name }}</span>
                                    <span class="verifier-date">{{ $realisasi->verified_at?->format('d/m/Y') }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.apbdes.realisasi.show', $realisasi->id) }}" class="btn-icon-only btn-view" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('admin.apbdes.realisasi.edit', $realisasi->id) }}" class="btn-icon-only btn-edit" title="Edit"><i class="fa-solid fa-pen"></i></a>
                                    @if($realisasi->status === 'pending')
                                        <a href="{{ route('admin.apbdes.realisasi.show-verify', $realisasi->id) }}" class="btn-icon-only btn-verify" title="Verifikasi"><i class="fa-solid fa-check"></i></a>
                                    @endif
                                    <form action="{{ route('admin.apbdes.realisasi.destroy', $realisasi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus realisasi ini?')">
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
                {{ $realisasis->links() }}
            </div>

            <div class="back-actions">
                <a href="{{ route('admin.apbdes.index') }}" class="btn btn-outline">
                    <span class="btn-icon"></span> Kembali ke Dashboard APBDES
                </a>
            </div>

            @else
            <div class="empty-state">
                <span class="empty-icon">📭</span>
                <p class="empty-text">Belum ada realisasi</p>
                <a href="{{ route('admin.apbdes.realisasi.create') }}" class="btn btn-primary">Tambah Realisasi Pertama</a>
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
    <script src="{{ asset('js/admin/apbdes/realisasi.js') }}"></script>
@endpush