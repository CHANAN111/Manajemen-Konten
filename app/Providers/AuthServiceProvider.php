<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // Gate untuk mengecek apakah user boleh mengelola user lain (hanya Admin)
        Gate::define('manage-users', function (User $user) {
            return $user->hasRole('Admin');
        });

        // Gate untuk mengecek apakah user boleh mengelola konten
        Gate::define('manage-content', function (User $user) {
            return $user->hasRole('Admin') 
                || $user->hasRole('Penulis Naskah') 
                || $user->hasRole('Dubber') 
                || $user->hasRole('Editor');
        });
        
        // Gate untuk mengecek apakah user boleh mengelola jadwal (hanya Admin)
        Gate::define('manage-schedules', function (User $user) {
            return $user->hasRole('Admin');
        });

        // Anda bisa menambahkan Gate lain di sini sesuai kebutuhan
    }
}
