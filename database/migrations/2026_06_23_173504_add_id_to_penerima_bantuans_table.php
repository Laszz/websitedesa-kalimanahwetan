<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('penerima_bantuans', 'id')) {
            Schema::table('penerima_bantuans', function (Blueprint $table) {
                $table->unsignedBigInteger('id')->first();
            });
            
            DB::statement('ALTER TABLE penerima_bantuans MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('penerima_bantuans', 'id')) {
            Schema::table('penerima_bantuans', function (Blueprint $table) {
                $table->dropColumn('id');
            });
        }
    }
};