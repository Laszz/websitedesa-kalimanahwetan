<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('penduduk_requests', function (Blueprint $table) {
        $table->bigIncrements('id');

        // relasi
        $table->unsignedBigInteger('layanan_id');
        $table->unsignedBigInteger('user_id');

        // data umum request
        $table->string('nomor_request')->unique();
        $table->enum('status', ['pending','review','approved','rejected','selesai'])->default('pending');
        $table->text('alasan_revisi')->nullable();
        $table->text('catatan_user')->nullable();

        $table->timestamp('tanggal_request')->useCurrent();
        $table->timestamp('tanggal_selesai')->nullable();

        $table->timestamps();

        // foreign key
        $table->foreign('layanan_id')->references('id')->on('layanan_penduduks')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk_requests');
    }
};
