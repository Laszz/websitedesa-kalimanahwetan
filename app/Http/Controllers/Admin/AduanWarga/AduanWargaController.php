<?php

namespace App\Http\Controllers\Admin\AduanWarga;

use App\Http\Controllers\Controller;
use App\Models\AduanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AduanWargaController extends Controller
{
    public function index()
    {
        $aduan = AduanWarga::latest()->get();
        return view('admin.aduan.index', compact('aduan'));
    }

    public function edit($id)
    {
        $aduan = AduanWarga::findOrFail($id);
        return view('admin.aduan.edit', compact('aduan'));
    }

    public function update(Request $request, $id)
    {
        $aduan = AduanWarga::findOrFail($id);

        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'nama'      => 'nullable|string|max:100',
            'nomor_wa'  => 'required|string|max:15',
            'detail'    => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'alamat'    => 'required|string',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kategori'  => 'nullable|string|max:50',
            'prioritas' => 'nullable|in:normal,penting,darurat',
            'status'    => 'required|in:menunggu,diproses,selesai',
        ]);

        
        $validated['tampilkan'] = $request->boolean('tampilkan');

        if ($request->hasFile('gambar')) {
            if ($aduan->gambar && Storage::disk('public')->exists($aduan->gambar)) {
                Storage::disk('public')->delete($aduan->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('images/foto_aduan_warga', 'public');
        }

        $aduan->update($validated);

        return redirect()->route('admin.aduan.index')->with('success', 'Aduan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $aduan = AduanWarga::findOrFail($id);

        if ($aduan->gambar && Storage::disk('public')->exists($aduan->gambar)) {
            Storage::disk('public')->delete($aduan->gambar);
        }

        $aduan->delete();

        return redirect()->route('admin.aduan.index')->with('success', 'Aduan berhasil dihapus');
    }
}
