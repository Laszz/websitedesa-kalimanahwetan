@extends('layouts.admin')

@section('title', 'Edit Agenda - Admin')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/agenda/edit.css') }}">
@endpush

@section('content')

<div class="container form-container">
    
    <div class="form-header">
        <h1><i class="fa-solid fa-calendar-pen"></i> Edit Agenda</h1>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.agenda.update', $agenda) }}" method="POST" id="formAgenda">
            @csrf @method('PUT')
            
            <div class="form-group">
                <label for="judul">Judul Kegiatan <span class="required">*</span></label>
                <input type="text" id="judul" name="judul" value="{{ old('judul', $agenda->judul) }}" required
                    class="@error('judul') is-invalid @enderror">
                @error('judul')
                    <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group form-check">
                <label class="check-label">
                    <input type="checkbox" name="seharian" value="1" id="seharian" {{ old('seharian', $agenda->seharian) ? 'checked' : '' }}>
                    <span class="check-box"></span>
                    <span class="check-text">Kegiatan seharian penuh</span>
                </label>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="mulai">Waktu Mulai <span class="required">*</span></label>
                    <input type="datetime-local" id="mulai" name="mulai" 
                        value="{{ old('mulai', $agenda->mulai->timezone('Asia/Jakarta')->format('Y-m-d\TH:i')) }}" required
                        class="@error('mulai') is-invalid @enderror">
                    @error('mulai')
                        <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group" id="groupSelesai">
                    <label for="selesai">Waktu Selesai</label>
                    <input type="datetime-local" id="selesai" name="selesai" 
                        value="{{ old('selesai', $agenda->selesai ? $agenda->selesai->timezone('Asia/Jakarta')->format('Y-m-d\TH:i') : '') }}"
                        class="@error('selesai') is-invalid @enderror">
                    @error('selesai')
                        <span class="error-message"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <div class="input-icon">
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" id="lokasi" name="lokasi" 
                        value="{{ old('lokasi', $agenda->lokasi) }}"
                        placeholder="Contoh: Balai Desa Kalimanah Wetan">
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    placeholder="Jelaskan detail kegiatan...">{{ old('deskripsi', $agenda->deskripsi) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Status <span class="required">*</span></label>
                <select id="status" name="status" required>
                    <option value="aktif" {{ old('status', $agenda->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ old('status', $agenda->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ old('status', $agenda->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-simpan">
                    <i class="fa-solid fa-floppy-disk"></i> Update
                </button>
                <a href="{{ route('admin.agenda.index') }}" class="btn-batal">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/agenda/edit.js') }}"></script>
@endpush