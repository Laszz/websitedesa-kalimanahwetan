<?php

namespace App\Http\Controllers\Admin\JenisBantuan;

use App\Http\Controllers\Controller;
use App\Models\JenisBantuan;
use App\Models\TahunAnggaran;
use Illuminate\Http\Request;

class JenisBantuanController extends Controller
{
    public function index()
    {
        $jenisBantuans = JenisBantuan::with('tahunAnggaran')->latest()->get();
        return view('admin.jenisbantuan.index', compact('jenisBantuans'));
    }

    public function create()
    {
        $tahunAnggarans = TahunAnggaran::all();
        return view('admin.jenisbantuan.create', compact('tahunAnggarans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_bantuan' => 'required|unique:jenis_bantuans,kode_bantuan|max:20',
            'nama_bantuan' => 'required|max:100',
            'sumber_dana' => 'nullable|max:100',
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
            'anggaran_per_kk' => 'required|numeric|min:0',
        ]);

        JenisBantuan::create($request->all());

        return redirect()->route('admin.jenisbantuan.index')->with('success', 'Jenis bantuan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenisBantuan = JenisBantuan::findOrFail($id);
        $tahunAnggarans = TahunAnggaran::all();
        return view('admin.jenisbantuan.edit', compact('jenisBantuan', 'tahunAnggarans'));
    }

    public function update(Request $request, $id)
    {
        $jenisBantuan = JenisBantuan::findOrFail($id);

        $request->validate([
            'kode_bantuan' => 'required|unique:jenis_bantuans,kode_bantuan,' . $id . '|max:20',
            'nama_bantuan' => 'required|max:100',
            'sumber_dana' => 'nullable|max:100',
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
            'anggaran_per_kk' => 'required|numeric|min:0',
        ]);

        $jenisBantuan->update($request->all());

        return redirect()->route('admin.jenisbantuan.index')->with('success', 'Jenis bantuan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenisBantuan = JenisBantuan::findOrFail($id);
        $jenisBantuan->delete();

        return redirect()->route('admin.jenisbantuan.index')->with('success', 'Jenis bantuan berhasil dihapus');
    }
}