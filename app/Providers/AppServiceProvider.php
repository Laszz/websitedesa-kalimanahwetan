<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['layouts.app', 'layouts.admin'], function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                $notifications = $user->notification()
                    ->latest()
                    ->take(10)
                    ->get()
                    ->unique('id'); // Hindari duplikat jika ada
                
                $view->with('notifications', $notifications);
            }
        });
    }
}