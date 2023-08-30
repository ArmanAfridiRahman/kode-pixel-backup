<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {

    
        try {
            $hitLimit = site_settings('api_route_rate_limit');
            RateLimiter::for('api', function (Request $request) use($hitLimit) {
                return Limit::perMinute($hitLimit)->by($request->user()?->id ?: $request->ip());
            });
        } catch (\Throwable $th) {

        }
      
        
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));


            Route::middleware('web')
                ->group(base_path('routes/payment.php'));

            Route::middleware('web')
                ->group(base_path('routes/admin.php'));

                Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
