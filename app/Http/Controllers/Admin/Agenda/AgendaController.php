<?php

namespace App\Http\Controllers\Admin\Agenda;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::with('user')->latest()->paginate(15);
        return view('admin.agenda.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'mulai' => 'required|date',
            'selesai' => 'nullable|date|after_or_equal:mulai',
            'seharian' => 'boolean',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['seharian'] = $request->boolean('seharian');

        $tz = 'Asia/Jakarta';

        if ($validated['seharian']) {
            $validated['mulai'] = Carbon::parse($validated['mulai'], $tz)->startOfDay();
            $validated['selesai'] = Carbon::parse($validated['mulai'], $tz)->endOfDay();
        } else {
            $validated['mulai'] = Carbon::parse($validated['mulai'], $tz);
            if ($validated['selesai']) {
                $validated['selesai'] = Carbon::parse($validated['selesai'], $tz);
            }
        }

        Agenda::create($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agenda.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'mulai' => 'required|date',
            'selesai' => 'nullable|date|after_or_equal:mulai',
            'seharian' => 'boolean',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ]);

        $validated['seharian'] = $request->boolean('seharian');

        // FIX: Parse dengan timezone Asia/Jakarta
        $tz = 'Asia/Jakarta';

        if ($validated['seharian']) {
            $validated['mulai'] = Carbon::parse($validated['mulai'], $tz)->startOfDay();
            $validated['selesai'] = Carbon::parse($validated['mulai'], $tz)->endOfDay();
        } else {
            $validated['mulai'] = Carbon::parse($validated['mulai'], $tz);
            if ($validated['selesai']) {
                $validated['selesai'] = Carbon::parse($validated['selesai'], $tz);
            }
        }

        $agenda->update($validated);

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}