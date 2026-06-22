<?php

namespace App\Http\Controllers\Warga\Galeri;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Tampilkan daftar galeri untuk publik/warga
     */
    public function index(Request $request)
    {
        $query = Galeri::query();

        // Filter pencarian berdasarkan judul / deskripsi
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // Hanya galeri yang ditampilkan
        $galeri = $query->where('tampilkan', 'tampilkan')
                        ->orderBy('tanggal', 'desc')
                        ->paginate(12);

        return view('warga.galeri.index', compact('galeri'));
    }
}
