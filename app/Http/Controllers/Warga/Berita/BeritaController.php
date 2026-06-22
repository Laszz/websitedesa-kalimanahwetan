<?php

namespace App\Http\Controllers\Warga\Berita;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Halaman daftar berita untuk publik/warga
     */
    public function index()
    {
        $beritas = Berita::where('tampilkan', 'tampilkan')
                    ->latest()
                    ->paginate(6); // default 6 per halaman

        return view('warga.berita.index', compact('beritas'));
    }

    /**
     * Detail berita publik
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
                    ->where('tampilkan', 'tampilkan')
                    ->firstOrFail();

        return view('warga.berita.show', compact('berita'));
    }

    /**
     * API Search realtime (AJAX)
     */
    public function search(Request $request)
    {
        $q = $request->get('q', '');
        $beritas = Berita::where('tampilkan', 'tampilkan')
                    ->where(function ($query) use ($q) {
                        $query->where('judul', 'like', "%$q%")
                              ->orWhere('ringkasan', 'like', "%$q%");
                    })
                    ->latest()
                    ->take(10) // batasi hasil biar ringan
                    ->get(['judul','slug','tanggal','ringkasan','gambar']);

        return response()->json($beritas);
    }
}
