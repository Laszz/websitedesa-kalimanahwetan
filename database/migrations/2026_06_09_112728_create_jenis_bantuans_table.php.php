<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_bantuans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bantuan', 20)->unique();
            $table->string('nama_bantuan', 100);
            $table->string('sumber_dana', 100)->nullable();
            $table->foreignId('tahun_anggaran_id')
                  ->constrained('tahun_anggarans') 
                  ->onDelete('cascade');
            $table->decimal('anggaran_per_kk', 15, 2)->default(0);
            $table->timestamps();
            
            $table->index('kode_bantuan');
            $table->index('tahun_anggaran_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_bantuans'); 
    }
};