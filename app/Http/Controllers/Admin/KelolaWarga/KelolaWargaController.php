<?php

namespace App\Http\Controllers\Admin\KelolaWarga;

use App\Http\Controllers\Controller;
use App\Models\Warga\Warga;
use App\Models\User;
use App\Exports\WargaExport;
use Maatwebsite\Excel\Facades\Excel; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KelolaWargaController extends Controller
{
    public function index()
    {
        $wargas = Warga::with('user')->latest()->get();
        return view('admin.kelolawarga.index', compact('wargas'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.kelolawarga.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'nik'              => 'required|unique:wargas,nik',
            'kk'               => 'required|unique:wargas,kk',
            'name'             => 'required|string|max:255',
            'umur'             => 'required|integer',
            'alamat'           => 'required|string',
            'status'           => 'required|string',
            'pendidikan_akhir' => 'required|string',
            'rw'               => 'required|string',
            'rt'               => 'required|string',
            'tempat_lahir'     => 'required|string',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string',
            'jenis_kelamin'    => 'required|string',
            'pekerjaan'        => 'required|string',
            'foto'             => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('images/profile_warga', 'public');
        }

        Warga::create($data);

        return redirect()->route('admin.kelolawarga.index')->with('success', 'Data warga berhasil ditambahkan');
    }

    public function show($id)
    {
        $warga = Warga::with('user')->findOrFail($id);
        return view('admin.kelolawarga.show', compact('warga'));
    }

    public function edit($id)
    {
        $warga = Warga::findOrFail($id);
        $users = User::all();
        return view('admin.kelolawarga.edit', compact('warga', 'users'));
    }

    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);

        $request->validate([
            'user_id'          => 'required|exists:users,id',
            'nik'              => 'required|unique:wargas,nik,' . $id,
            'kk'               => 'required|unique:wargas,kk,' . $id,
            'name'             => 'required|string|max:255',
            'umur'             => 'required|integer',
            'alamat'           => 'required|string',
            'status'           => 'required|string',
            'pendidikan_akhir' => 'required|string',
            'rw'               => 'required|string',
            'rt'               => 'required|string',
            'tempat_lahir'     => 'required|string',
            'tanggal_lahir'    => 'required|date',
            'agama'            => 'required|string',
            'jenis_kelamin'    => 'required|string',
            'pekerjaan'        => 'required|string',
            'foto'             => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($warga->foto && Storage::disk('public')->exists($warga->foto)) {
                Storage::disk('public')->delete($warga->foto);
            }
            $data['foto'] = $request->file('foto')->store('images/profile_warga', 'public');
        }

        $warga->update($data);

        return redirect()->route('admin.kelolawarga.index')->with('success', 'Data warga berhasil diperbarui');
    }

    public function destroy($id)
    {
        $warga = Warga::findOrFail($id);

        if ($warga->foto && Storage::disk('public')->exists($warga->foto)) {
            Storage::disk('public')->delete($warga->foto);
        }

        if ($warga->user) {
            $warga->user->delete();
        }

        $warga->delete();

        return redirect()->route('admin.kelolawarga.index')->with('success', 'Data warga dan akun berhasil dihapus');
    }

    // ← TAMBAH METHOD INI
    public function export()
    {
        $wargas = Warga::with('user')->latest()->get();
        
        $filename = 'Rekap_Data_Warga_' . now()->format('d-m-Y_H-i-s') . '.xlsx';
        
        return Excel::download(new WargaExport($wargas), $filename);
    }
}