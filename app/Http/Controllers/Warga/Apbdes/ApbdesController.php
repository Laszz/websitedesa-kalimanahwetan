<?php

namespace App\Http\Controllers\Warga\Apbdes;

use App\Http\Controllers\Controller;
use App\Models\TahunAnggaran;
use App\Models\SumberDana;
use App\Models\BidangAnggaran;
use App\Models\PengalokasianDana;
use App\Models\RealisasiBulanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApbdesController extends Controller
{
    // Halaman utama Transparasi APBDes
    public function index()
    {
        $tahunAktif = TahunAnggaran::aktif()
            ->withSum('sumberDanas as total_anggaran_sum', 'nominal_awal')
            ->withSum('sumberDanas as total_realisasi_sum', 'nominal_terpakai')
            ->first();

        if (!$tahunAktif) {
            $tahunAktif = TahunAnggaran::latest()->first();
        }

        $sumberDanas = collect();

        if ($tahunAktif) {
            $sumberDanas = SumberDana::where('tahun_anggaran_id', $tahunAktif->id)
                ->with('tahunAnggaran')
                ->get();
        }

        $totalAnggaran = $tahunAktif?->total_anggaran ?? 0;
        $totalRealisasi = $tahunAktif?->total_realisasi ?? 0;

        return view('warga.apbdes.index', compact('tahunAktif', 'sumberDanas', 'totalAnggaran', 'totalRealisasi'));
    }

    // Detail Sumber Dana per jenis
    public function sumberDana()
    {
        $tahunAktif = TahunAnggaran::aktif()->first()
            ?? TahunAnggaran::latest()->first();

        $sumberDanas = SumberDana::when($tahunAktif, function ($q) use ($tahunAktif) {
                return $q->where('tahun_anggaran_id', $tahunAktif->id);
            })
            ->with([
                'tahunAnggaran',
                'pengalokasians' => fn($q) => $q->disetujui(),
            ])
            ->get()
            ->groupBy('jenis');

        return view('warga.apbdes.sumberdana', compact('sumberDanas', 'tahunAktif'));
    }

    // Detail Pengalokasian Dana per bidang
    public function pengalokasian()
    {
        $tahunAktif = TahunAnggaran::aktif()->first()
            ?? TahunAnggaran::latest()->first();

        $bidangs = BidangAnggaran::when($tahunAktif, function ($q) use ($tahunAktif) {
                return $q->where('tahun_anggaran_id', $tahunAktif->id);
            })
            ->with([
                'pengalokasians' => function ($q) {
                    $q->disetujui()
                    ->with([
                        'sumberDana',
                        'realisasis' => fn($r) => $r->terverifikasi(),
                    ]);
                },
            ])
            ->get();

        // HITUNG TOTAL REALISASI & ANGGARAN PER BIDANG
        $bidangs->each(function($bidang) {
            // Total anggaran = sum nominal pengalokasian yang disetujui
            $bidang->total_anggaran = $bidang->pengalokasians->sum('nominal');
            
            // Total realisasi = sum nominal_digunakan dari realisasi terverifikasi
            $bidang->total_realisasi = $bidang->pengalokasians->sum(function($alokasi) {
                return $alokasi->realisasis->sum('nominal_digunakan');
            });
            
            // Sisa = anggaran - realisasi
            $bidang->total_sisa = $bidang->total_anggaran - $bidang->total_realisasi;
        });

        return view('warga.apbdes.pengalokasian', compact('bidangs', 'tahunAktif'));
    }

    // Realisasi per triwulan
    public function realisasi()
    {
        $tahunAktif = TahunAnggaran::aktif()->first()
            ?? TahunAnggaran::latest()->first();

        $triwulans = ['I' => 0, 'II' => 0, 'III' => 0, 'IV' => 0];

        if ($tahunAktif) {
            // FIX: Filter by tahun_anggaran_id via join, bukan by tahun langsung
            // Alasan: RealisasiBulanan.tahun bisa beda dengan TahunAnggaran.tahun
            $results = RealisasiBulanan::select('realisasi_bulanans.triwulan', DB::raw('SUM(realisasi_bulanans.nominal_digunakan) as total'))
                ->join('pengalokasian_danas', 'realisasi_bulanans.pengalokasian_dana_id', '=', 'pengalokasian_danas.id')
                ->join('sumber_danas', 'pengalokasian_danas.sumber_dana_id', '=', 'sumber_danas.id')
                ->where('sumber_danas.tahun_anggaran_id', $tahunAktif->id)
                ->where('realisasi_bulanans.status', 'terverifikasi')
                ->groupBy('realisasi_bulanans.triwulan')
                ->pluck('total', 'triwulan');

            foreach ($results as $triwulan => $total) {
                $triwulans[$triwulan] = (float) $total;
            }
        }

        return view('warga.apbdes.realisasi', compact('tahunAktif', 'triwulans'));
    }

    // Detail kegiatan
    public function detail($id)
    {
        $pengalokasian = PengalokasianDana::with([
                'sumberDana',
                'bidangAnggaran',
                'realisasis' => function ($query) {
                    $query->terverifikasi()
                          ->orderBy('tahun', 'desc')
                          ->orderBy('bulan', 'desc');
                }
            ])
            ->findOrFail($id);

        return view('warga.apbdes.detail', compact('pengalokasian'));
    }
}