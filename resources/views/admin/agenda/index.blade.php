@extends('layouts.admin')

@section('title', 'Kelola Agenda - Admin')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin/agenda/index.css') }}">
@endpush

@section('content')

<div class="container agenda-container">
    
    {{-- Header --}}
    <div class="agenda-header">
        <div>
            <h1><i class="fa-solid fa-calendar-days"></i> Kelola Agenda Desa</h1>
            <p>Kelola jadwal kegiatan dan acara desa</p>
        </div>
        <a href="{{ route('admin.agenda.create') }}" class="btn-tambah">
            <i class="fa-solid fa-plus"></i> Tambah Agenda
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fa-solid fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card stat-aktif">
            <div class="stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $agendas->where('status', 'aktif')->count() }}</span>
                <span class="stat-label">Aktif</span>
            </div>
        </div>
        <div class="stat-card stat-selesai">
            <div class="stat-icon"><i class="fa-solid fa-calendar-xmark"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $agendas->where('status', 'selesai')->count() }}</span>
                <span class="stat-label">Selesai</span>
            </div>
        </div>
        <div class="stat-card stat-batal">
            <div class="stat-icon"><i class="fa-solid fa-ban"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $agendas->where('status', 'dibatalkan')->count() }}</span>
                <span class="stat-label">Dibatalkan</span>
            </div>
        </div>
        <div class="stat-card stat-total">
            <div class="stat-icon"><i class="fa-solid fa-list"></i></div>
            <div class="stat-info">
                <span class="stat-value">{{ $agendas->total() }}</span>
                <span class="stat-label">Total</span>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-header">
            <h3><i class="fa-solid fa-table-list"></i> Daftar Agenda</h3>
        </div>
        
        <div class="table-responsive">
            <table class="agenda-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agendas as $index => $agenda)
                    <tr>
                        <td>{{ $agendas->firstItem() + $index }}</td>
                        <td>
                            <div class="agenda-judul">
                                {{ $agenda->judul }}
                                @if($agenda->seharian)
                                    <span class="badge badge-seharian"><i class="fa-solid fa-sun"></i> Seharian</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="agenda-tanggal">
                                <i class="fa-solid fa-calendar"></i>
                                {{ $agenda->mulai->timezone('Asia/Jakarta')->translatedFormat('d M Y') }}
                            </div>
                        </td>
                        <td>
                            <div class="agenda-waktu">
                                <i class="fa-solid fa-clock"></i>
                                @if($agenda->seharian)
                                    Seharian
                                @else
                                    {{ $agenda->mulai->timezone('Asia/Jakarta')->format('H:i') }}
                                    @if($agenda->selesai)
                                        - {{ $agenda->selesai->timezone('Asia/Jakarta')->format('H:i') }}
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td>
                            @if($agenda->lokasi)
                                <div class="agenda-lokasi">
                                    <i class="fa-solid fa-location-dot"></i> {{ $agenda->lokasi }}
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $agenda->status }}">
                                {{ ucfirst($agenda->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="aksi-group">
                                <a href="{{ route('admin.agenda.edit', $agenda) }}" class="btn-aksi btn-edit" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST" class="form-hapus" onsubmit="return confirm('Yakin hapus agenda ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-aksi btn-hapus" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="empty-state">
                            <i class="fa-solid fa-calendar-xmark empty-icon"></i>
                            <p>Belum ada agenda</p>
                            <a href="{{ route('admin.agenda.create') }}" class="btn-tambah-sm">
                                <i class="fa-solid fa-plus"></i> Tambah Agenda
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($agendas->hasPages())
        <div class="pagination-wrapper">
            {{ $agendas->links() }}
        </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/admin/agenda/index.js') }}"></script>
@endpush