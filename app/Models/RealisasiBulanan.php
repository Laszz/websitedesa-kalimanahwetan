<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiBulanan extends Model
{
    use HasFactory;

    protected $table = 'realisasi_bulanans';

    protected $fillable = [
        'pengalokasian_dana_id',
        'sumber_dana_id',
        'tahun',
        'bulan',
        'nominal_digunakan',
        'keterangan_pemakaian',
        'bukti_transaksi',
        'status',
        'verified_by',
        'verified_at',
        'created_by',
    ];

    protected $guarded = ['triwulan'];

    protected $casts = [
        'nominal_digunakan' => 'decimal:2',
        'verified_at' => 'datetime',
        'tahun' => 'integer',
        'bulan' => 'integer',
    ];

    protected static $triwulanMap = [
        1 => 'I', 2 => 'I', 3 => 'I',
        4 => 'II', 5 => 'II', 6 => 'II',
        7 => 'III', 8 => 'III', 9 => 'III',
        10 => 'IV', 11 => 'IV', 12 => 'IV',
    ];

    // Relationships
    public function pengalokasian()
    {
        return $this->belongsTo(PengalokasianDana::class, 'pengalokasian_dana_id');
    }

    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Auto triwulan from bulan
    protected static function booted()
    {
        static::saving(function ($realisasi) {
            $realisasi->triwulan = self::$triwulanMap[$realisasi->bulan] ?? 'I';
        });

        static::deleted(function ($realisasi) {
            $realisasi->sumberDana?->recalculate();
            $realisasi->sumberDana?->tahunAnggaran?->recalculate();
        });
    }

    // Check if can verify
    public function canVerify(): bool
    {
        return $this->status === 'pending'
            && $this->pengalokasian
            && $this->pengalokasian->status === 'disetujui'
            && $this->pengalokasian->sisa >= $this->nominal_digunakan;
    }

    // Verify
    public function verify(int $userId): self
    {
        if ($this->canVerify()) {
            $this->status = 'terverifikasi';
            $this->verified_by = $userId;
            $this->verified_at = now();
            $this->save();
        }
        return $this;
    }

    // Reject
    public function reject(): self
    {
        if ($this->status === 'pending') {
            $this->status = 'ditolak';
            $this->save();
        }
        return $this;
    }

    // Scopes
    public function scopeTerverifikasi($query)
    {
        return $query->where('status', 'terverifikasi');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByBulan($query, $bulan)
    {
        return $query->where('bulan', $bulan);
    }

    public function scopeByTriwulan($query, $triwulan)
    {
        return $query->where('triwulan', $triwulan);
    }

    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['pengalokasian.bidangAnggaran', 'sumberDana.tahunAnggaran', 'verifier', 'creator']);
    }
}