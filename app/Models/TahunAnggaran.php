<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAnggaran extends Model
{
    use HasFactory;

    protected $table = 'tahun_anggarans';

    protected $fillable = [
        'tahun',
        'status',
    ];

    protected $guarded = ['total_anggaran', 'total_realisasi', 'sisa'];

    protected $casts = [
        'tahun' => 'integer',
        'total_anggaran' => 'decimal:2',
        'total_realisasi' => 'decimal:2',
        'sisa' => 'decimal:2',
    ];

    // Relationships
    public function sumberDanas()
    {
        return $this->hasMany(SumberDana::class, 'tahun_anggaran_id');
    }

    public function bidangAnggarans()
    {
        return $this->hasMany(BidangAnggaran::class, 'tahun_anggaran_id');
    }

    public function pengalokasians()
    {
        return $this->hasManyThrough(
            PengalokasianDana::class,
            SumberDana::class,
            'tahun_anggaran_id',
            'sumber_dana_id',
            'id',
            'id'
        );
    }

    public function realisasis()
    {
        return $this->hasManyThrough(
            RealisasiBulanan::class,
            SumberDana::class,
            'tahun_anggaran_id',
            'sumber_dana_id',
            'id',
            'id'
        );
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeDitutup($query)
    {
        return $query->where('status', 'ditutup');
    }

    // Recalculate totals from relations — call after any sumber_dana/realisasi change
    public function recalculate(): self
    {
        $this->total_anggaran = $this->sumberDanas()
            ->sum('nominal_awal');

        $this->total_realisasi = $this->sumberDanas()
            ->sum('nominal_terpakai');

        $this->sisa = $this->total_anggaran - $this->total_realisasi;

        $this->saveQuietly();
        return $this;
    }

    // Auto-calculate on save (fallback safety net)
    protected static function booted()
    {
        static::saving(function ($tahun) {
            // If totals were manually set (e.g. from recalculate), preserve them
            // Otherwise ensure sisa is consistent
            if (!$tahun->isDirty('total_anggaran') && !$tahun->isDirty('total_realisasi')) {
                // totals unchanged, just ensure sisa consistency
                $tahun->sisa = ($tahun->total_anggaran ?? 0) - ($tahun->total_realisasi ?? 0);
            } else {
                $tahun->sisa = $tahun->total_anggaran - $tahun->total_realisasi;
            }
        });
    }

    // Check if can be closed
    public function canBeClosed(): bool
    {
        return $this->status !== 'ditutup'
            && $this->sisa >= 0
            && $this->sumberDanas()->where('status', 'aktif')->doesntExist();
    }

    // Close tahun anggaran
    public function close(): self
    {
        if ($this->canBeClosed()) {
            $this->status = 'ditutup';
            $this->saveQuietly();
        }
        return $this;
    }
}