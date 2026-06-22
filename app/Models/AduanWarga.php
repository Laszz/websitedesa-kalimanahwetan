<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanWarga extends Model
{
    use HasFactory;

    protected $table = 'aduan_wargas';

    protected $fillable = [
        'user_id',
        'judul',
        'nama',
        'nomor_wa',
        'detail',
        'gambar',
        'alamat',
        'latitude',
        'longitude',
        'kategori',
        'prioritas',
        'status',
        'tampilkan',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
        'tampilkan' => 'boolean',
    ];

    /**
     * Relasi ke user yang mengajukan aduan
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope: hanya ambil aduan yang ditampilkan di publik
     */
    public function scopePublished($query)
    {
        return $query->where('tampilkan', true);
    }
}
