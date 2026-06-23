@extends('layouts.app')

@section('content')

<div class="request-container">

    {{-- HEADER --}}
    <div class="create-header">
        <h2 class="title">
            Ajukan Permohonan
        </h2>
        <p class="subtitle">
            Layanan: <span class="layanan-name">{{ $layanan->nama_layanan }}</span>
        </p>
    </div>

    {{-- CARD FORM --}}
    <div class="card-glass form-card">

        {{-- PROGRESS STEP --}}
        <div class="form-progress">
            <div class="progress-step active">
                <div class="step-number">1</div>
                <span class="step-label">Isi Data</span>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step">
                <div class="step-number">2</div>
                <span class="step-label">Review</span>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <span class="step-label">Selesai</span>
            </div>
        </div>

        <form action="{{ route('warga.pendudukrequest.store') }}"
              method="POST"
              enctype="multipart/form-data"
              id="formAjukan">

            @csrf

            {{-- TOKEN ANTI DOUBLE SUBMIT --}}
            <input type="hidden" name="submission_token" value="{{ uniqid('req_', true) }}">

            <input type="hidden" name="layanan_id" value="{{ $layanan->id }}">

            {{-- ================= SYARAT ================= --}}
            <div class="form-section">
                <h3 class="section-title">
                    Persyaratan
                </h3>

                @foreach ($requirements as $req)
                    <div class="form-group" data-tipe="{{ $req->tipe }}">

                        <label class="form-label">
                            {{ $req->nama_syarat }}
                            @if($req->wajib)
                                <span class="required">*</span>
                            @endif
                        </label>

                        {{-- TEXT --}}
                        @if ($req->tipe === 'text')
                            <div class="input-wrapper">
                                <input type="text"
                                       class="input-modern"
                                       name="texts[{{ $req->id }}]"
                                       value="{{ old('texts.' . $req->id) }}"
                                       placeholder="Masukkan {{ strtolower($req->nama_syarat) }}"
                                       {{ $req->wajib ? 'required' : '' }}>
                                <div class="input-focus"></div>
                            </div>
                        @endif

                        {{-- FILE --}}
                        @if ($req->tipe === 'file')
                            <div class="file-upload-wrapper">
                                <input type="file"
                                       class="file-input"
                                       id="file_{{ $req->id }}"
                                       name="files[{{ $req->id }}]"
                                       accept=".jpg,.jpeg,.png,.pdf"
                                       {{ $req->wajib ? 'required' : '' }}>
                                <label for="file_{{ $req->id }}" class="file-label">
                                    <div class="file-icon">📎</div>
                                    <div class="file-text">
                                        <span class="file-main">Klik untuk upload file</span>
                                        <span class="file-sub">atau drag & drop disini</span>
                                    </div>
                                    <div class="file-status">JPG / PNG / PDF (Max 5MB)</div>
                                </label>
                                <div class="file-preview" id="preview_{{ $req->id }}"></div>
                            </div>
                        @endif

                        {{-- ERROR --}}
                        @error('texts.' . $req->id)
                            <div class="error-box">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror

                        @error('files.' . $req->id)
                            <div class="error-box">
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror

                    </div>
                @endforeach
            </div>

            {{-- CATATAN UNTUK ADMIN --}}
            <div class="form-section note-section">
                <h3 class="section-title">
                    Catatan untuk Admin
                    <small class="optional">(Opsional)</small>
                </h3>

                <div class="input-wrapper">
                    <textarea 
                        name="catatan_user" 
                        class="input-modern textarea"
                        rows="4"
                        placeholder="Contoh: Saya butuh dokumen ini untuk keperluan melamar kerja...">{{ old('catatan_user') }}</textarea>
                    <div class="input-focus"></div>
                </div>
                <p class="hint-text">Berikan informasi tambahan yang membantu admin memproses pengajuan Anda</p>

                @error('catatan_user')
                    <div class="error-box">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="form-actions">
                <a href="{{ route('warga.layananpenduduk.index') }}" class="btn-secondary">
                    Kembali
                </a>

                <button type="submit" class="btn-primary" id="btnSubmit">
                    <span class="btn-text">Kirim Permohonan</span>
                    <div class="btn-loader" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/warga/pendudukrequest/create.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/warga/pendudukrequest/create.js') }}"></script>
@endpush