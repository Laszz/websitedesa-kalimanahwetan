<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerima_bantuans', function (Blueprint $table) { 
            $table->foreignId('warga_id')
                  ->constrained('wargas') 
                  ->onDelete('cascade');
            $table->foreignId('jenis_bantuan_id')
                  ->constrained('jenis_bantuans') 
                  ->onDelete('cascade');
            $table->tinyInteger('desil')->unsigned();
            $table->enum('status', ['aktif', 'nonaktif', 'dicabut'])->default('aktif');
            $table->date('tanggal_terima')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->timestamps();
            
            $table->index('warga_id');
            $table->index('jenis_bantuan_id');
            $table->index('desil');
            $table->index('status');
            $table->unique(['warga_id', 'jenis_bantuan_id'], 'unique_warga_bantuan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuans'); 
    }
};