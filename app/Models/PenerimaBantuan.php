<?php
// app/Models/PenerimaBantuan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Warga\Warga;

class PenerimaBantuan extends Model
{
    use HasFactory;

    protected $table = 'penerima_bantuans';
    
    protected $fillable = [
        'warga_id',
        'jenis_bantuan_id',
        'desil',
        'status',
        'tanggal_terima',
        'keterangan',
        'created_by'
    ];

    protected $casts = [
        'desil' => 'integer',
        'tanggal_terima' => 'date',
    ];

    public function warga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'warga_id');
    }

    public function jenisBantuan(): BelongsTo
    {
        return $this->belongsTo(JenisBantuan::class, 'jenis_bantuan_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeByDesil(Builder $query, int $desil): Builder
    {
        return $query->where('desil', $desil);
    }

    public function scopeByDesilRange(Builder $query, int $min, int $max): Builder
    {
        return $query->whereBetween('desil', [$min, $max]);
    }

    public function scopeByJenis(Builder $query, int $jenisId): Builder
    {
        return $query->where('jenis_bantuan_id', $jenisId);
    }

    public function scopeByStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('status', 'aktif');
    }

    public function scopeSearchWarga(Builder $query, string $keyword): Builder
    {
        return $query->whereHas('warga', function($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('nik', 'like', "%{$keyword}%");
        });
    }

    public function getDesilLabelAttribute(): string
    {
        return "Desil {$this->desil}";
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'aktif' => '<span class="badge bg-success">Aktif</span>',
            'nonaktif' => '<span class="badge bg-warning">Nonaktif</span>',
            'dicabut' => '<span class="badge bg-danger">Dicabut</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}