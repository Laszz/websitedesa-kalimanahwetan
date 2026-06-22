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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            // user penerima notif
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // isi notif
            $table->string('title');
            $table->text('message')->nullable();

            // link tujuan (misal ke halaman detail)
            $table->string('url')->nullable();

            // status baca
            $table->boolean('is_read')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
