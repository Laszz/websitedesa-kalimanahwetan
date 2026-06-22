<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerubahanAnggaran extends Model
{
    use HasFactory;

    protected $table = 'perubahan_anggarans';

    protected $fillable = [
        'modifiable_type',
        'modifiable_id',
        'field',
        'nilai_lama',
        'nilai_baru',
        'alasan_perubahan',
        'updated_by',
    ];

    protected $casts = [
        'nilai_lama' => 'decimal:2',
        'nilai_baru' => 'decimal:2',
    ];

    // Disable updated_at (audit log only needs created_at)
    const UPDATED_AT = null;

    // Polymorphic
    public function modifiable()
    {
        return $this->morphTo();
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Helper: log a change
    public static function log(Model $model, string $field, float $nilaiLama, float $nilaiBaru, string $alasan, int $userId): self
    {
        return self::create([
            'modifiable_type' => get_class($model),
            'modifiable_id' => $model->getKey(),
            'field' => $field,
            'nilai_lama' => $nilaiLama,
            'nilai_baru' => $nilaiBaru,
            'alasan_perubahan' => $alasan,
            'updated_by' => $userId,
        ]);
    }

    // Scopes
    public function scopeForModel($query, Model $model)
    {
        return $query->where('modifiable_type', get_class($model))
            ->where('modifiable_id', $model->getKey());
    }

    public function scopeForField($query, string $field)
    {
        return $query->where('field', $field);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeWithUpdater($query)
    {
        return $query->with('updater');
    }
}