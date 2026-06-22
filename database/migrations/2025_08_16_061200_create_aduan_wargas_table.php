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
Schema::create('aduan_wargas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
    $table->string('nama')->nullable();
    $table->string('judul');
    $table->string('nomor_wa');
    $table->text('detail');
    $table->string('gambar')->nullable();
    $table->string('alamat');
    $table->decimal('latitude', 10, 7)->nullable();
    $table->decimal('longitude', 10, 7)->nullable();
    $table->string('kategori')->nullable();
    $table->string('prioritas')->nullable();
    $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');
    $table->boolean('tampilkan')->default(false);
    $table->timestamps();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduan_wargas');
    }
};
