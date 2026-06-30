<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\AduanWarga;
use App\Models\Agenda;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $beritas = Berita::where('tampilkan', 'tampilkan')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        $aduans = AduanWarga::where('tampilkan', true)
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();
        
        $agendas = Agenda::mendatang()
            ->where('status', 'aktif')
            ->limit(5)
            ->get();

        return view('welcome', compact('beritas', 'aduans', 'agendas'));
    }
}