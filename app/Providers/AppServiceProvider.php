<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('orangtua.partials.header', function ($view) {
            $user = Auth::user();
            
            if ($user) {
                // Perbaikan: Mengganti ->belumDibaca() dengan ->where(...) manual
                // Ini lebih stabil dan menghindari error "Method not found"
                $unreadNotifications = Notifikasi::where('id_user', $user->id_user)
                    ->where('status_baca', 'Belum Dibaca') 
                    ->orderBy('tanggal_kirim', 'desc')
                    ->get();
            } else {
                $unreadNotifications = collect([]);
            }
            
            $view->with('unreadNotifications', $unreadNotifications);
        });
    }
}