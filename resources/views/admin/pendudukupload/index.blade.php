@extends('layouts.admin')

@section('title', 'Upload Berkas Permohonan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">
        Berkas Permohonan: {{ $requestData->nama }}
    </h1>

    <a href="{{ route('admin.pendudukrequest.index') }}"
       class="btn-secondary">
        Kembali
    </a>
</div>

<div class="card">
    <table class="table-default">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Syarat</th>
                <th>Tipe</th>
                <th>File</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($uploads as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>

                    <td>{{ $item->requirement->nama_syarat }}</td>

                    <td>
                        <span class="badge-info">
                            {{ strtoupper($item->requirement->tipe) }}
                        </span>
                    </td>

                    <td>
                        @if ($item->file_path)
                            <a href="{{ route('admin.pendudukupload.download', $item->id) }}"
                               class="text-blue-600 underline"
                               target="_blank">
                                Download
                            </a>
                        @else
                            <span class="text-gray-400">Tidak ada file</span>
                        @endif
                    </td>

                    <td class="flex gap-2">
                        <form action="{{ route('admin.pendudukupload.destroy', $item->id) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin menghapus file ini?')">
                            @csrf
                            @method('DELETE')

                            <button class="btn-danger-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/pendudukupload/index.js') }}"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/pendudukupload/index.css') }}">
@endsection
