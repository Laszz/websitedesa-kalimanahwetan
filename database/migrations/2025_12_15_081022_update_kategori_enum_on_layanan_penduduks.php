<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {

    public function up(): void
    {
        DB::statement("
            ALTER TABLE layanan_penduduks
            MODIFY kategori ENUM(
                'layanan_administrasi_penduduk',
                'layanan_administrasi_umum',
                'layanan_hukum_tanah'
            ) NOT NULL
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE layanan_penduduks
            MODIFY kategori ENUM('adminduk') NOT NULL
        ");
    }
};
