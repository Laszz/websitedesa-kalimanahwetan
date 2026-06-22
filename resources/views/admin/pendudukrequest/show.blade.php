@extends('layouts.admin')

@section('title', 'Detail Pengajuan Warga')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/pendudukrequest/show.css') }}">
@endpush

@section('content')
<div class="request-page request-show">

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="request-alert request-alert-success">
            <span class="alert-icon"><i class="fa-solid fa-check-circle"></i></span>
            <span class="alert-text">{{ session('success') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="request-alert request-alert-error">
            <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
            <span class="alert-text">{{ session('error') }}</span>
            <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
        </div>
    @endif

    {{-- Header --}}
    <div class="request-header">
        <div class="header-content">
            <h1 class="request-title">
                <span class="request-icon"><i class="fa-solid fa-file-signature"></i></span>
                Detail Pengajuan Warga
            </h1>
            <p class="request-subtitle">Informasi lengkap permohonan warga</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.pendudukrequest.edit', $requestData->id) }}" class="btn btn-edit-header">
                <i class="fa-solid fa-pen"></i>
                Edit Status
            </a>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="info-grid">
        {{-- Data Warga --}}
        <div class="info-section request-card">
            <h3 class="section-title">
                <span class="section-icon"><i class="fa-solid fa-user"></i></span>
                Data Warga
            </h3>
            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $requestData->user->warga->name ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">NIK</span>
                    <span class="info-value">{{ $requestData->user->warga->nik ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">KK</span>
                    <span class="info-value">{{ $requestData->user->warga->kk ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $requestData->user->email ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Alamat</span>
                    <span class="info-value">{{ $requestData->user->warga->alamat ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Pekerjaan</span>
                    <span class="info-value">{{ $requestData->user->warga->pekerjaan ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Detail Pengajuan --}}
        <div class="info-section request-card">
            <h3 class="section-title">
                <span class="section-icon"><i class="fa-solid fa-clipboard-list"></i></span>
                Detail Pengajuan
            </h3>
            <div class="info-list">
                <div class="info-row">
                    <span class="info-label">Layanan</span>
                    <span class="info-value">{{ $requestData->layanan->nama_layanan ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Kategori</span>
                    <span class="info-value">{{ $requestData->layanan->kategori ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Output</span>
                    <span class="info-value">{{ $requestData->layanan->output ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if ($requestData->status === 'pending')
                            <span class="status-badge status-pending">
                                <span class="status-dot"></span>
                                Pending
                            </span>
                        @elseif ($requestData->status === 'review')
                            <span class="status-badge status-review">
                                <span class="status-dot"></span>
                                Direview
                            </span>
                        @elseif ($requestData->status === 'approved')
                            <span class="status-badge status-approved">
                                <span class="status-dot"></span>
                                Disetujui
                            </span>
                        @elseif ($requestData->status === 'selesai')
                            <span class="status-badge status-selesai">
                                <span class="status-dot"></span>
                                Selesai
                            </span>
                        @else
                            <span class="status-badge status-rejected">
                                <span class="status-dot"></span>
                                Ditolak
                            </span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Pengajuan</span>
                    <span class="info-value">{{ $requestData->created_at->format('d F Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Catatan --}}
    <div class="notes-grid">
        <div class="note-card note-user">
            <div class="note-header">
                <span class="note-icon"><i class="fa-solid fa-comment-dots"></i></span>
                <strong>Catatan dari Warga</strong>
            </div>
            <p>{{ $requestData->catatan_user ?? 'Tidak ada catatan' }}</p>
        </div>

        @if($requestData->catatan_admin)
        <div class="note-card note-admin">
            <div class="note-header">
                <span class="note-icon"><i class="fa-solid fa-user-shield"></i></span>
                <strong>Catatan Admin</strong>
            </div>
            <p>{{ $requestData->catatan_admin }}</p>
        </div>
        @endif
    </div>

    {{-- Berkas Persyaratan --}}
    <div class="request-card files-card">
        <h3 class="section-title">
            <span class="section-icon"><i class="fa-solid fa-folder-open"></i></span>
            Berkas Persyaratan
        </h3>

        @forelse($requestData->uploads as $file)
            <div class="file-item">
                <div class="file-left">
                    <div class="file-icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div class="file-info">
                        <span class="file-name">{{ $file->requirement->nama_syarat ?? 'File' }}</span>
                        <span class="file-meta">ID: {{ $file->id }}</span>
                    </div>
                </div>

                @if($file->file_path)
                    <div class="file-actions">
                        <a href="{{ route('admin.upload.view', $file->id) }}"
                           target="_blank"
                           class="btn btn-view-file">
                            <i class="fa-solid fa-eye"></i>
                            Lihat
                        </a>
                        <a href="{{ route('admin.upload.download', $file->id) }}"
                           class="btn btn-download-file">
                            <i class="fa-solid fa-download"></i>
                            Download
                        </a>
                    </div>
                @else
                    <span class="file-empty"><i class="fa-solid fa-circle-xmark"></i> Tidak ada file</span>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <span class="empty-icon"><i class="fa-solid fa-folder-open"></i></span>
                <p>Tidak ada file diupload</p>
            </div>
        @endforelse
    </div>

    {{-- Back Button --}}
    <div class="back-wrapper">
        <a href="{{ route('admin.pendudukrequest.index') }}" class="btn-back">Kembali ke Daftar</a>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/pendudukrequest/show.js') }}"></script>
@endpush