<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Prajurit;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Paksa HTTPS saat production (Railway)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Pastikan variabel notifications didefinisikan
        View::composer('*', function ($view) {
            $prajuritNavbar = null;
            $notifications = collect();

            if (Auth::check()) {
                $prajuritNavbar = Prajurit::where('user_id', Auth::id())->first();

                if (Auth::user()->role === 'admin') {
                    $notifications = Notification::orderBy('created_at', 'desc')->take(10)->get();
                }
            }

            $view->with('prajuritNavbar', $prajuritNavbar);
            $view->with('notifications', $notifications);
        });
    }
}