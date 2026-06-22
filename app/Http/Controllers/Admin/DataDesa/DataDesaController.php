<?php

namespace App\Http\Controllers\Admin\DataDesa;

use App\Http\Controllers\Controller;
use App\Models\Warga\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataDesaController extends Controller
{
    public function index(Request $request)
    {
        // Total penduduk
        $jumlahPenduduk = Warga::count();

        // Jumlah KK unik
        $jumlahKK = Warga::distinct('kk')->count('kk');

        // Jumlah RT dan RW unik
        $jumlahRT = Warga::distinct('rt')->count('rt');
        $jumlahRW = Warga::distinct('rw')->count('rw');

        // Hitung gender
        $jumlahLaki = Warga::where(function ($q) {
            $q->where('jenis_kelamin', 'L')
              ->orWhere('jenis_kelamin', 'l')
              ->orWhere('jenis_kelamin', 'laki')
              ->orWhere('jenis_kelamin', 'Laki-laki')
              ->orWhere('jenis_kelamin', 'laki-laki')
              ->orWhereRaw("LOWER(jenis_kelamin) LIKE '%laki%'");
        })->count();

        $jumlahPerempuan = Warga::where(function ($q) {
            $q->where('jenis_kelamin', 'P')
              ->orWhere('jenis_kelamin', 'p')
              ->orWhere('jenis_kelamin', 'perempuan')
              ->orWhere('jenis_kelamin', 'Perempuan')
              ->orWhereRaw("LOWER(jenis_kelamin) LIKE '%peremp%'");
        })->count();

        // Rekap jumlah penduduk per RT/RW
        $rtRw = Warga::select('rt', 'rw', DB::raw('COUNT(*) as total'))
            ->groupBy('rt', 'rw')
            ->orderBy('rw')
            ->orderBy('rt')
            ->get();

        // Tabel warga (pagination)
        $wargasTable = Warga::orderBy('rw')
            ->orderBy('rt')
            ->orderBy('name')
            ->paginate(25);

        return view('admin.datadesa.index', [
            'jumlahPenduduk' => $jumlahPenduduk,
            'jumlahKK' => $jumlahKK,
            'jumlahRT' => $jumlahRT,
            'jumlahRW' => $jumlahRW,
            'jumlahLaki' => $jumlahLaki,
            'jumlahPerempuan' => $jumlahPerempuan,
            'rtRw' => $rtRw,
            'wargasTable' => $wargasTable
        ]);
    }
}