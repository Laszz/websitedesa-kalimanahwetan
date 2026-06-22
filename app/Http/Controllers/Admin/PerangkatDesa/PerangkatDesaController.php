<?php

namespace App\Http\Controllers\Admin\PerangkatDesa;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerangkatDesaController extends Controller
{
    public function index()
    {
        $perangkat = PerangkatDesa::orderBy('urutan', 'asc')->get();
        return view('admin.perangkatdesa.index', compact('perangkat'));
    }

    public function create()
    {
        return view('admin.perangkatdesa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan' => 'nullable|integer',
        ]);

        $data = $request->only(['nama', 'jabatan', 'urutan']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('images/perangkatdesa', 'public');
        }

        PerangkatDesa::create($data);

        return redirect()->route('admin.perangkatdesa.index')
            ->with('success', 'Perangkat Desa berhasil ditambahkan');
    }

    public function edit(PerangkatDesa $perangkatdesa)
    {
        return view('admin.perangkatdesa.edit', compact('perangkatdesa'));
    }

    public function update(Request $request, PerangkatDesa $perangkatdesa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'urutan' => 'nullable|integer',
        ]);

        $data = $request->only(['nama', 'jabatan', 'urutan']);

        if ($request->hasFile('foto')) {
            // hapus foto lama kalau ada
            if ($perangkatdesa->foto && Storage::disk('public')->exists($perangkatdesa->foto)) {
                Storage::disk('public')->delete($perangkatdesa->foto);
            }

            $data['foto'] = $request->file('foto')->store('images/perangkatdesa', 'public');
        }

        $perangkatdesa->update($data);

        return redirect()->route('admin.perangkatdesa.index')
            ->with('success', 'Perangkat Desa berhasil diperbarui');
    }

    public function destroy(PerangkatDesa $perangkatdesa)
    {
        // hapus foto kalau ada
        if ($perangkatdesa->foto && Storage::disk('public')->exists($perangkatdesa->foto)) {
            Storage::disk('public')->delete($perangkatdesa->foto);
        }

        $perangkatdesa->delete();

        return redirect()->route('admin.perangkatdesa.index')
            ->with('success', 'Perangkat Desa berhasil dihapus');
    }
}
