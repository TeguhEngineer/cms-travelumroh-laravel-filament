<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        // Named limiter used by the "throttle:api" middleware on routes/api.php.
        RateLimiter::for("api", function (Request $request) {
            return Limit::perMinute((int) config("api.rate_limit", 120))->by(
                $request->ip(),
            );
        });
    }
}
