<?php

namespace App\Http\Controllers\Warga\Agenda;

use App\Http\Controllers\Controller;
use App\Models\Agenda;

class AgendaController extends Controller
{
    public function index()
    {
        $daftarAgenda = Agenda::mendatang()
            ->where('status', 'aktif')
            ->limit(20)
            ->get();

        return view('warga.agenda.index', compact('daftarAgenda'));
    }
}