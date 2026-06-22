<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananPenduduk extends Model
{
    protected $fillable = [
        'nama_layanan',
        'kategori',
        'deskripsi',
        'output',
        'status',
    ];

    // Relasi: Satu layanan punya banyak syarat
    public function requirements()
    {
        return $this->hasMany(PendudukRequirement::class, 'layanan_id');
    }

    // Relasi: Satu layanan dipakai banyak request dari user
    public function requests()
    {
        return $this->hasMany(PendudukRequest::class, 'layanan_id');
    }
}
