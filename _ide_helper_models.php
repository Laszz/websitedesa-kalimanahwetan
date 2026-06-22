<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property string|null $nama
 * @property string $judul
 * @property string $nomor_wa
 * @property string $detail
 * @property string|null $gambar
 * @property string $alamat
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $kategori
 * @property string|null $prioritas
 * @property string $status
 * @property bool $tampilkan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga published()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereNomorWa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga wherePrioritas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereTampilkan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AduanWarga whereUserId($value)
 */
	class AduanWarga extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $judul
 * @property string $slug
 * @property string $ringkasan
 * @property string $deskripsi
 * @property string $tanggal
 * @property string $gambar
 * @property string $tampilkan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereRingkasan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereTampilkan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Berita whereUpdatedAt($value)
 */
	class Berita extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tahun_anggaran_id
 * @property string $kode_bidang
 * @property string $nama_bidang
 * @property numeric $total_anggaran
 * @property numeric $total_realisasi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PengalokasianDana> $pengalokasians
 * @property-read int|null $pengalokasians_count
 * @property-read \App\Models\TahunAnggaran $tahunAnggaran
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran whereKodeBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran whereNamaBidang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran whereTahunAnggaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran whereTotalRealisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|BidangAnggaran whereUpdatedAt($value)
 */
	class BidangAnggaran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $judul
 * @property string|null $deskripsi
 * @property string $gambar
 * @property string $slug
 * @property string $tanggal
 * @property string $tampilkan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereGambar($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereJudul($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereTampilkan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Galeri whereUpdatedAt($value)
 */
	class Galeri extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama_layanan
 * @property string $kategori
 * @property string|null $deskripsi
 * @property string $output
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PendudukRequest> $requests
 * @property-read int|null $requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PendudukRequirement> $requirements
 * @property-read int|null $requirements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk whereKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk whereNamaLayanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk whereOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LayananPenduduk whereUpdatedAt($value)
 */
	class LayananPenduduk extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $message
 * @property string|null $url
 * @property bool $is_read
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $layanan_id
 * @property int $user_id
 * @property string $nomor_request
 * @property string $status
 * @property string|null $catatan_admin
 * @property string|null $catatan_user
 * @property string|null $file_output
 * @property \Illuminate\Support\Carbon $tanggal_request
 * @property \Illuminate\Support\Carbon|null $tanggal_selesai
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LayananPenduduk $layanan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PendudukUpload> $uploads
 * @property-read int|null $uploads_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereCatatanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereCatatanUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereFileOutput($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereLayananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereNomorRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereTanggalRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereTanggalSelesai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequest whereUserId($value)
 */
	class PendudukRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $layanan_id
 * @property string $nama_syarat
 * @property string $tipe
 * @property int $wajib
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LayananPenduduk $layanan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement whereLayananId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement whereNamaSyarat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement whereTipe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukRequirement whereWajib($value)
 */
	class PendudukRequirement extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $request_id
 * @property int $requirement_id
 * @property string|null $file_path
 * @property string|null $value_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PendudukRequest $request
 * @property-read \App\Models\PendudukRequirement $requirement
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload whereRequirementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PendudukUpload whereValueText($value)
 */
	class PendudukUpload extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $sumber_dana_id
 * @property int $bidang_anggaran_id
 * @property string $nama_kegiatan
 * @property string|null $detail_kegiatan
 * @property numeric $nominal
 * @property string|null $triwulan_target
 * @property string $status
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\BidangAnggaran $bidangAnggaran
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RealisasiBulanan> $realisasis
 * @property-read int|null $realisasis_count
 * @property-read \App\Models\SumberDana|null $sumberDana
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereBidangAnggaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereDetailKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereNamaKegiatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereNominal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereSumberDanaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereTriwulanTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PengalokasianDana withoutTrashed()
 */
	class PengalokasianDana extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $nama
 * @property string $jabatan
 * @property string|null $foto
 * @property int $urutan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $foto_url
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerangkatDesa whereUrutan($value)
 */
	class PerangkatDesa extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $modifiable_type
 * @property int $modifiable_id
 * @property string $field
 * @property numeric|null $nilai_lama
 * @property numeric|null $nilai_baru
 * @property string $alasan_perubahan
 * @property int $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $modifiable
 * @property-read \App\Models\User $updater
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereAlasanPerubahan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereField($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereModifiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereModifiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereNilaiBaru($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereNilaiLama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PerubahanAnggaran whereUpdatedBy($value)
 */
	class PerubahanAnggaran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $pengalokasian_dana_id
 * @property int $sumber_dana_id
 * @property string $tahun
 * @property int $bulan
 * @property string $triwulan
 * @property numeric $nominal_digunakan
 * @property string|null $keterangan_pemakaian
 * @property string|null $bukti_transaksi
 * @property string $status
 * @property int|null $verified_by
 * @property \Illuminate\Support\Carbon|null $verified_at
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\PengalokasianDana|null $pengalokasian
 * @property-read \App\Models\SumberDana|null $sumberDana
 * @property-read \App\Models\User|null $verifier
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan byBulan($bulan)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan byTriwulan($triwulan)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan terverifikasi()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereBuktiTransaksi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereKeteranganPemakaian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereNominalDigunakan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan wherePengalokasianDanaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereSumberDanaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereTriwulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RealisasiBulanan whereVerifiedBy($value)
 */
	class RealisasiBulanan extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tahun_anggaran_id
 * @property string $jenis
 * @property string $nama_sumber
 * @property numeric $nominal_awal
 * @property numeric $nominal_terpakai
 * @property numeric $sisa
 * @property string|null $keterangan
 * @property string $status
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PengalokasianDana> $pengalokasians
 * @property-read int|null $pengalokasians_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RealisasiBulanan> $realisasis
 * @property-read int|null $realisasis_count
 * @property-read \App\Models\TahunAnggaran $tahunAnggaran
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana aktif()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana byJenis($jenis)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereJenis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereNamaSumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereNominalAwal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereNominalTerpakai($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereSisa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereTahunAnggaranId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SumberDana withoutTrashed()
 */
	class SumberDana extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $q1_speed
 * @property int $q2_friendly
 * @property int $q3_clarity
 * @property int $q4_ease
 * @property int $q5_overall
 * @property string|null $improvement
 * @property string|null $suggestion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $average_rating
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereImprovement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereQ1Speed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereQ2Friendly($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereQ3Clarity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereQ4Ease($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereQ5Overall($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereSuggestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Survey whereUserId($value)
 */
	class Survey extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $tahun
 * @property string $status
 * @property numeric $total_anggaran
 * @property numeric $total_realisasi
 * @property numeric $sisa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BidangAnggaran> $bidangAnggarans
 * @property-read int|null $bidang_anggarans_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SumberDana> $sumberDanas
 * @property-read int|null $sumber_danas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran aktif()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran whereSisa($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran whereTotalAnggaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran whereTotalRealisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TahunAnggaran whereUpdatedAt($value)
 */
	class TahunAnggaran extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string $role
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AduanWarga> $aduan
 * @property-read int|null $aduan_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notification
 * @property-read int|null $notification_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Warga\Profile|null $profile
 * @property-read \App\Models\Warga\Warga|null $warga
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models\Warga{
/**
 * @property int $id
 * @property int $user_id
 * @property string $nik
 * @property string $kk
 * @property string $name
 * @property int $umur
 * @property string $alamat
 * @property string $status
 * @property string $pendidikan_akhir
 * @property string $rw
 * @property string $rt
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $agama
 * @property string $jenis_kelamin
 * @property string $pekerjaan
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereKk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile wherePendidikanAkhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUmur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Profile whereUserId($value)
 */
	class Profile extends \Eloquent {}
}

namespace App\Models\Warga{
/**
 * @property int $id
 * @property int $user_id
 * @property string $nik
 * @property string $kk
 * @property string $name
 * @property int $umur
 * @property string $alamat
 * @property string $status
 * @property string $pendidikan_akhir
 * @property string $rw
 * @property string $rt
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $agama
 * @property string $jenis_kelamin
 * @property string $pekerjaan
 * @property string|null $foto
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereAgama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereFoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereKk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga wherePekerjaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga wherePendidikanAkhir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereRt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereRw($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereUmur($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Warga whereUserId($value)
 */
	class Warga extends \Eloquent {}
}

