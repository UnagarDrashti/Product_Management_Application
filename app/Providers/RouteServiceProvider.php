<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    public const HOME = '/dashboard';

    public function boot(): void
    {
        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    // Override redirect after login
    protected function redirectTo()
    {
        $user = Auth::user();
        return $user->role === 'admin' 
            ? route('admin.dashboard') 
            : route('customer.dashboard');
    }
}