@extends('layouts.app')

@section('title', 'Edit Profil Warga')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/warga/profile/edit.css') }}">
@endpush

@section('content')
<div class="profile-page-wrapper">
    <div class="profile-container">

        {{-- Header --}}
        <div class="profile-header">
            <h1>Edit Profil</h1>
        </div>

        {{-- Form Card --}}
        <div class="profile-card">
            <div class="profile-card-body">
                
                <form action="{{ route('warga.profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
                    @csrf
                    @method('PUT')

                    {{-- NIK --}}
                    <div class="form-group">
                        <label for="nik">NIK <span class="required">*</span></label>
                        <input type="text" id="nik" name="nik"
                               class="@error('nik') is-invalid @enderror"
                               value="{{ old('nik', $profile->nik) }}"
                               maxlength="20" required>
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- No KK --}}
                    <div class="form-group">
                        <label for="kk">No. KK <span class="required">*</span></label>
                        <input type="text" id="kk" name="kk"
                               class="@error('kk') is-invalid @enderror"
                               value="{{ old('kk', $profile->kk) }}"
                               maxlength="20" required>
                        @error('kk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="name" name="name"
                               class="@error('name') is-invalid @enderror"
                               value="{{ old('name', $profile->name) }}"
                               maxlength="100" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Umur --}}
                    <div class="form-group">
                        <label for="umur">Umur <span class="required">*</span></label>
                        <input type="number" id="umur" name="umur"
                               class="@error('umur') is-invalid @enderror"
                               value="{{ old('umur', $profile->umur) }}"
                               min="0" required>
                        @error('umur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label for="alamat">Alamat <span class="required">*</span></label>
                        <textarea id="alamat" name="alamat"
                                  class="@error('alamat') is-invalid @enderror"
                                  rows="3" required>{{ old('alamat', $profile->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label for="status">Status Perkawinan <span class="required">*</span></label>
                        <select id="status" name="status"
                                class="@error('status') is-invalid @enderror" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Belum Kawin" {{ old('status', $profile->status) === 'Belum Kawin' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Kawin" {{ old('status', $profile->status) === 'Kawin' ? 'selected' : '' }}>Menikah</option>
                            <option value="Cerai Hidup" {{ old('status', $profile->status) === 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status', $profile->status) === 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pendidikan --}}
                    <div class="form-group">
                        <label for="pendidikan_akhir">Pendidikan Akhir <span class="required">*</span></label>
                        <select id="pendidikan_akhir" name="pendidikan_akhir"
                                class="@error('pendidikan_akhir') is-invalid @enderror" required>
                            <option value="">-- Pilih Pendidikan --</option>
                            <option value="Tidak/Belum Sekolah" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                            <option value="SD/Sederajat" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'SD/Sederajat' ? 'selected' : '' }}>SD/Sederajat</option>
                            <option value="SMP/Sederajat" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'SMP/Sederajat' ? 'selected' : '' }}>SMP/Sederajat</option>
                            <option value="SMA/Sederajat" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'SMA/Sederajat' ? 'selected' : '' }}>SMA/Sederajat</option>
                            <option value="D1/D2" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'D1/D2' ? 'selected' : '' }}>D1/D2</option>
                            <option value="D3" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('pendidikan_akhir', $profile->pendidikan_akhir) === 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('pendidikan_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- RW --}}
                    <div class="form-group">
                        <label for="rw">RW <span class="required">*</span></label>
                        <input type="text" id="rw" name="rw"
                               class="@error('rw') is-invalid @enderror"
                               value="{{ old('rw', $profile->rw) }}"
                               maxlength="10" required>
                        @error('rw')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- RT --}}
                    <div class="form-group">
                        <label for="rt">RT <span class="required">*</span></label>
                        <input type="text" id="rt" name="rt"
                               class="@error('rt') is-invalid @enderror"
                               value="{{ old('rt', $profile->rt) }}"
                               maxlength="10" required>
                        @error('rt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tempat Lahir --}}
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir <span class="required">*</span></label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir"
                               class="@error('tempat_lahir') is-invalid @enderror"
                               value="{{ old('tempat_lahir', $profile->tempat_lahir) }}"
                               maxlength="50" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir <span class="required">*</span></label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                               class="@error('tanggal_lahir') is-invalid @enderror"
                               value="{{ old('tanggal_lahir', $profile->tanggal_lahir) }}"
                               required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Agama --}}
                    <div class="form-group">
                        <label for="agama">Agama <span class="required">*</span></label>
                        <select id="agama" name="agama"
                                class="@error('agama') is-invalid @enderror" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam" {{ old('agama', $profile->agama) === 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama', $profile->agama) === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama', $profile->agama) === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $profile->agama) === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama', $profile->agama) === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama', $profile->agama) === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            <option value="Lainnya" {{ old('agama', $profile->agama) === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                                class="@error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin', $profile->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $profile->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Pekerjaan --}}
                    <div class="form-group">
                        <label for="pekerjaan">Pekerjaan <span class="required">*</span></label>
                        <input type="text" id="pekerjaan" name="pekerjaan"
                               class="@error('pekerjaan') is-invalid @enderror"
                               value="{{ old('pekerjaan', $profile->pekerjaan) }}"
                               maxlength="100" required>
                        @error('pekerjaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="form-group">
                        <label for="foto">Foto Profil</label>
                        <input type="file" id="foto" name="foto" 
                               class="@error('foto') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/jpg,image/gif">
                        <small class="form-hint">Maksimal 2MB (JPG, PNG, GIF)</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        @if (!empty($profile->foto))
                            <div class="current-foto">
                                <small>Foto saat ini:</small>
                                <img src="{{ Storage::url($profile->foto) }}" 
                                     class="foto-preview" 
                                     alt="Foto saat ini"
                                     id="currentFoto">
                            </div>
                        @endif
                        <div id="fotoPreviewContainer" class="preview-foto" style="display: none;">
                            <small>Preview foto baru:</small>
                            <img id="fotoPreview" class="foto-preview" alt="Preview">
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                               class="@error('email') is-invalid @enderror"
                               value="{{ old('email', $profile->user->email ?? Auth::user()->email) }}">
                        <small class="form-hint">Kosongkan jika tidak ingin mengubah email</small>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <input type="password" id="password" name="password"
                               class="@error('password') is-invalid @enderror"
                               minlength="6">
                        <small class="form-hint">Kosongkan jika tidak ingin mengganti password (min. 6 karakter)</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tombol Kembali --}}
                    <div class="form-actions">
                        <a href="{{ route('warga.profile.index') }}" class="btn btn-back">
                            Kembali ke Profil
                        </a>
                        <button type="submit" class="btn btn-save">Simpan Perubahan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/profile/edit.js') }}"></script>
@endpush