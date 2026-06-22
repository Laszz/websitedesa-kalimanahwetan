<?php

namespace App\Http\Controllers\Warga\Profile;

use App\Http\Controllers\Controller;
use App\Models\Warga\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::with('user')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('warga.profile.index', compact('profile'));
    }

    public function edit()
    {
        $profile = Profile::with('user')
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('warga.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Profile::where('user_id', Auth::id())->firstOrFail();
        $user    = User::findOrFail(Auth::id());

        $validated = $request->validate([
            'nik'               => 'required|string|max:20',
            'kk'                => 'required|string|max:20',
            'name'              => 'required|string|max:100',
            'umur'              => 'required|integer|min:0',
            'alamat'            => 'required|string',
            'status'            => 'required|string',
            'pendidikan_akhir'  => 'required|string',
            'rw'                => 'required|string|max:10',
            'rt'                => 'required|string|max:10',
            'tempat_lahir'      => 'required|string|max:50',
            'tanggal_lahir'     => 'required|date',
            'agama'             => 'required|string|max:50',
            'jenis_kelamin'     => 'required|string|in:Laki-laki,Perempuan',
            'pekerjaan'         => 'required|string|max:100',
            'foto'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email'             => 'nullable|email|max:255',
            'password'          => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($request, $validated, $user, $profile) {

           
            $user->name = $request->name;

            
            if ($request->filled('email')) {
                $user->email = $request->email;
            }

            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

           
            unset($validated['email'], $validated['password']);

            
            if ($request->hasFile('foto')) {
                
                if (!empty($profile->foto)) {
                    $oldPath = str_replace('storage/', '', $profile->foto);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }

                $filePath = $request->file('foto')->store('images/profile_warga', 'public');
                
                $validated['foto'] = $filePath;
            }

           
            $profile->update($validated);
        });

        return redirect()
            ->route('warga.profile.index')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}