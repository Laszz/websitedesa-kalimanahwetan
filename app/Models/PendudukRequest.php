<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendudukRequest extends Model
{
    use HasFactory;

    protected $table = 'penduduk_requests';

    protected $fillable = [
        'nomor_request',
        'user_id',
        'layanan_id',
        'status',
        'catatan_admin',
        'catatan_user',
        'file_output',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_request' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function layanan()
    {
        return $this->belongsTo(LayananPenduduk::class, 'layanan_id');
    }

    public function uploads()
    {
        return $this->hasMany(PendudukUpload::class, 'request_id');
    }
}