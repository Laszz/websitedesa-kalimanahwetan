<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengalokasianDana extends Model
{
    use HasFactory;

    protected $table = 'pengalokasian_danas';

    protected $fillable = [
        'sumber_dana_id',
        'bidang_anggaran_id',
        'nama_kegiatan',
        'detail_kegiatan',
        'nominal',
        'triwulan_target',
        'status',
        'created_by',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    protected $appends = ['sisa'];

    // Relationships
    public function sumberDana()
    {
        return $this->belongsTo(SumberDana::class);
    }

    public function bidangAnggaran()
    {
        return $this->belongsTo(BidangAnggaran::class);
    }

    public function realisasis()
    {
        return $this->hasMany(RealisasiBulanan::class, 'pengalokasian_dana_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessors (eager-loadable, no extra queries)
    public function getTotalRealisasiAttribute()
    {
        if (!$this->relationLoaded('realisasis')) {
            return $this->realisasis()
                ->where('status', 'terverifikasi')
                ->sum('nominal_digunakan');
        }
        return $this->realisasis
            ->where('status', 'terverifikasi')
            ->sum('nominal_digunakan');
    }

    public function getSisaAttribute()
    {
        return $this->nominal - $this->total_realisasi;
    }

    // Check if can be approved
    public function canApprove(): bool
    {
        return $this->status === 'direncanakan'
            && $this->sisa >= 0
            && $this->sumberDana
            && $this->sumberDana->sisa >= $this->nominal;
    }

    // Approve
    public function approve(): self
    {
        if ($this->canApprove()) {
            $this->status = 'disetujui';
            $this->save();

            // Recalculate sumber dana
            $this->sumberDana->recalculate();

            // Recalculate tahun anggaran
            $this->sumberDana->tahunAnggaran->recalculate();
        }
        return $this;
    }

    // Reject
    public function reject(): self
    {
        if ($this->status === 'direncanakan') {
            $this->status = 'ditolak';
            $this->save();
        }
        return $this;
    }

    // Request revision
    public function requestRevision(): self
    {
        if ($this->status === 'disetujui') {
            $this->status = 'revisi';
            $this->save();

            $this->sumberDana->recalculate();
            $this->sumberDana->tahunAnggaran->recalculate();
        }
        return $this;
    }

    // Scopes
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    public function scopeDirencanakan($query)
    {
        return $query->where('status', 'direncanakan');
    }

    public function scopeByTriwulan($query, $triwulan)
    {
        return $query->where('triwulan_target', $triwulan);
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['sumberDana.tahunAnggaran', 'bidangAnggaran', 'creator']);
    }
}