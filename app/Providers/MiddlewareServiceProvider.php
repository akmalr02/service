<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\TeknisiMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
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
        // $router = $this->app['router'];

        // $router->aliasMiddleware('admin', AdminMiddleware::class);
        // $router->aliasMiddleware('teknisi', TeknisiMiddleware::class);
    }
}
