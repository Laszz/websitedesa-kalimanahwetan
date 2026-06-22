<?php

namespace App\Models\Warga;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;  // ← TAMBAH INI
use App\Models\User;
use App\Models\PenerimaBantuan;  // ← TAMBAH INI

class Warga extends Model
{
    protected $table = 'wargas';

    protected $fillable = [
        'user_id',
        'nik',
        'kk',
        'name',
        'umur',
        'alamat',
        'status',
        'pendidikan_akhir',
        'rw',
        'rt',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'jenis_kelamin',
        'pekerjaan',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function penerimaBantuan(): HasMany
    {
        return $this->hasMany(PenerimaBantuan::class, 'warga_id');
    }

    public function riwayatBantuan(): HasMany
    {
        return $this->hasMany(PenerimaBantuan::class, 'warga_id')
                    ->with('jenisBantuan')
                    ->orderBy('created_at', 'desc');
    }

    public function getDesilLabelAttribute(): ?string
    {
        return $this->desil ? "Desil {$this->desil}" : 'Belum ditentukan';
    }
}