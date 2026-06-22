<?php

namespace App\Http\Controllers\Admin\Berita;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    /**
     * Tampilkan semua berita (admin)
     */
    public function index()
    {
        $beritas = Berita::latest()->paginate(10);
        return view('admin.berita.index', compact('beritas'));
    }

    /**
     * Form tambah berita
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Simpan berita baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tampilkan' => 'required|in:draf,tampilkan',
        ]);

        $gambarPath = $request->file('gambar')->store('images/foto_berita', 'public');

        Berita::create([
            'judul'     => $request->judul,
            'slug'      => Str::slug($request->judul),
            'ringkasan' => $request->ringkasan,
            'deskripsi' => $request->deskripsi,
            'tanggal'   => $request->tanggal,
            'gambar'    => $gambarPath,
            'tampilkan' => $request->tampilkan,
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Detail berita
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)->firstOrFail();
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Form edit berita
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update berita
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required',
            'deskripsi' => 'required',
            'tanggal' => 'required|date',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048',
            'tampilkan' => 'required|in:draf,tampilkan',
        ]);

        $data = $request->only(['judul','ringkasan','deskripsi','tanggal','tampilkan']);
        $data['slug'] = Str::slug($request->judul);

        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('images/foto_berita', 'public');
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Hapus berita
     */
    public function destroy(Berita $berita)
    {
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
