<?php

namespace App\Http\Controllers\Admin\Survey;

use App\Http\Controllers\Controller;
use App\Models\Survey;

class SurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with('user')->latest()->paginate(20);

        $avg_speed = round(Survey::avg('q1_speed') ?? 0, 1);
        $avg_friendly = round(Survey::avg('q2_friendly') ?? 0, 1);
        $avg_clarity = round(Survey::avg('q3_clarity') ?? 0, 1);
        $avg_ease = round(Survey::avg('q4_ease') ?? 0, 1);
        $avg_overall = round(Survey::avg('q5_overall') ?? 0, 1);

        $stats = [
            'total' => Survey::count(),
            'avg_speed' => $avg_speed,
            'avg_friendly' => $avg_friendly,
            'avg_clarity' => $avg_clarity,
            'avg_ease' => $avg_ease,
            'avg_overall' => $avg_overall,
            'overall' => round(($avg_speed + $avg_friendly + $avg_clarity + $avg_ease + $avg_overall) / 5, 1),
        ];

        return view('admin.survey.index', compact('surveys', 'stats'));
    }

    public function show(Survey $survey)
    {
        return view('admin.survey.show', compact('survey'));
    }
}