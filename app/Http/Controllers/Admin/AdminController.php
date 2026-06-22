<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PendudukRequest;
use App\Models\Berita;
use App\Models\AduanWarga;
use App\Models\Agenda;
use App\Models\PenerimaBantuan;
use App\Models\JenisBantuan;
use App\Models\TahunAnggaran;
use App\Models\RealisasiBulanan;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // === STAT CARDS ROW 1 ===
        $totalWarga = User::where('role', 'warga')->count();
        $layananDiproses = PendudukRequest::where('status', 'pending')->count();
        $layananSelesai = PendudukRequest::where('status', 'selesai')->count();
        $beritaAktif = Berita::count();

        // === STAT CARDS ROW 2 ===
        $totalPenerimaBantuan = PenerimaBantuan::count();
        $bantuanAktif = PenerimaBantuan::where('status', 'aktif')->count();
        $totalJenisBantuan = JenisBantuan::count();

        // === AGENDA STATS ===
        $agendaBulanIni = Agenda::whereMonth('mulai', now()->month)
            ->whereYear('mulai', now()->year)
            ->count();
        $agendaMendatang = Agenda::where('mulai', '>=', now())
            ->where('status', 'aktif')
            ->orderBy('mulai', 'asc')
            ->take(5)
            ->get();

        // === ADUAN STATS ===
        $aduanPending = AduanWarga::where('status', 'pending')->count();
        $aduanTerbaru = AduanWarga::where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        // === APBDes STATS ===
        $tahunAktif = TahunAnggaran::where('tahun', now()->year)->first();
        $totalAnggaran = $tahunAktif ? (float) $tahunAktif->total_anggaran : 0;
        $totalRealisasi = $tahunAktif ? (float) $tahunAktif->total_realisasi : 0;
        
        $persenRealisasi = $totalAnggaran > 0 
            ? round(($totalRealisasi / $totalAnggaran) * 100, 2) 
            : 0;

        // === DATA GRAFIK APBDes (per triwulan) ===
        $triwulanLabels = ['Triwulan I', 'Triwulan II', 'Triwulan III', 'Triwulan IV'];
        $triwulanData = [];
        foreach (['I', 'II', 'III', 'IV'] as $tw) {
            $nominal = RealisasiBulanan::where('triwulan', $tw)
                ->where('tahun', now()->year)
                ->where('status', 'terverifikasi')
                ->sum('nominal_digunakan');
            $triwulanData[] = (float) $nominal;
        }

        // === DATA GRAFIK BANTUAN (per desil) ===
        $desilLabels = [];
        $desilData = [];
        for ($i = 1; $i <= 10; $i++) {
            $desilLabels[] = "Desil $i";
            $desilData[] = PenerimaBantuan::where('desil', $i)
                ->where('status', 'aktif')
                ->count();
        }

        // === PENERIMA BANTUAN TERBARU ===
        $penerimaTerbaru = PenerimaBantuan::with(['warga', 'jenisBantuan'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalWarga',
            'layananDiproses',
            'layananSelesai',
            'beritaAktif',
            'totalPenerimaBantuan',
            'bantuanAktif',
            'totalJenisBantuan',
            'agendaBulanIni',
            'agendaMendatang',
            'aduanPending',
            'aduanTerbaru',
            'totalAnggaran',
            'totalRealisasi',
            'persenRealisasi',
            'triwulanLabels',
            'triwulanData',
            'desilLabels',
            'desilData',
            'penerimaTerbaru'
        ));
    }

    public function visimisi()
    {
        return view('admin.visimisi.index');
    }

    public function sejarahdesa()
    {
        return view('admin.sejarahdesa.index');
    }

    public function datadesa()
    {
        return view('admin.datadesa.index');
    }

    public function perangkatdesa()
    {
        return view('admin.perangkatdesa.index');
    }
}