<?php

namespace App\Http\Controllers\Warga\PenerimaBantuan;

use App\Http\Controllers\Controller;
use App\Models\PenerimaBantuan;
use App\Models\JenisBantuan;
use Illuminate\Support\Facades\Auth;

class PenerimaBantuanController extends Controller
{

    public function index()
    {
        $warga = Auth::user()->warga;

        if (!$warga) {
            return redirect()
                ->route('warga.dashboard')
                ->with('error', 'Data warga tidak ditemukan. Silakan lengkapi profil Anda.');
        }

        $bantuans = PenerimaBantuan::with(['jenisBantuan.tahunAnggaran'])
            ->where('warga_id', $warga->id)
            ->latest()
            ->paginate(10);

        return view('warga.penerimabantuan.index', compact('bantuans'));
    }

    public function show($id)
    {
        $warga = Auth::user()->warga;

        if (!$warga) {
            return redirect()
                ->route('warga.dashboard')
                ->with('error', 'Data warga tidak ditemukan.');
        }

        $bantuan = PenerimaBantuan::with(['jenisBantuan.tahunAnggaran', 'creator'])
            ->where('warga_id', $warga->id)
            ->findOrFail($id);

        return view('warga.penerimabantuan.show', compact('bantuan'));
    }

    // ============================================================
    // PUBLIK — Transparansi (tanpa login)
    // ============================================================

    public function publicIndex()
    {
        $jenisBantuans = JenisBantuan::with(['tahunAnggaran'])
            ->withCount(['penerima as total_penerima' => function ($query) {
                $query->where('status', 'aktif');
            }])
            ->get();

        $statistik = [];
        foreach ($jenisBantuans as $jb) {
            $desilStats = PenerimaBantuan::where('jenis_bantuan_id', $jb->id)
                ->where('status', 'aktif')
                ->selectRaw('desil, COUNT(*) as jumlah')
                ->groupBy('desil')
                ->orderBy('desil')
                ->pluck('jumlah', 'desil');

            $statistik[$jb->id] = [
                'jenis' => $jb,
                'total' => $jb->total_penerima,
                'desil_breakdown' => $desilStats,
            ];
        }

        // FIX: return view public, bukan warga
        return view('public.penerimabantuan.index', compact('jenisBantuans', 'statistik'));
    }

    public function publicShow($jenisBantuanId)
    {
        $jenisBantuan = JenisBantuan::with('tahunAnggaran')
            ->findOrFail($jenisBantuanId);

        $penerima = PenerimaBantuan::with('warga')
            ->where('jenis_bantuan_id', $jenisBantuanId)
            ->where('status', 'aktif')
            ->latest()
            ->paginate(20);

        $statistikDesil = PenerimaBantuan::where('jenis_bantuan_id', $jenisBantuanId)
            ->where('status', 'aktif')
            ->selectRaw('desil, COUNT(*) as jumlah')
            ->groupBy('desil')
            ->orderBy('desil')
            ->pluck('jumlah', 'desil');

        return view('public.penerimabantuan.show', compact('jenisBantuan', 'penerima', 'statistikDesil'));
    }
}