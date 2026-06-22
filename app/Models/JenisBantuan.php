<?php
// app/Models/JenisBantuan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisBantuan extends Model
{
    use HasFactory;

    protected $table = 'jenis_bantuans';
    
    protected $fillable = [
        'kode_bantuan',
        'nama_bantuan',
        'sumber_dana',
        'tahun_anggaran_id',
        'anggaran_per_kk'
    ];

    protected $casts = [
        'anggaran_per_kk' => 'decimal:2',
    ];

    public function tahunAnggaran(): BelongsTo
    {
        return $this->belongsTo(TahunAnggaran::class, 'tahun_anggaran_id');
    }

    public function penerima(): HasMany
    {
        return $this->hasMany(PenerimaBantuan::class, 'jenis_bantuan_id');
    }

    public function scopeByTahun($query, $tahunId)
    {
        return $query->where('tahun_anggaran_id', $tahunId);
    }

    public function scopeActive($query)
    {
        return $query->whereHas('tahunAnggaran', function($q) {
            $q->where('status', 'aktif');
        });
    }
}