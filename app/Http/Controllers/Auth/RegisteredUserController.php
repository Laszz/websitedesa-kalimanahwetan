<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\warga\Warga;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string','email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['required', 'string', 'size:16', 'unique:wargas'],
            'kk' => ['required', 'string', 'size:16', 'unique:wargas'],
            'alamat' => ['required', 'string'],
            'status' => ['required', 'string'],
            'pendidikan_akhir' => ['required', 'string'],
            'rw' => ['required', 'string'],
            'rt' => ['required', 'string'],
            'tempat_lahir' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'agama' => ['required', 'string'],
            'jenis_kelamin' => ['required', 'string'],
            'pekerjaan' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $umur = Carbon::parse($request->tanggal_lahir)->age;

        $user = User::create([
            'name' => $request->name,
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'role' => 'warga',
            'status' => 'menunggu',
        ]);


        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('images/profile_warga', 'public');
        }

        Warga::create([
            'user_id' => $user->id,
            'nik' => $request->nik,
            'kk' => $request->kk,
            'name' => $request->name,
            'umur' => $umur,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'pendidikan_akhir' => $request->pendidikan_akhir,
            'rw' => $request->rw,
            'rt' => $request->rt,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'foto' => $fotoPath,
        ]);

        event(new Registered($user));
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil, akun anda sedang menunggu persetujuan Admin.');

    }
}
