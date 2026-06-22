<?php

namespace App\Http\Controllers\Admin\Apbdes;

use App\Http\Controllers\Controller;
use App\Models\TahunAnggaran;
use App\Models\SumberDana;
use App\Models\BidangAnggaran;
use App\Models\PengalokasianDana;
use App\Models\RealisasiBulanan;
use App\Models\PerubahanAnggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApbdesController extends Controller
{

    // ============================================
    // DASHBOARD / INDEX
    // ============================================

    public function adminIndex()
    {
        $tahunAnggarans = TahunAnggaran::withCount(['sumberDanas', 'bidangAnggarans'])
            ->latest()
            ->paginate(10);

        $tahunAktif = TahunAnggaran::aktif()->first();

        $stats = [
            'total_tahun' => TahunAnggaran::count(),
            'tahun_aktif' => $tahunAktif ? $tahunAktif->tahun : '-',
            'total_anggaran_keseluruhan' => TahunAnggaran::sum('total_anggaran'),
            'total_realisasi_keseluruhan' => TahunAnggaran::sum('total_realisasi'),
        ];

        return view('admin.apbdes.index', compact('tahunAnggarans', 'tahunAktif', 'stats'));
    }


    // ============================================
    // TAHUN ANGGARAN
    // ============================================

    public function indexTahun()
    {
        $tahunAnggarans = TahunAnggaran::withCount(['sumberDanas', 'bidangAnggarans'])
            ->latest()
            ->paginate(10);

        return view('admin.apbdes.tahunanggaran.index', compact('tahunAnggarans'));
    }

    public function createTahun()
    {
        return view('admin.apbdes.tahunanggaran.create');
    }

    public function storeTahun(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|unique:tahun_anggarans,tahun',
            'status' => 'in:draft,aktif,ditutup',
        ]);

        $tahun = DB::transaction(function () use ($validated) {
            $tahun = TahunAnggaran::create($validated);

            $bidangDefaults = [
                ['1', 'Bid. Penyelenggaraan Pemerintahan Desa'],
                ['2', 'Bid. Pelaksanaan Pembangunan Desa'],
                ['3', 'Bid. Pembinaan Kemasyarakatan'],
                ['4', 'Bid. Pemberdayaan Masyarakat'],
                ['5', 'Bid. Penanggulangan Bencana, Darurat & Mendesak'],
                ['6', 'Bid. Lainnya'],
            ];

            foreach ($bidangDefaults as $bidang) {
                BidangAnggaran::create([
                    'tahun_anggaran_id' => $tahun->id,
                    'kode_bidang' => $bidang[0],
                    'nama_bidang' => $bidang[1],
                ]);
            }

            return $tahun;
        });

        return redirect()->route('admin.apbdes.tahun.index')
            ->with('success', "Tahun anggaran {$tahun->tahun} berhasil dibuat dengan 6 bidang default.");
    }

    public function showTahun($id)
    {
        $tahun = TahunAnggaran::with([
            'sumberDanas' => fn($q) => $q->withTahun(),
            'bidangAnggarans.pengalokasians' => function ($q) {
                $q->disetujui()
                ->with([
                    'realisasis' => fn($r) => $r->terverifikasi(),
                    'sumberDana',
                ]);
            },
        ])->findOrFail($id);

        // Hitung total realisasi per bidang di controller (lebih efisien)
        $tahun->bidangAnggarans->each(function ($bidang) {
            $bidang->total_anggaran = $bidang->pengalokasians->sum('nominal');
            $bidang->total_realisasi = $bidang->pengalokasians->sum(function ($alokasi) {
                return $alokasi->realisasis->sum('nominal_digunakan');
            });
            $bidang->total_sisa = $bidang->total_anggaran - $bidang->total_realisasi;
            $bidang->total_kegiatan = $bidang->pengalokasians->count();
        });

        return view('admin.apbdes.tahunanggaran.show', compact('tahun'));
    }

    public function editTahun($id)
    {
        $tahun = TahunAnggaran::findOrFail($id);
        return view('admin.apbdes.tahunanggaran.edit', compact('tahun'));
    }

    public function updateTahun(Request $request, $id)
    {
        $tahun = TahunAnggaran::findOrFail($id);

        $validated = $request->validate([
            'tahun' => 'required|integer|unique:tahun_anggarans,tahun,' . $tahun->id,
            'status' => 'required|in:draft,aktif,ditutup',
        ]);

        DB::transaction(function () use ($tahun, $validated) {
            if ($validated['status'] === 'aktif') {
                TahunAnggaran::where('id', '!=', $tahun->id)
                    ->where('status', 'aktif')
                    ->update(['status' => 'ditutup']);
            }

            $tahun->update($validated);
        });

        return redirect()->route('admin.apbdes.tahun.index')
            ->with('success', 'Tahun anggaran berhasil diperbarui.');
    }

    public function destroyTahun($id)
    {
        $tahun = TahunAnggaran::withCount('sumberDanas')->findOrFail($id);

        if ($tahun->sumber_danas_count > 0) {
            return redirect()->back()
                ->with('error', 'Tidak bisa menghapus tahun yang masih memiliki sumber dana.');
        }

        DB::transaction(function () use ($tahun) {
            $tahun->bidangAnggarans()->delete();
            $tahun->delete();
        });

        return redirect()->route('admin.apbdes.tahun.index')
            ->with('success', 'Tahun anggaran berhasil dihapus.');
    }


    // ============================================
    // SUMBER DANA
    // ============================================

    public function indexSumberDana()
    {
        $sumberDanas = SumberDana::with(['tahunAnggaran', 'creator'])
            ->latest()
            ->paginate(15);

        return view('admin.apbdes.sumberdana.index', compact('sumberDanas'));
    }

    public function createSumberDana()
    {
        $tahunAnggarans = TahunAnggaran::aktif()->get();
        return view('admin.apbdes.sumberdana.create', compact('tahunAnggarans'));
    }

    public function storeSumberDana(Request $request)
    {
        $validated = $request->validate([
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
            'jenis' => 'required|in:apbn,apbd_provinsi,bkk,pad,add,dd,silpa,lainnya',
            'nama_sumber' => 'required|string|max:255',
            'nominal_awal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $validated['created_by'] = auth()->id();

        $sumber = DB::transaction(function () use ($validated) {
            $sumber = SumberDana::create($validated);
            $sumber->tahunAnggaran->recalculate();
            return $sumber;
        });

        return redirect()->route('admin.apbdes.sumberdana.index')
            ->with('success', 'Sumber dana berhasil ditambahkan.');
    }

    public function showSumberDana($id)
    {
        $sumber = SumberDana::with([
            'tahunAnggaran',
            'pengalokasians.bidangAnggaran',
            'realisasis' => fn($q) => $q->terverifikasi(),
        ])->findOrFail($id);

        return view('admin.apbdes.sumberdana.show', compact('sumber'));
    }

    public function editSumberDana($id)
    {
        $sumber = SumberDana::with('tahunAnggaran')->findOrFail($id);
        $tahunAnggarans = TahunAnggaran::aktif()->get();
        return view('admin.apbdes.sumberdana.edit', compact('sumber', 'tahunAnggarans'));
    }

    public function updateSumberDana(Request $request, $id)
    {
        $sumber = SumberDana::with('tahunAnggaran')->findOrFail($id);

        $validated = $request->validate([
            'tahun_anggaran_id' => 'required|exists:tahun_anggarans,id',
            'jenis' => 'required|in:apbn,apbd_provinsi,bkk,pad,add,dd,silpa,lainnya',
            'nama_sumber' => 'required|string|max:255',
            'nominal_awal' => 'required|numeric|min:' . $sumber->nominal_terpakai,
            'keterangan' => 'nullable|string',
            'alasan_perubahan' => 'required|string|min:10',
        ]);

        $nilaiLama = $sumber->nominal_awal;
        $tahunLama = $sumber->tahun_anggaran_id;

        DB::transaction(function () use ($sumber, $validated, $nilaiLama, $tahunLama) {
            PerubahanAnggaran::log(
                $sumber,
                'nominal_awal',
                $nilaiLama,
                $validated['nominal_awal'],
                $validated['alasan_perubahan'],
                auth()->id()
            );

            $sumber->update([
                'tahun_anggaran_id' => $validated['tahun_anggaran_id'],
                'jenis' => $validated['jenis'],
                'nama_sumber' => $validated['nama_sumber'],
                'nominal_awal' => $validated['nominal_awal'],
                'keterangan' => $validated['keterangan'],
            ]);

            if ($tahunLama != $validated['tahun_anggaran_id']) {
                TahunAnggaran::find($tahunLama)?->recalculate();
            }

            $sumber->tahunAnggaran->recalculate();
        });

        return redirect()->route('admin.apbdes.sumberdana.index')
            ->with('success', 'Sumber dana berhasil diperbarui.');
    }

    public function destroySumberDana($id)
    {
        $sumber = SumberDana::withCount('pengalokasians')->findOrFail($id);

        if ($sumber->pengalokasians_count > 0) {
            return redirect()->back()
                ->with('error', 'Tidak bisa menghapus sumber dana yang sudah memiliki pengalokasian.');
        }

        $tahun = $sumber->tahunAnggaran;

        DB::transaction(function () use ($sumber, $tahun) {
            RealisasiBulanan::where('sumber_dana_id', $sumber->id)->delete();
            $sumber->delete();
            $tahun->recalculate();
        });

        return redirect()->route('admin.apbdes.sumberdana.index')
            ->with('success', 'Sumber dana berhasil dihapus.');
    }


    // ============================================
    // PENGALOKASIAN
    // ============================================

    public function indexPengalokasian()
    {
        $pengalokasians = PengalokasianDana::withRelations()
            ->latest()
            ->paginate(15);

        return view('admin.apbdes.pengalokasian.index', compact('pengalokasians'));
    }

    public function createPengalokasian()
    {
        $sumberDanas = SumberDana::tersedia()->withTahun()->get();
        $bidangs = BidangAnggaran::whereIn('tahun_anggaran_id', $sumberDanas->pluck('tahun_anggaran_id'))->get();

        return view('admin.apbdes.pengalokasian.create', compact('sumberDanas', 'bidangs'));
    }

    public function storePengalokasian(Request $request)
    {
        $validated = $request->validate([
            'sumber_dana_id' => 'required|exists:sumber_danas,id',
            'bidang_anggaran_id' => 'required|exists:bidang_anggarans,id',
            'nama_kegiatan' => 'required|string|max:255',
            'detail_kegiatan' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
            'triwulan_target' => 'nullable|in:I,II,III,IV',
        ]);

        $sumber = SumberDana::findOrFail($validated['sumber_dana_id']);

        $sisa = $sumber->sisa;

        if ($validated['nominal'] > $sisa) {
            return redirect()->back()
                ->with('error', "Nominal melebihi sisa sumber dana. Sisa: Rp " . number_format($sisa, 0, ',', '.'))
                ->withInput();
        }

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'direncanakan';

        // FIX: Tidak recalculate di sini. Recalculate hanya saat approve/reject/revision/destroy.
        // Alasan: pengalokasian baru status 'direncanakan', belum disetujui.
        PengalokasianDana::create($validated);

        return redirect()->route('admin.apbdes.pengalokasian.index')
            ->with('success', 'Pengalokasian dana berhasil ditambahkan. Menunggu persetujuan.');
    }

    public function showPengalokasian($id)
    {
        $pengalokasian = PengalokasianDana::withRelations()->findOrFail($id);
        return view('admin.apbdes.pengalokasian.show', compact('pengalokasian'));
    }

    public function editPengalokasian($id)
    {
        $pengalokasian = PengalokasianDana::with(['sumberDana.tahunAnggaran', 'bidangAnggaran'])->findOrFail($id);
        $sumberDanas = SumberDana::tersedia()->withTahun()->get();

        // FIX: Include sumber dana saat ini meski sudah habis/terpakai penuh
        if (!$sumberDanas->contains('id', $pengalokasian->sumber_dana_id)) {
            $sumberDanas->push($pengalokasian->sumberDana);
        }

        $bidangs = BidangAnggaran::where('tahun_anggaran_id', $pengalokasian->sumberDana->tahun_anggaran_id)->get();

        return view('admin.apbdes.pengalokasian.edit', compact('pengalokasian', 'sumberDanas', 'bidangs'));
    }

    public function updatePengalokasian(Request $request, $id)
    {
        $pengalokasian = PengalokasianDana::with(['sumberDana.tahunAnggaran', 'bidangAnggaran'])->findOrFail($id);

        $validated = $request->validate([
            'sumber_dana_id' => 'required|exists:sumber_danas,id',
            'bidang_anggaran_id' => 'required|exists:bidang_anggarans,id',
            'nama_kegiatan' => 'required|string|max:255',
            'detail_kegiatan' => 'nullable|string',
            'nominal' => 'required|numeric|min:0',
            'triwulan_target' => 'nullable|in:I,II,III,IV',
            'status' => 'required|in:direncanakan,disetujui,ditolak,revisi',
            'alasan_perubahan' => 'required|string|min:10',
        ]);

        $nilaiLama = $pengalokasian->nominal;
        $sumberLama = $pengalokasian->sumber_dana_id;
        $bidangLama = $pengalokasian->bidang_anggaran_id;
        $statusLama = $pengalokasian->status;

        DB::transaction(function () use ($pengalokasian, $validated, $nilaiLama, $sumberLama, $bidangLama, $statusLama) {
            if ($nilaiLama != $validated['nominal']) {
                PerubahanAnggaran::log(
                    $pengalokasian,
                    'nominal',
                    $nilaiLama,
                    $validated['nominal'],
                    $validated['alasan_perubahan'],
                    auth()->id()
                );
            }

            $pengalokasian->update([
                'sumber_dana_id' => $validated['sumber_dana_id'],
                'bidang_anggaran_id' => $validated['bidang_anggaran_id'],
                'nama_kegiatan' => $validated['nama_kegiatan'],
                'detail_kegiatan' => $validated['detail_kegiatan'],
                'nominal' => $validated['nominal'],
                'triwulan_target' => $validated['triwulan_target'],
                'status' => $validated['status'],
            ]);

            $statusBaru = $validated['status'];
            $wasApproved = $statusLama === 'disetujui';
            $isApproved = $statusBaru === 'disetujui';

            // FIX: Recalculate hanya jika ada perubahan status yang mempengaruhi anggaran
            $perluRecalculate = ($wasApproved !== $isApproved)
                || ($wasApproved && $isApproved && ($sumberLama != $validated['sumber_dana_id'] || $bidangLama != $validated['bidang_anggaran_id']));

            if ($perluRecalculate) {
                // Recalculate sumber lama kalau pindah
                if ($sumberLama != $validated['sumber_dana_id']) {
                    SumberDana::find($sumberLama)?->recalculate();
                }

                // Recalculate bidang lama kalau pindah
                if ($bidangLama != $validated['bidang_anggaran_id']) {
                    BidangAnggaran::find($bidangLama)?->recalculate();
                }

                // Recalculate yang baru
                $pengalokasian->sumberDana->recalculate();
                $pengalokasian->bidangAnggaran->recalculate();
                $pengalokasian->sumberDana->tahunAnggaran->recalculate();
            }
        });

        return redirect()->route('admin.apbdes.pengalokasian.index')
            ->with('success', 'Pengalokasian berhasil diperbarui.');
    }

    public function destroyPengalokasian($id)
    {
        $pengalokasian = PengalokasianDana::with(['sumberDana.tahunAnggaran', 'bidangAnggaran'])->findOrFail($id);

        if ($pengalokasian->realisasis()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Tidak bisa menghapus pengalokasian yang sudah memiliki realisasi.');
        }

        $sumber = $pengalokasian->sumberDana;
        $bidang = $pengalokasian->bidangAnggaran;

        DB::transaction(function () use ($pengalokasian, $sumber, $bidang) {
            $pengalokasian->delete();
            $sumber->recalculate();
            $bidang->recalculate();
            $sumber->tahunAnggaran->recalculate();
        });

        return redirect()->route('admin.apbdes.pengalokasian.index')
            ->with('success', 'Pengalokasian berhasil dihapus.');
    }

    // --- APPROVAL METHODS ---

    public function approvePengalokasian($id)
    {
        $pengalokasian = PengalokasianDana::with('sumberDana.tahunAnggaran')->findOrFail($id);

        if (!$pengalokasian->canApprove()) {
            return redirect()->back()
                ->with('error', 'Pengalokasian tidak bisa disetujui. Sisa dana tidak mencukupi.');
        }

        $pengalokasian->approve();

        return redirect()->route('admin.apbdes.pengalokasian.index')
            ->with('success', 'Pengalokasian berhasil disetujui.');
    }

    public function rejectPengalokasian($id)
    {
        $pengalokasian = PengalokasianDana::findOrFail($id);
        $pengalokasian->reject();

        return redirect()->route('admin.apbdes.pengalokasian.index')
            ->with('success', 'Pengalokasian ditolak.');
    }

    public function requestRevisionPengalokasian($id)
    {
        $pengalokasian = PengalokasianDana::with('sumberDana.tahunAnggaran')->findOrFail($id);
        $pengalokasian->requestRevision();

        return redirect()->route('admin.apbdes.pengalokasian.index')
            ->with('success', 'Pengalokasian diminta revisi.');
    }


    // ============================================
    // REALISASI
    // ============================================

    public function indexRealisasi()
    {
        $realisasis = RealisasiBulanan::withRelations()
            ->latest()
            ->paginate(20);

        return view('admin.apbdes.realisasi.index', compact('realisasis'));
    }

    public function createRealisasi()
    {
        $pengalokasians = PengalokasianDana::disetujui()->withRelations()->get();
        return view('admin.apbdes.realisasi.create', compact('pengalokasians'));
    }

    public function storeRealisasi(Request $request)
    {
        $validated = $request->validate([
            'pengalokasian_dana_id' => 'required|exists:pengalokasian_danas,id',
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|min:1|max:12',
            'nominal_digunakan' => 'required|numeric|min:0',
            'keterangan_pemakaian' => 'required|string',
            'bukti_transaksi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $pengalokasian = PengalokasianDana::findOrFail($validated['pengalokasian_dana_id']);

        $sisa = $pengalokasian->sisa;

        if ($validated['nominal_digunakan'] > $sisa) {
            return redirect()->back()
                ->with('error', "Nominal melebihi sisa alokasi kegiatan. Sisa: Rp " . number_format($sisa, 0, ',', '.'))
                ->withInput();
        }

        if ($request->hasFile('bukti_transaksi')) {
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')
                ->store('bukti-transaksi', 'public');
        }

        $validated['sumber_dana_id'] = $pengalokasian->sumber_dana_id;
        $validated['status'] = 'pending';
        $validated['created_by'] = auth()->id();

        DB::transaction(function () use ($validated, $pengalokasian) {
            RealisasiBulanan::create($validated);
            $pengalokasian->sumberDana->recalculate();
            $pengalokasian->bidangAnggaran->recalculate();
            $pengalokasian->sumberDana->tahunAnggaran->recalculate();
        });

        return redirect()->route('admin.apbdes.realisasi.index')
            ->with('success', 'Realisasi berhasil dicatat, menunggu verifikasi.');
    }

    public function showRealisasi($id)
    {
        $realisasi = RealisasiBulanan::withRelations()->findOrFail($id);
        return view('admin.apbdes.realisasi.show', compact('realisasi'));
    }

    public function editRealisasi($id)
    {
        $realisasi = RealisasiBulanan::with('pengalokasian')->findOrFail($id);
        $pengalokasians = PengalokasianDana::disetujui()->get();
        return view('admin.apbdes.realisasi.edit', compact('realisasi', 'pengalokasians'));
    }

    public function updateRealisasi(Request $request, $id)
    {
        $realisasi = RealisasiBulanan::with('pengalokasian')->findOrFail($id);

        $validated = $request->validate([
            'pengalokasian_dana_id' => 'required|exists:pengalokasian_danas,id',
            'tahun' => 'required|integer',
            'bulan' => 'required|integer|min:1|max:12',
            'nominal_digunakan' => 'required|numeric|min:0',
            'keterangan_pemakaian' => 'required|string',
            'bukti_transaksi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $pengalokasian = PengalokasianDana::findOrFail($validated['pengalokasian_dana_id']);

        $sisa = $pengalokasian->sisa + $realisasi->nominal_digunakan;

        if ($validated['nominal_digunakan'] > $sisa) {
            return redirect()->back()
                ->with('error', "Nominal melebihi sisa alokasi kegiatan. Sisa: Rp " . number_format($sisa, 0, ',', '.'))
                ->withInput();
        }

        if ($request->hasFile('bukti_transaksi')) {
            if ($realisasi->bukti_transaksi) {
                Storage::disk('public')->delete($realisasi->bukti_transaksi);
            }
            $validated['bukti_transaksi'] = $request->file('bukti_transaksi')->store('bukti-transaksi', 'public');
        }

        DB::transaction(function () use ($realisasi, $validated, $pengalokasian) {
            $realisasi->update($validated);
            $pengalokasian->sumberDana->recalculate();
            $pengalokasian->bidangAnggaran->recalculate();
            $pengalokasian->sumberDana->tahunAnggaran->recalculate();
        });

        return redirect()->route('admin.apbdes.realisasi.index')
            ->with('success', 'Realisasi berhasil diperbarui.');
    }

    public function showVerifyRealisasi($id)
    {
        $realisasi = RealisasiBulanan::withRelations()->findOrFail($id);
        return view('admin.apbdes.realisasi.verify', compact('realisasi'));
    }

    public function verifyRealisasi(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:terverifikasi,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak|nullable|string',
        ]);

        $realisasi = RealisasiBulanan::with(['pengalokasian.bidangAnggaran', 'sumberDana.tahunAnggaran'])->findOrFail($id);

        if ($validated['status'] === 'terverifikasi' && !$realisasi->canVerify()) {
            return redirect()->back()
                ->with('error', 'Realisasi tidak bisa diverifikasi. Sisa dana tidak mencukupi.');
        }

        DB::transaction(function () use ($realisasi, $validated) {
            if ($validated['status'] === 'terverifikasi') {
                $realisasi->verify(auth()->id());
            } else {
                $realisasi->reject();
            }
        });

        $message = $validated['status'] === 'terverifikasi'
            ? 'Realisasi berhasil diverifikasi.'
            : 'Realisasi ditolak.';

        return redirect()->route('admin.apbdes.realisasi.index')
            ->with('success', $message);
    }

    public function rejectRealisasi($id)
    {
        $realisasi = RealisasiBulanan::with(['pengalokasian.bidangAnggaran', 'sumberDana.tahunAnggaran'])->findOrFail($id);
        $realisasi->reject();

        return redirect()->route('admin.apbdes.realisasi.index')
            ->with('success', 'Realisasi ditolak.');
    }

    public function destroyRealisasi($id)
    {
        $realisasi = RealisasiBulanan::with(['pengalokasian.bidangAnggaran', 'sumberDana.tahunAnggaran'])->findOrFail($id);

        $sumber = $realisasi->sumberDana;
        $bidang = $realisasi->pengalokasian?->bidangAnggaran;
        $tahun = $sumber?->tahunAnggaran;

        DB::transaction(function () use ($realisasi, $sumber, $bidang, $tahun) {
            if ($realisasi->bukti_transaksi) {
                Storage::disk('public')->delete($realisasi->bukti_transaksi);
            }

            $realisasi->delete();
            $sumber?->recalculate();
            $bidang?->recalculate();
            $tahun?->recalculate();
        });

        return redirect()->route('admin.apbdes.realisasi.index')
            ->with('success', 'Realisasi berhasil dihapus.');
    }


    // ============================================
    // EMERGENCY RECALCULATE
    // ============================================

    public function recalculate(Request $request, $type, $id)
    {
        $model = match ($type) {
            'tahun' => TahunAnggaran::findOrFail($id),
            'sumber' => SumberDana::findOrFail($id),
            'bidang' => BidangAnggaran::findOrFail($id),
            'pengalokasian' => PengalokasianDana::findOrFail($id),
            default => abort(404),
        };

        $model->recalculate();

        return redirect()->back()
            ->with('success', "Recalculate {$type} ID {$id} berhasil.");
    }
}