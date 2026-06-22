@extends('layouts.app')

@section('content')

<div class="detail-container">

    <div class="detail-header">
        <h2 class="title">
            Detail Pengajuan
        </h2>
        <span class="detail-id">#{{ str_pad($request->id, 4, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- TIMELINE STATUS --}}
    <div class="timeline-section card-glass">
        <h3 class="section-title">Status Pengajuan</h3>
        <div class="timeline">
            <div class="timeline-item {{ in_array($request->status, ['pending', 'review', 'approved', 'selesai']) ? 'active' : '' }} {{ $request->status == 'rejected' ? 'rejected' : '' }}">
                <div class="timeline-dot">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="timeline-content">
                    <span class="timeline-label">Diajukan</span>
                    <span class="timeline-date">{{ $request->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            
            <div class="timeline-line {{ in_array($request->status, ['review', 'approved', 'selesai']) ? 'active' : '' }} {{ $request->status == 'rejected' ? 'rejected-line' : '' }}"></div>
            
            <div class="timeline-item {{ in_array($request->status, ['review', 'approved', 'selesai']) ? 'active' : '' }} {{ $request->status == 'rejected' ? 'rejected' : '' }}">
                <div class="timeline-dot">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="timeline-content">
                    <span class="timeline-label">Direview</span>
                    <span class="timeline-date">{{ in_array($request->status, ['review', 'approved', 'selesai']) ? 'Sedang direview' : 'Menunggu' }}</span>
                </div>
            </div>
            
            <div class="timeline-line {{ in_array($request->status, ['approved', 'selesai']) ? 'active' : '' }} {{ $request->status == 'rejected' ? 'rejected-line' : '' }}"></div>
            
            <div class="timeline-item {{ in_array($request->status, ['approved', 'selesai']) ? 'active' : '' }} {{ $request->status == 'rejected' ? 'rejected' : '' }}">
                <div class="timeline-dot">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="timeline-content">
                    <span class="timeline-label">Disetujui</span>
                    <span class="timeline-date">{{ $request->status == 'approved' ? 'Sedang diproses' : ($request->status == 'selesai' ? 'Telah disetujui' : 'Menunggu') }}</span>
                </div>
            </div>
            
            <div class="timeline-line {{ $request->status == 'selesai' ? 'active' : '' }} {{ $request->status == 'rejected' ? 'rejected-line' : '' }}"></div>
            
            <div class="timeline-item {{ $request->status == 'selesai' ? 'active' : '' }} {{ $request->status == 'rejected' ? 'rejected' : '' }}">
                <div class="timeline-dot">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="timeline-content">
                    <span class="timeline-label">Selesai</span>
                    <span class="timeline-date">{{ $request->status == 'selesai' ? 'Pengajuan selesai' : 'Menunggu' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- INFO UTAMA --}}
    <div class="card-glass info-card">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-content">
                    <span class="info-label">Layanan</span>
                    <span class="info-value">{{ $request->layanan->nama_layanan ?? '-' }}</span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-content">
                    <span class="info-label">Tanggal Pengajuan</span>
                    <span class="info-value">{{ $request->created_at ? $request->created_at->format('d M Y') : '-' }}</span>
                </div>
            </div>

            <div class="info-item">
                <div class="info-content">
                    <span class="info-label">Status</span>
                    <div class="status-wrap">
                        @if($request->status == 'pending')
                            <span class="badge badge-pending"><span class="badge-dot"></span> Pending</span>
                        @elseif($request->status == 'review')
                            <span class="badge badge-review"><span class="badge-dot pulse"></span> Review</span>
                        @elseif($request->status == 'approved')
                            <span class="badge badge-approved"><span class="badge-dot"></span> Disetujui</span>
                        @elseif($request->status == 'selesai')
                            <span class="badge badge-selesai"><span class="badge-dot"></span> Selesai</span>
                        @elseif($request->status == 'rejected')
                            <span class="badge badge-rejected"><span class="badge-dot"></span> Ditolak</span>
                        @else
                            <span>-</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CATATAN DARI WARGA --}}
    @if($request->catatan_user)
    <div class="card-glass note-card note-user">
        <div class="note-header">
            <h3 class="note-title">Catatan Anda</h3>
        </div>
        <p class="note-text">{{ $request->catatan_user }}</p>
    </div>
    @endif

    {{-- CATATAN DARI ADMIN --}}
    @if($request->catatan_admin)
    <div class="card-glass note-card note-admin">
        <div class="note-header">
            <h3 class="note-title">Catatan dari Admin</h3>
        </div>
        <p class="note-text">{{ $request->catatan_admin }}</p>
    </div>
    @endif

    {{-- STATUS INFO --}}
    @if($request->status != 'pending')
    <div class="status-alert {{ $request->status }}">
        <div class="alert-icon">
            @if($request->status == 'review')
                ⏳
            @elseif($request->status == 'approved')
                ✅
            @elseif($request->status == 'rejected')
                ❌
            @elseif($request->status == 'selesai')
                🎉
            @endif
        </div>
        <div class="alert-content">
            @if($request->status == 'review')
                <strong>Sedang Direview</strong>
                <p>Pengajuan Anda sedang dalam proses review oleh admin. Mohon tunggu.</p>
            @elseif($request->status == 'approved')
                <strong>Telah Disetujui</strong>
                <p>Pengajuan Anda telah disetujui dan sedang dalam proses pengerjaan.</p>
            @elseif($request->status == 'rejected')
                <strong>Pengajuan Ditolak</strong>
                <p>Maaf, pengajuan Anda ditolak. {{ $request->catatan_admin ? 'Alasan: ' . $request->catatan_admin : '' }}</p>
            @elseif($request->status == 'selesai' && $request->file_output)
                <strong>Pengajuan Selesai!</strong>
                <p>Dokumen hasil pengajuan Anda sudah tersedia. Silakan download di bawah.</p>
            @endif
        </div>
    </div>
    @endif

    {{-- HASIL PDF --}}
    @if($request->status == 'selesai' && $request->file_output)
    <div class="card-glass download-card">
        <div class="download-header">
            <div class="download-info">
                <h3 class="download-title">Hasil Dokumen</h3>
                <p class="download-desc">Dokumen hasil pengajuan layanan Anda telah siap</p>
            </div>
        </div>
        <a href="{{ route('warga.pendudukrequest.download', $request->id) }}" class="btn-download">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            Download PDF
        </a>
    </div>
    @endif

    {{-- BERKAS / DATA PENGAJUAN --}}
    <div class="card-glass files-card">
        <div class="files-header">
            <h3 class="section-title">Berkas / Data Pengajuan</h3>
            @if(in_array($request->status, ['pending', 'review', 'rejected']) && $availableRequirements->count() > 0)
                <button type="button" class="btn-add-file" onclick="openAddModal()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Berkas
                </button>
            @endif
        </div>

        @forelse($request->uploads as $upload)
            <div class="file-item" data-upload-id="{{ $upload->id }}">
                <div class="file-info">
                    <div class="file-detail">
                        <div class="file-text-wrap">
                            <span class="file-name">{{ $upload->requirement->nama_syarat ?? '-' }}</span>
                            <span class="file-type">{{ $upload->file_path ? 'File terlampir' : 'Teks' }}</span>
                        </div>
                    </div>

                    <div class="file-actions">
                        @if($upload->file_path)
                            <a href="{{ route('warga.pendudukrequest.upload.view', $upload->id) }}?v={{ $upload->updated_at->timestamp }}" 
                               target="_blank" 
                               class="file-link">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat
                            </a>
                        @else
                            <span class="file-text-value">{{ $upload->value_text ?? '-' }}</span>
                        @endif

                        @if(in_array($request->status, ['pending', 'review', 'rejected']))
                            {{-- BUTTON EDIT: Pakai data-* attribute, gak pakai onclick inline --}}
                            <button type="button" class="btn-action btn-edit" 
                                    data-upload-id="{{ $upload->id }}"
                                    data-nama="{{ $upload->requirement->nama_syarat }}"
                                    data-tipe="{{ $upload->requirement->tipe }}"
                                    data-value="{{ $upload->value_text ?? '' }}"
                                    title="Edit Berkas">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>

                            <form action="{{ route('warga.pendudukrequest.upload.destroy', $upload->id) }}" 
                                  method="POST" 
                                  class="form-delete"
                                  onsubmit="return confirm('Yakin ingin menghapus berkas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus Berkas">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-files">
                <p>Tidak ada berkas yang dilampirkan</p>
            </div>
        @endforelse
    </div>

    {{-- TOMBOL KEMBALI --}}
    <a href="{{ route('warga.pendudukrequest.index') }}" class="btn-back-bottom">Kembali ke Riwayat</a>

