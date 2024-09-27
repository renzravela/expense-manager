<?php

namespace App\Providers;

use App\Http\Middleware\CheckUserType;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\ServiceProvider;

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
        Vite::prefetch(concurrency: 3);
        Inertia::share([
            'auth.user' => function () {
                return Auth::user() ? [
                    'id' => Auth::user()->id,
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'user_type' => Auth::user()->user_type,
                ] : null;
            },
        ]);
        $this->app['router']->aliasMiddleware('checkUserType', CheckUserType::class);
    }


}
