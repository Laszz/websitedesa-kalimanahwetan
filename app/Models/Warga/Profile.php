<?php

namespace App\Models\Warga;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'wargas';

    protected $fillable = [
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
        'email',
        'password',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
