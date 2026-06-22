<?php

namespace App\Http\Controllers\Admin\LayananPenduduk;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LayananPenduduk;

class LayananPendudukController extends Controller
{
    public function index()
    {
        $layanan = LayananPenduduk::orderBy('id', 'asc')->get();
        return view('admin.layananpenduduk.index', compact('layanan'));
    }

    public function create()
    {
        return view('admin.layananpenduduk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|in:layanan_administrasi_penduduk,layanan_administrasi_umum,layanan_hukum_tanah',
            'deskripsi' => 'nullable|string',
        ]);

        LayananPenduduk::create([
            'nama_layanan' => $request->nama_layanan,
            'kategori'     => $request->kategori,
            'deskripsi'    => $request->deskripsi,
            'output'       => 'PDF',
            'status'       => true,
        ]);

        return redirect()->route('admin.layananpenduduk.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $layanan = LayananPenduduk::findOrFail($id);
        return view('admin.layananpenduduk.edit', compact('layanan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|in:layanan_administrasi_penduduk,layanan_administrasi_umum,layanan_hukum_tanah',
            'deskripsi' => 'nullable|string',
        ]);

        $layanan = LayananPenduduk::findOrFail($id);

        $layanan->update([
            'nama_layanan' => $request->nama_layanan,
            'kategori'     => $request->kategori,
            'deskripsi'    => $request->deskripsi,
        ]);

        return redirect()->route('admin.layananpenduduk.index')
            ->with('success', 'Layanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        LayananPenduduk::findOrFail($id)->delete();

        return redirect()->route('admin.layananpenduduk.index')
            ->with('success', 'Layanan berhasil dihapus');
    }
}
