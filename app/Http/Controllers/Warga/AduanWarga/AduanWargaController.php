<?php

namespace App\Http\Controllers\Warga\AduanWarga;

use App\Http\Controllers\Controller;
use App\Models\AduanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AduanWargaController extends Controller
{
    /**
     * Halaman daftar aduan (PUBLIK + WARGA)
     */
    public function index()
    {
        // ✅ PUBLIK: Tampilin SEMUA aduan yang ditampilkan
        // ✅ WARGA LOGIN: Bisa filter milik sendiri (opsional)
        $aduans = AduanWarga::where('tampilkan', true)
            ->latest()
            ->get();

        return view('warga.aduan.index', compact('aduans'));
    }

    /**
     * Halaman buat aduan baru (WARGA LOGIN)
     */
    public function create()
    {
        return view('warga.aduan.create');
    }

    /**
     * Simpan aduan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'     => 'required|string|max:255',
            'nomor_wa'  => 'required|string|regex:/^08[0-9]{8,13}$/',
            'nama'      => 'nullable|string|max:100',
            'detail'    => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpg,jpeg,png|max:10000',
            'alamat'    => 'required|string|max:255',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kategori'  => 'required|string|max:50',
            'prioritas' => 'required|in:normal,penting,darurat',
        ]);

        // ✅ FIX: Kalau login, pakai data user. Kalau gak login, pakai nama dari input
        $validated['user_id'] = Auth::id(); // bisa null kalau gak login
        $validated['nama']    = Auth::check() ? Auth::user()->name : ($validated['nama'] ?? 'Anonim');
        $validated['status']  = 'menunggu';
        $validated['tampilkan'] = true;

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('images/foto_aduan_warga', 'public');
        }

        AduanWarga::create($validated);

        // ✅ FIX: Redirect beda kalau login vs gak login
        if (Auth::check()) {
            return redirect()->route('warga.aduan.index')
                             ->with('success', 'Aduan berhasil dikirim!');
        }

        return redirect()->route('aduan.public.index')
                         ->with('success', 'Aduan berhasil dikirim!');
    }

    /**
     * Detail aduan (PUBLIK)
     */
    public function show($id)
    {
        $aduan = AduanWarga::with('user')->findOrFail($id);

        return view('warga.aduan.show', compact('aduan'));
    }
}