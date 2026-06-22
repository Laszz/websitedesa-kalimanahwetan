<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penduduk_requests', function (Blueprint $table) {
            $table->renameColumn('alasan_revisi', 'catatan_admin');
        });
    }

    public function down(): void
    {
        Schema::table('penduduk_requests', function (Blueprint $table) {
            $table->renameColumn('catatan_admin', 'alasan_revisi');
        });
    }
};