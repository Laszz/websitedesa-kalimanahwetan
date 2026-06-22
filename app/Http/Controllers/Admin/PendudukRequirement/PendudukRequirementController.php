<?php

namespace App\Http\Controllers\Admin\PendudukRequirement;

use App\Http\Controllers\Controller;
use App\Models\LayananPenduduk;
use App\Models\PendudukRequirement;
use Illuminate\Http\Request;

class PendudukRequirementController extends Controller
{
    // ===============================
    // INDEX - LIST SYARAT PER LAYANAN
    // ===============================
    public function index($layananId)
    {
        $layanan = LayananPenduduk::findOrFail($layananId);

        $requirements = PendudukRequirement::where('layanan_id', $layananId)
            ->latest()
            ->get();

        return view('admin.pendudukrequirement.index', compact('layanan', 'requirements'));
    }

    // ===============================
    // CREATE - FORM TAMBAH SYARAT
    // ===============================
    public function create($layananId)
    {
        $layanan = LayananPenduduk::findOrFail($layananId);

        return view('admin.pendudukrequirement.create', compact('layanan'));
    }

    // ===============================
    // STORE - SIMPAN SYARAT
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'layanan_id'  => 'required|exists:layanan_penduduks,id',
            'nama_syarat' => 'required|string|max:255',
            'tipe'        => 'required|in:file,text',
            'wajib'       => 'nullable|boolean',
        ]);

        PendudukRequirement::create([
            'layanan_id'  => $request->layanan_id,
            'nama_syarat' => $request->nama_syarat,
            'tipe'        => $request->tipe,
            'wajib'       => $request->wajib ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.pendudukrequirement.index', $request->layanan_id)
            ->with('success', 'Persyaratan berhasil ditambahkan');
    }

    // ===============================
    // EDIT - FORM EDIT SYARAT
    // ===============================
    public function edit($id)
    {
        $requirement = PendudukRequirement::findOrFail($id);
        $layanan = $requirement->layanan;

        return view('admin.pendudukrequirement.edit', compact('requirement', 'layanan'));
    }

    // ===============================
    // UPDATE - UPDATE SYARAT
    // ===============================
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_syarat' => 'required|string|max:255',
            'tipe'        => 'required|in:file,text',
            'wajib'       => 'nullable|boolean',
        ]);

        $requirement = PendudukRequirement::findOrFail($id);

        $requirement->update([
            'nama_syarat' => $request->nama_syarat,
            'tipe'        => $request->tipe,
            'wajib'       => $request->wajib ? 1 : 0,
        ]);

        return redirect()
            ->route('admin.pendudukrequirement.index', $requirement->layanan_id)
            ->with('success', 'Persyaratan berhasil diupdate');
    }

    // ===============================
    // DELETE - HAPUS SYARAT
    // ===============================
    public function destroy($id)
    {
        $requirement = PendudukRequirement::findOrFail($id);
        $layananId = $requirement->layanan_id;

        $requirement->delete();

        return redirect()
            ->route('admin.pendudukrequirement.index', $layananId)
            ->with('success', 'Persyaratan berhasil dihapus');
    }
}