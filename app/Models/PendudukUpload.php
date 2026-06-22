<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendudukUpload extends Model
{
    protected $fillable = [
        'request_id',
        'requirement_id',
        'file_path',
        'value_text',
    ];

    public function request()
    {
        return $this->belongsTo(PendudukRequest::class, 'request_id');
    }

    public function requirement()
    {
        return $this->belongsTo(PendudukRequirement::class, 'requirement_id');
    }
}
