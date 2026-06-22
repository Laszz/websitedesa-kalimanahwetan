<?php
// app/Http/Controllers/Warga/WargaController.php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Warga\Warga;
use App\Models\Berita;
use App\Models\AduanWarga;
use App\Models\PenerimaBantuan;
use App\Models\Agenda;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function dashboard()
    {
        $warga = Warga::where('user_id', Auth::id())->first();

        $bantuanStats = [
            'total' => 0,
            'aktif' => 0,
            'terbaru' => null,
        ];

        if ($warga) {
            $bantuans = PenerimaBantuan::with('jenisBantuan')
                ->where('warga_id', $warga->id)
                ->latest()
                ->get();

            $bantuanStats = [
                'total' => $bantuans->count(),
                'aktif' => $bantuans->where('status', 'aktif')->count(),
                'terbaru' => $bantuans->first(),
            ];
        }

        $beritas = Berita::orderBy('created_at', 'desc')->limit(4)->get();
        $aduans = AduanWarga::orderBy('created_at', 'desc')->limit(4)->get();
        
        // TAMBAH: Agenda mendatang dari database
        $agendas = Agenda::mendatang()
            ->where('status', 'aktif')
            ->limit(5)
            ->get();

        return view('warga.dashboard', compact('warga', 'bantuanStats', 'beritas', 'aduans', 'agendas'));
    }
}