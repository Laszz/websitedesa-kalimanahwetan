<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('layanan_id'); // relasi ke layanan_penduduks
            $table->string('nama_syarat'); // contoh: 'Foto KTP', 'Foto KK', 'Pengantar RT/RW'
            $table->string('tipe')->default('file'); // file / text (text kalau kebutuhan khusus)
            $table->boolean('wajib')->default(true);
            $table->timestamps();

            $table->foreign('layanan_id')
                  ->references('id')
                  ->on('layanan_penduduks')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk_requirements');
    }
};
