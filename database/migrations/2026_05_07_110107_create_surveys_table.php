<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('q1_speed')->unsigned();        // Kecepatan pelayanan
            $table->tinyInteger('q2_friendly')->unsigned();   // Keramahan petugas
            $table->tinyInteger('q3_clarity')->unsigned();    // Kejelasan informasi
            $table->tinyInteger('q4_ease')->unsigned();        // Kemudahan administrasi
            $table->tinyInteger('q5_overall')->unsigned();    // Kualitas keseluruhan
            $table->text('improvement')->nullable();           // Apa yang perlu diperbaiki
            $table->text('suggestion')->nullable();            // Saran untuk pelayanan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};