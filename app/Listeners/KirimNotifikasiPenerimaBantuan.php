<?php

namespace App\Listeners;

use App\Events\PenerimaBantuanDitambahkan;
use App\Models\Notification;

class KirimNotifikasiPenerimaBantuan
{
    public function handle(PenerimaBantuanDitambahkan $event): void
    {
        $penerima = $event->penerimaBantuan;
        $warga = $penerima->warga;
        $jenisBantuan = $penerima->jenisBantuan;

        if (!$warga || !$warga->user_id) {
            return;
        }

        $sudahAda = Notification::where('user_id', $warga->user_id)
            ->where('title', 'Penerima Bantuan Baru')
            ->where('message', 'like', "%{$jenisBantuan->nama_bantuan}%")
            ->where('created_at', '>=', now()->subMinutes(10))
            ->exists();

        if ($sudahAda) {
            return;
        }

        Notification::create([
            'user_id' => $warga->user_id,
            'title' => 'Penerima Bantuan Baru',
            'message' => "Anda terdaftar sebagai penerima {$jenisBantuan->nama_bantuan} (Desil {$penerima->desil})",
            'url' => route('warga.penerimabantuan.show', $penerima->id),
            'is_read' => false,
        ]);
    }
}