</div>

{{-- MODAL EDIT BERKAS --}}
<div id="editModal" class="modal">
    <div class="modal-overlay" onclick="closeEditModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit Berkas</h3>
            <button type="button" class="modal-close" onclick="closeEditModal()">×</button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data" action="#">
            @csrf
            <div class="modal-body">
                <p class="modal-requirement-name" id="editRequirementName"></p>
                
                <div class="form-group" id="editFileGroup">
                    <label>File Baru</label>
                    <input type="file" name="file" id="editFileInput" accept=".jpg,.jpeg,.png,.pdf">
                    <small class="form-hint">Format: JPG, PNG, PDF (Max 5MB)</small>
                    <div class="file-size-info" id="editFileSizeInfo"></div>
                </div>
                
                <div class="form-group" id="editTextGroup" style="display:none;">
                    <label>Isi Teks</label>
                    <input type="text" name="value_text" id="editTextInput" placeholder="Masukkan teks...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-modal btn-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL TAMBAH BERKAS --}}
<div id="addModal" class="modal">
    <div class="modal-overlay" onclick="closeAddModal()"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Berkas Baru</h3>
            <button type="button" class="modal-close" onclick="closeAddModal()">×</button>
        </div>
        <form action="{{ route('warga.pendudukrequest.upload.add', $request->id) }}" method="POST" enctype="multipart/form-data" id="addForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Jenis Berkas <span class="required">*</span></label>
                    <select name="requirement_id" id="addRequirementSelect" required onchange="toggleAddInputType()">
                        <option value="">-- Pilih Jenis Berkas --</option>
                        @foreach($availableRequirements as $req)
                            <option value="{{ $req->id }}" data-tipe="{{ $req->tipe }}">{{ $req->nama_syarat }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group" id="addFileGroup">
                    <label>Upload File <span class="required">*</span></label>
                    <input type="file" name="file" id="addFileInput" accept=".jpg,.jpeg,.png,.pdf">
                    <small class="form-hint">Format: JPG, PNG, PDF (Max 5MB)</small>
                    <div class="file-size-info" id="addFileSizeInfo"></div>
                </div>
                
                <div class="form-group" id="addTextGroup" style="display:none;">
                    <label>Isi Teks <span class="required">*</span></label>
                    <input type="text" name="value_text" id="addTextInput" placeholder="Masukkan teks...">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal btn-cancel" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn-modal btn-save">Tambah Berkas</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/pendudukrequest/show.css') }}?v=5">
@endpush

@push('scripts')
<script src="{{ asset('js/warga/pendudukrequest/show.js') }}?v=5"></script>
@endpush