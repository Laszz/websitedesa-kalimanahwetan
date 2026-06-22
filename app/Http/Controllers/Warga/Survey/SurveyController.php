<?php

namespace App\Http\Controllers\Warga\Survey;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    // Tampilkan form survey
    public function create()
    {
        // Cek apakah sudah isi survey bulan ini
        $alreadyFilled = Survey::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->exists();

        if ($alreadyFilled) {
            return view('warga.survey.thanks'); 
        }

        return view('warga.survey.create');
    }

    // Simpan survey
    public function store(Request $request)
    {
        $validated = $request->validate([
            'q1_speed'      => 'required|integer|min:1|max:5',
            'q2_friendly'   => 'required|integer|min:1|max:5',
            'q3_clarity'    => 'required|integer|min:1|max:5',
            'q4_ease'       => 'required|integer|min:1|max:5',
            'q5_overall'    => 'required|integer|min:1|max:5',
            'improvement'   => 'nullable|string|max:1000',
            'suggestion'    => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        Survey::create($validated);

        return redirect()->route('warga.survey.thanks')
            ->with('success', 'Terima kasih telah mengisi survey!');
    }

    // Halaman terima kasih
    public function thanks()
    {
        return view('warga.survey.thanks');
    }
}