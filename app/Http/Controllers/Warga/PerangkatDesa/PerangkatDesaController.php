<?php

namespace App\Http\Controllers\Warga\PerangkatDesa;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDesa;

class PerangkatDesaController extends Controller
{
    public function index()
    {
        // Kepala desa (urutan = 1)
        $kepalaDesa = PerangkatDesa::where('urutan', 1)->first();

        // Perangkat lain selain kepala desa
        $perangkatLain = PerangkatDesa::where('urutan', '!=', 1)
            ->orderBy('urutan')
            ->get();

        return view('warga.perangkatdesa.index', compact('kepalaDesa', 'perangkatLain'));
    }
}
