<?php

namespace App\Http\Controllers\Admin\PenerimaBantuan;

use App\Http\Controllers\Controller;
use App\Models\PenerimaBantuan;
use App\Models\JenisBantuan;
use App\Models\Warga\Warga;
use App\Exports\PenerimaBantuanExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Events\PenerimaBantuanDitambahkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenerimaBantuanController extends Controller
{
    public function index(Request $request)
    {
        $query = PenerimaBantuan::with(['warga', 'jenisBantuan', 'creator']);

        if ($request->filled('desil')) {
            $query->byDesil($request->desil);
        }

        if ($request->filled('jenis_bantuan_id')) {
            $query->byJenis($request->jenis_bantuan_id);
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('keyword')) {
            $query->searchWarga($request->keyword);
        }

        $penerimaBantuans = $query->latest()->get();
        $jenisBantuans = JenisBantuan::all();
        $desilList = range(1, 10);

        return view('admin.penerimabantuan.index', compact('penerimaBantuans', 'jenisBantuans', 'desilList'));
    }

    public function create()
    {
        $wargas = Warga::all();
        $jenisBantuans = JenisBantuan::all();
        $desilList = range(1, 10);

        return view('admin.penerimabantuan.create', compact('wargas', 'jenisBantuans', 'desilList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jenis_bantuan_id' => 'required|exists:jenis_bantuans,id',
            'desil' => 'required|integer|min:1|max:10',
            'status' => 'required|in:aktif,nonaktif,dicabut',
            'tanggal_terima' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $exists = PenerimaBantuan::where('warga_id', $request->warga_id)
            ->where('jenis_bantuan_id', $request->jenis_bantuan_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Warga ini sudah terdaftar untuk jenis bantuan ini.')->withInput();
        }

        $penerima = PenerimaBantuan::create([
            'warga_id' => $request->warga_id,
            'jenis_bantuan_id' => $request->jenis_bantuan_id,
            'desil' => $request->desil,
            'status' => $request->status,
            'tanggal_terima' => $request->tanggal_terima,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id(),
        ]);

        event(new PenerimaBantuanDitambahkan($penerima));

        return redirect()->route('admin.penerimabantuan.index')->with('success', 'Penerima bantuan berhasil ditambahkan');
    }

    public function show($id)
    {
        $penerima = PenerimaBantuan::with(['warga', 'jenisBantuan', 'creator'])->findOrFail($id);
        return view('admin.penerimabantuan.show', compact('penerima'));
    }

    public function edit($id)
    {
        $penerima = PenerimaBantuan::findOrFail($id);
        $wargas = Warga::all();
        $jenisBantuans = JenisBantuan::all();
        $desilList = range(1, 10);

        return view('admin.penerimabantuan.edit', compact('penerima', 'wargas', 'jenisBantuans', 'desilList'));
    }

    public function update(Request $request, $id)
    {
        $penerima = PenerimaBantuan::findOrFail($id);

        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'jenis_bantuan_id' => 'required|exists:jenis_bantuans,id',
            'desil' => 'required|integer|min:1|max:10',
            'status' => 'required|in:aktif,nonaktif,dicabut',
            'tanggal_terima' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $exists = PenerimaBantuan::where('warga_id', $request->warga_id)
            ->where('jenis_bantuan_id', $request->jenis_bantuan_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Warga ini sudah terdaftar untuk jenis bantuan ini.')->withInput();
        }

        $penerima->update([
            'warga_id' => $request->warga_id,
            'jenis_bantuan_id' => $request->jenis_bantuan_id,
            'desil' => $request->desil,
            'status' => $request->status,
            'tanggal_terima' => $request->tanggal_terima,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.penerimabantuan.index')->with('success', 'Penerima bantuan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $penerima = PenerimaBantuan::findOrFail($id);
        $penerima->delete();

        return redirect()->route('admin.penerimabantuan.index')->with('success', 'Penerima bantuan berhasil dihapus');
    }

    // ← TAMBAH METHOD INI
    public function export(Request $request)
    {
        $query = PenerimaBantuan::with(['warga', 'jenisBantuan', 'creator']);

        if ($request->filled('desil')) {
            $query->byDesil($request->desil);
        }

        if ($request->filled('jenis_bantuan_id')) {
            $query->byJenis($request->jenis_bantuan_id);
        }

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('keyword')) {
            $query->searchWarga($request->keyword);
        }

        $penerimaBantuans = $query->latest()->get();

        $filename = 'Rekap_Penerima_Bantuan_' . now()->format('d-m-Y_H-i-s') . '.xlsx';

        return Excel::download(new PenerimaBantuanExport($penerimaBantuans), $filename);
    }
}