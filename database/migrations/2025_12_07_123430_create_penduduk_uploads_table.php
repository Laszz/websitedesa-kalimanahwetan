<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id'); // dari penduduk_requests
            $table->unsignedBigInteger('requirement_id'); // dari penduduk_requirements
            $table->string('file_path'); // lokasi filenya
            $table->timestamps();

            $table->foreign('request_id')
                  ->references('id')
                  ->on('penduduk_requests')
                  ->onDelete('cascade');

            $table->foreign('requirement_id')
                  ->references('id')
                  ->on('penduduk_requirements')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk_uploads');
    }
};
