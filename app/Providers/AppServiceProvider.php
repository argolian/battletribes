<?php

namespace App\Providers;

use App\Http\Middleware\LaravelBlocker;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('checkblocked',[LaravelBlocker::class]);
    }
}
