<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));
        });
    }

    public static function redirectToBasedOnRole()
    {
        if (!auth()->check()) {
            return '/';
        }

        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return '/admin/dashboard';
        }
        if ($user->hasRole('kasir')) {
            return '/kasir/dashboard';
        }
        if ($user->hasRole('bar')) {
            return '/bar/dashboard';
        }
        if ($user->hasRole('kitchen')) {
            return '/kitchen/dashboard';
        }
        if ($user->hasRole('pelanggan')) {
            return '/dashboard/pelanggan';
        }

        return '/dashboard';
    }
}
