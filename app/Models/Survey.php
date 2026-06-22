<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'q1_speed',
        'q2_friendly',
        'q3_clarity',
        'q4_ease',
        'q5_overall',
        'improvement',
        'suggestion',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accessor: rata-rata rating per survey
    public function getAverageRatingAttribute(): float
    {
        return round(
            ($this->q1_speed + $this->q2_friendly + $this->q3_clarity + $this->q4_ease + $this->q5_overall) / 5,
            1
        );
    }
}