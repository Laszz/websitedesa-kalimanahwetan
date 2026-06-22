<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. tahun_anggarans
        Schema::create('tahun_anggarans', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->unique();
            $table->enum('status', ['draft', 'aktif', 'ditutup'])->default('draft');
            $table->decimal('total_anggaran', 20, 2)->default(0);
            $table->decimal('total_realisasi', 20, 2)->default(0);
            $table->decimal('sisa', 20, 2)->default(0);
            $table->timestamps();
        });

        // 2. sumber_danas
        Schema::create('sumber_danas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_anggaran_id')->constrained('tahun_anggarans')->onDelete('cascade');
            $table->enum('jenis', ['apbn', 'apbd_provinsi', 'bkk', 'pad', 'add', 'dd', 'silpa', 'lainnya']);
            $table->string('nama_sumber');
            $table->decimal('nominal_awal', 20, 2)->default(0);
            $table->decimal('nominal_terpakai', 20, 2)->default(0);
            $table->decimal('sisa', 20, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'terpakai', 'habis', 'ditutup'])->default('aktif');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. bidang_anggarans
        Schema::create('bidang_anggarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tahun_anggaran_id')->constrained('tahun_anggarans')->onDelete('cascade');
            $table->enum('kode_bidang', ['1', '2', '3', '4', '5', '6']);
            $table->string('nama_bidang');
            $table->decimal('total_anggaran', 20, 2)->default(0);
            $table->decimal('total_realisasi', 20, 2)->default(0);
            $table->timestamps();
        });

        // 4. pengalokasian_danas (perencanaan)
        Schema::create('pengalokasian_danas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sumber_dana_id')->constrained('sumber_danas')->onDelete('cascade');
            $table->foreignId('bidang_anggaran_id')->constrained('bidang_anggarans')->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->text('detail_kegiatan')->nullable();
            $table->decimal('nominal', 20, 2)->default(0);
            $table->enum('triwulan_target', ['I', 'II', 'III', 'IV'])->nullable();
            $table->enum('status', ['direncanakan', 'disetujui', 'ditolak', 'revisi'])->default('direncanakan');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. realisasi_bulanans (pemakaian real-time)
        Schema::create('realisasi_bulanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengalokasian_dana_id')->constrained('pengalokasian_danas')->onDelete('cascade');
            $table->foreignId('sumber_dana_id')->constrained('sumber_danas')->onDelete('cascade');
            $table->year('tahun');
            $table->tinyInteger('bulan');
            $table->enum('triwulan', ['I', 'II', 'III', 'IV']);
            $table->decimal('nominal_digunakan', 20, 2)->default(0);
            $table->text('keterangan_pemakaian')->nullable();
            $table->string('bukti_transaksi')->nullable();
            $table->enum('status', ['pending', 'terverifikasi', 'ditolak'])->default('pending');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // 6. perubahan_anggarans (audit log)
        Schema::create('perubahan_anggarans', function (Blueprint $table) {
            $table->id();
            $table->morphs('modifiable');
            $table->string('field');
            $table->decimal('nilai_lama', 20, 2)->nullable();
            $table->decimal('nilai_baru', 20, 2)->nullable();
            $table->text('alasan_perubahan');
            $table->foreignId('updated_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perubahan_anggarans');
        Schema::dropIfExists('realisasi_bulanans');
        Schema::dropIfExists('pengalokasian_danas');
        Schema::dropIfExists('bidang_anggarans');
        Schema::dropIfExists('sumber_danas');
        Schema::dropIfExists('tahun_anggarans');
    }
};