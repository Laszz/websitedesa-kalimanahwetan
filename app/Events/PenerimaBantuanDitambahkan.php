<?php

namespace App\Events;

use App\Models\PenerimaBantuan;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PenerimaBantuanDitambahkan
{
    use Dispatchable, SerializesModels;

    public PenerimaBantuan $penerimaBantuan;

    public function __construct(PenerimaBantuan $penerimaBantuan)
    {
        $this->penerimaBantuan = $penerimaBantuan;
    }
}