@extends('layouts.admin')

@section('title', 'Edit Pengajuan Warga')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/pendudukrequest/edit.css') }}">
@endpush

@section('content')
<div class="request-page request-edit">

    {{-- Header --}}
    <div class="request-header">
        <div class="header-content">
            <h1 class="request-title">
                <span class="request-icon"><i class="fa-solid fa-pen-to-square"></i></span>
                Edit Pengajuan Warga
            </h1>
            <p class="request-subtitle">Ubah status, catatan, dan upload hasil PDF</p>
        </div>
    </div>

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

    {{-- Card --}}
    <div class="request-card detail-card">

        {{-- Data Warga --}}
        <div class="section">
            <h2 class="section-title">
                <i class="fa-solid fa-user"></i> Data Warga
            </h2>
            <div class="grid-2">
                <div class="data-item">
                    <span class="data-label">Nama</span>
                    <span class="data-value">{{ $requestData->user->warga->name ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label">NIK</span>
                    <span class="data-value">{{ $requestData->user->warga->nik ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label">KK</span>
                    <span class="data-value">{{ $requestData->user->warga->kk ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label">Email</span>
                    <span class="data-value">{{ $requestData->user->email ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label">Alamat</span>
                    <span class="data-value">{{ $requestData->user->warga->alamat ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label">Pekerjaan</span>
                    <span class="data-value">{{ $requestData->user->warga->pekerjaan ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Detail Layanan --}}
        <div class="section">
            <h2 class="section-title">
                <i class="fa-solid fa-briefcase"></i> Detail Layanan
            </h2>
            <div class="grid-2">
                <div class="data-item">
                    <span class="data-label">Layanan</span>
                    <span class="data-value">{{ $requestData->layanan->nama_layanan ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label">Kategori</span>
                    <span class="data-value">{{ $requestData->layanan->kategori ?? '-' }}</span>
                </div>
                <div class="data-item">
                    <span class="data-label">Output</span>
                    <span class="data-value">{{ $requestData->layanan->output ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Catatan dari Warga --}}
        @if($requestData->catatan_user)
        <div class="section">
            <h2 class="section-title">
                <i class="fa-solid fa-comment"></i> Catatan dari Warga
            </h2>
            <div class="note-box">
                <p>{{ $requestData->catatan_user }}</p>
            </div>
        </div>
        @endif

        {{-- Form --}}
        <form action="{{ route('admin.pendudukrequest.update', $requestData->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="form-section"
              id="editForm">
            @csrf
            @method('PUT')

            {{-- Error Display --}}
            @if($errors->any())
                <div class="request-alert request-alert-error">
                    <span class="alert-icon"><i class="fa-solid fa-circle-xmark"></i></span>
                    <div class="alert-text">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                    <button type="button" class="alert-close" aria-label="Tutup">&times;</button>
                </div>
            @endif

            {{-- Status --}}
            <div class="form-group">
                <label for="status">
                    <i class="fa-solid fa-tag"></i> Status Pengajuan
                </label>
                <div class="select-wrapper">
                    <select name="status" id="status" class="input input-select" required>
                        <option value="pending" {{ $requestData->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="review" {{ $requestData->status == 'review' ? 'selected' : '' }}>Direview</option>
                        <option value="approved" {{ $requestData->status == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="selesai" {{ $requestData->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ $requestData->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    <span class="status-indicator" id="statusIndicator"></span>
                </div>
            </div>

            {{-- Catatan Admin --}}
            <div class="form-group">
                <label for="catatan_admin">
                    <i class="fa-solid fa-pen"></i> Catatan untuk Warga
                </label>
                <textarea name="catatan_admin" id="catatan_admin" class="input" rows="4" placeholder="Tulis catatan untuk warga di sini...">{{ old('catatan_admin', $requestData->catatan_admin) }}</textarea>
            </div>

            {{-- Upload PDF --}}
            <div class="form-group">
                <label for="file_output">
                    <i class="fa-solid fa-file-pdf"></i> Upload Hasil (PDF)
                </label>
                <div class="file-upload-area">
                    <input type="file" name="file_output" id="file_output" class="input input-file" accept=".pdf">
                    <span class="file-hint"><i class="fa-solid fa-cloud-arrow-up"></i> Klik atau drag file PDF ke sini</span>
                </div>

                <div class="file-preview" id="filePreview" style="display: none;">
                    <i class="fa-solid fa-file-pdf file-preview-icon"></i>
                    <span class="file-preview-name" id="fileName"></span>
                    <button type="button" class="file-preview-remove" id="fileRemove" title="Hapus file">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                @if($requestData->file_output)
                    <div class="file-current">
                        <i class="fa-solid fa-file-pdf file-current-icon"></i>
                        <span>File sekarang:</span>
                        <a href="{{ asset('storage/' . $requestData->file_output) }}" target="_blank">
                            <i class="fa-solid fa-eye"></i> Lihat PDF
                        </a>
                    </div>
                @endif
            </div>

            {{-- Buttons --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('admin.pendudukrequest.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/pendudukrequest/edit.js') }}"></script>
@endpush