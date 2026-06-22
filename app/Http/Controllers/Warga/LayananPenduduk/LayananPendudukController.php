<?php

namespace App\Http\Controllers\Warga\LayananPenduduk;

use App\Http\Controllers\Controller;
use App\Models\LayananPenduduk;
use App\Models\PendudukRequirement;

class LayananPendudukController extends Controller
{
    // HALAMAN DAFTAR LAYANAN UNTUK WARGA
    public function index()
    {
        $layanan = LayananPenduduk::orderBy('nama_layanan', 'asc')->get();

        return view('warga.layananpenduduk.index', compact('layanan'));
    }

    // HALAMAN DETAIL + SYARAT LAYANAN
    public function show($id)
    {
        $layanan = LayananPenduduk::findOrFail($id);
        $requirements = PendudukRequirement::where('layanan_id', $id)->get();

        return view('warga.layananpenduduk.show', compact('layanan', 'requirements'));
    }
}
