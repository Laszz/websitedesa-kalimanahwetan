@extends('layouts.app')

@section('title', 'Profil Warga')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/warga/profile/index.css') }}">
@endpush

@section('content')
<div class="profile-page-wrapper">
    <div class="profile-container">

        {{-- Header --}}
        <div class="profile-header">
            <h1>Profil Warga</h1>
        </div>

        {{-- Profile Card --}}
        <div class="profile-card">
            <div class="profile-card-body">
                
                {{-- Foto Profil --}}
                    <div class="profile-photo-section">
                        @if($profile->foto)
                            <div class="profile-photo-wrapper">
                                <img src="{{ Storage::url($profile->foto) }}" 
                                    alt="Foto Profil" 
                                    class="profile-photo"
                                    id="profilePhoto">
                            </div>
                        @else
                            <div class="profile-photo-wrapper">
                                <div class="profile-photo-placeholder">
                                    <span>{{ strtoupper(substr($profile->name, 0, 1)) }}</span>
                                </div>
                            </div>
                        @endif
                        <h3 class="profile-name">{{ $profile->name }}</h3>
                        <span class="profile-email-badge">{{ $profile->user?->email ?? 'Email belum diatur' }}</span>
                    </div>

                {{-- Data Table --}}
                <div class="profile-table-wrapper">
                    <table class="profile-data-table">
                        <tbody>
                            <tr>
                                <th>NIK</th>
                                <td>{{ $profile->nik }}</td>
                            </tr>
                            <tr>
                                <th>No. KK</th>
                                <td>{{ $profile->kk }}</td>
                            </tr>
                            <tr>
                                <th>Umur</th>
                                <td>{{ $profile->umur }} tahun</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>{{ $profile->alamat }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $profile->status }}</td>
                            </tr>
                            <tr>
                                <th>Pendidikan Akhir</th>
                                <td>{{ $profile->pendidikan_akhir }}</td>
                            </tr>
                            <tr>
                                <th>RW / RT</th>
                                <td>RW {{ $profile->rw }} / RT {{ $profile->rt }}</td>
                            </tr>
                            <tr>
                                <th>Tempat, Tanggal Lahir</th>
                                <td>{{ $profile->tempat_lahir }}, {{ \Carbon\Carbon::parse($profile->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Agama</th>
                                <td>{{ $profile->agama }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <td>{{ $profile->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <th>Pekerjaan</th>
                                <td>{{ $profile->pekerjaan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Card Footer --}}
            <div class="profile-card-footer">
                <a href="{{ route('warga.dashboard') }}" class="btn btn-back">
                    Kembali ke Dashboard
                </a>
                <a href="{{ route('warga.profile.edit') }}" class="btn btn-edit">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/warga/profile/index.js') }}"></script>
@endpush