<?php

namespace App\Http\Controllers\Warga\Survey;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function create()
    {
        $alreadyFilled = Survey::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->exists();

        if ($alreadyFilled) {
            return view('warga.survey.thanks'); 
        }

        return view('warga.survey.create');
    }

    public function store(Request $request)
    {
        // ===== ANTI DOUBLE SUBMIT: CEK TOKEN =====
        $token = $request->input('submission_token');

        if (session()->has('last_survey_token') && session('last_survey_token') === $token) {
            return redirect()->route('warga.survey.thanks')
                ->with('warning', 'Survey sudah dikirim.');
        }

        // ===== CEK DUPLIKAT BULAN INI (race condition protection) =====
        $alreadyFilled = Survey::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->exists();

        if ($alreadyFilled) {
            return redirect()->route('warga.survey.thanks')
                ->with('info', 'Anda sudah mengisi survey bulan ini.');
        }

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

        // Simpan token ke session
        session(['last_survey_token' => $token]);

        return redirect()->route('warga.survey.thanks')
            ->with('success', 'Terima kasih telah mengisi survey!');
    }

    public function thanks()
    {
        return view('warga.survey.thanks');
    }
}