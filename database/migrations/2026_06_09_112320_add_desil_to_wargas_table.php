<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->tinyInteger('desil')->unsigned()->nullable()->after('pekerjaan');
            $table->index('desil');
        });
    }

    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropIndex(['desil']);
            $table->dropColumn('desil');
        });
    }
};