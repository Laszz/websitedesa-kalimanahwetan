<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    use HasFactory;

    protected $table = 'sumber_danas';

    protected $fillable = [
        'tahun_anggaran_id',
        'jenis',
        'nama_sumber',
        'nominal_awal',
        'nominal_terpakai',
        'keterangan',
        'status',
        'created_by',
    ];

    protected $casts = [
        'nominal_awal' => 'decimal:2',
        'nominal_terpakai' => 'decimal:2',
        'sisa' => 'decimal:2',
    ];

    // Relationships
    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class);
    }

    public function pengalokasians()
    {
        return $this->hasMany(PengalokasianDana::class, 'sumber_dana_id');
    }

    public function realisasis()
    {
        return $this->hasMany(RealisasiBulanan::class, 'sumber_dana_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Auto calculate sisa & status on save
    protected static function booted()
    {
        static::saving(function ($sumber) {
            if ($sumber->isDirty('sisa') && !$sumber->isDirty('nominal_terpakai') && !$sumber->isDirty('nominal_awal')) {
                $sumber->sisa = $sumber->getOriginal('sisa') ?? 0;
            } else {
                $sumber->sisa = $sumber->nominal_awal - $sumber->nominal_terpakai;
            }

            if ($sumber->sisa <= 0) {
                $sumber->status = 'habis';
            } elseif ($sumber->sisa < $sumber->nominal_awal) {
                $sumber->status = 'terpakai';
            } else {
                $sumber->status = 'aktif';
            }
        });
    }

    // Recalculate from approved pengalokasian
    public function recalculate(): self
    {
        $this->nominal_terpakai = $this->pengalokasians()
            ->where('status', 'disetujui')
            ->sum('nominal');

        $this->save();
        return $this;
    }

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeTersedia($query)
    {
        return $query->whereIn('status', ['aktif', 'terpakai'])
            ->where('sisa', '>', 0);
    }

    public function scopeByJenis($query, $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    public function scopeWithTahun($query)
    {
        return $query->with('tahunAnggaran');
    }
}