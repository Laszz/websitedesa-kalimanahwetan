<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\PenerimaBantuanDitambahkan::class => [
            \App\Listeners\KirimNotifikasiPenerimaBantuan::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}