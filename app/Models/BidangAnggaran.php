<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangAnggaran extends Model
{
    use HasFactory;

    protected $table = 'bidang_anggarans';

    protected $fillable = [
        'tahun_anggaran_id',
        'kode_bidang',
        'nama_bidang',
    ];

    protected $guarded = ['total_anggaran', 'total_realisasi'];

    protected $casts = [
        'total_anggaran' => 'decimal:2',
        'total_realisasi' => 'decimal:2',
    ];

    protected $appends = ['nama_bidang_display'];

    // Relationships
    public function tahunAnggaran()
    {
        return $this->belongsTo(TahunAnggaran::class);
    }

    public function pengalokasians()
    {
        return $this->hasMany(PengalokasianDana::class, 'bidang_anggaran_id');
    }

    // Accessor: auto nama bidang dari kode
    public function getNamaBidangDisplayAttribute()
    {
        $bidang = [
            '1' => 'Bid. Pemerintahan Desa',
            '2' => 'Bid. Pembangunan',
            '3' => 'Bid. Pembinaan Kemasyarakatan',
            '4' => 'Bid. Pemberdayaan Masyarakat',
            '5' => 'Bid. Penanggulangan Bencana',
            '6' => 'Bid. Lainnya',
        ];
        return $bidang[$this->kode_bidang] ?? 'Tidak Diketahui';
    }

    // Recalculate totals from approved pengalokasian
    public function recalculate(): self
    {
        $this->total_anggaran = $this->pengalokasians()
            ->where('status', 'disetujui')
            ->sum('nominal');

        $this->total_realisasi = $this->pengalokasians()
            ->whereHas('realisasis', function ($q) {
                $q->where('status', 'terverifikasi');
            })
            ->withSum('realisasis as total_real', 'nominal_digunakan')
            ->get()
            ->sum('total_real');

        // Alternative simpler approach:
        $this->total_realisasi = \DB::table('realisasi_bulanans')
            ->join('pengalokasian_danas', 'realisasi_bulanans.pengalokasian_dana_id', '=', 'pengalokasian_danas.id')
            ->where('pengalokasian_danas.bidang_anggaran_id', $this->id)
            ->where('realisasi_bulanans.status', 'terverifikasi')
            ->sum('realisasi_bulanans.nominal_digunakan');

        $this->saveQuietly();
        return $this;
    }

    // Scopes
    public function scopeByKode($query, $kode)
    {
        return $query->where('kode_bidang', $kode);
    }

    public function scopeWithTahun($query)
    {
        return $query->with('tahunAnggaran');
    }

    public function scopeWithPengalokasian($query)
    {
        return $query->with(['pengalokasians' => function ($q) {
            $q->where('status', 'disetujui');
        }]);
    }
}