<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendudukRequirement extends Model
{
    protected $fillable = [
        'layanan_id',
        'nama_syarat',
        'tipe',
        'wajib',
    ];

    public function layanan()
    {
        return $this->belongsTo(LayananPenduduk::class, 'layanan_id');
    }
}
