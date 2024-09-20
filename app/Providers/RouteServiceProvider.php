<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = 'en/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // User API
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/User/api.php'));

            Route::prefix('mobile')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/Admin/mobile_api.php'));

            Route::prefix('web')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/Admin/web_api.php'));
            // // Admin Web
            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/Admin/web.php'));

            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/Admin/dashboard.php'));

            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/Admin/employee.php'));

            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/Admin/category.php'));

            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/Admin/comment.php'));

            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/Admin/post.php'));

            // Route::middleware('web')
            //     ->namespace($this->namespace)
            //     ->group(base_path('routes/Admin/baseSetting.php'));

        });
        Paginator::defaultView('vendor.pagination.custom');
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
}
