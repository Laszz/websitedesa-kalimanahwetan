<?php

namespace App\Http\Controllers\Admin\KelolaAkun;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaAkunController extends Controller
{
    //Menampilkan semua akun warga
    public function index()
    {
        $users = User::where('role', 'warga')->get();
        return view('admin.kelolaakun.index', compact('users'));
    }

    //Ubah status akun (menunggu → disetujui / ditolak)
    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success', 'Status akun berhasil diperbarui.');
    }

    //Edit data akun warga
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.kelolaakun.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email'));

        return redirect()->route('admin.kelolaakun.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    //Hapus akun warga
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun warga berhasil dihapus.');
    }
}
