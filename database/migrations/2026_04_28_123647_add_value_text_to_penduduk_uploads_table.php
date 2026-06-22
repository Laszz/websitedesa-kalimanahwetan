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
    Schema::table('penduduk_uploads', function (Blueprint $table) {
        $table->text('value_text')->nullable()->after('file_path');
    });
}

    /**
     * Reverse the migrations.
     */
public function down(): void
{
    Schema::table('penduduk_uploads', function (Blueprint $table) {
        $table->dropColumn('value_text');
    });
}
};
