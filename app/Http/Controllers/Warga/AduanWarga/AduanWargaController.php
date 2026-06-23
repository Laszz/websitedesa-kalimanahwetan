<?php

namespace App\Http\Controllers\Warga\AduanWarga;

use App\Http\Controllers\Controller;
use App\Models\AduanWarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AduanWargaController extends Controller
{
    public function index()
    {
        $aduans = AduanWarga::where('tampilkan', true)
            ->latest()
            ->get();

        return view('warga.aduan.index', compact('aduans'));
    }

    public function create()
    {
        return view('warga.aduan.create');
    }

    public function store(Request $request)
    {
        // ===== ANTI DOUBLE SUBMIT: CEK TOKEN =====
        $token = $request->input('submission_token');

        if (session()->has('last_aduan_token') && session('last_aduan_token') === $token) {
            return redirect()->back()
                ->with('warning', 'Aduan sudah dikirim, mohon tunggu.')
                ->withInput();
        }

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

        $validated['user_id']   = Auth::id();
        $validated['nama']      = Auth::check() ? Auth::user()->name : ($validated['nama'] ?? 'Anonim');
        $validated['status']    = 'menunggu';
        $validated['tampilkan'] = true;

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')
                ->store('images/foto_aduan_warga', 'public');
        }

        AduanWarga::create($validated);

        // Simpan token ke session
        session(['last_aduan_token' => $token]);

        if (Auth::check()) {
            return redirect()->route('warga.aduan.index')
                             ->with('success', 'Aduan berhasil dikirim!');
        }

        return redirect()->route('aduan.public.index')
                         ->with('success', 'Aduan berhasil dikirim!');
    }

    public function show($id)
    {
        $aduan = AduanWarga::with('user')->findOrFail($id);
        return view('warga.aduan.show', compact('aduan'));
    }
}