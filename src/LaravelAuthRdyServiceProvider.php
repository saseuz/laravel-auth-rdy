<?php

namespace Saseuz\LaravelAuthRdy;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Saseuz\LaravelAuthRdy\Http\Middleware\AdminAuthenticate;

class LaravelAuthRdyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'adminauth');

        // Migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('admin.auth', AdminAuthenticate::class);

        Blade::if('adminCan', function ($permission) {
            $user = auth('admin')->user();
            return $user && $user->can($permission);
        });

        $this->publishes([
            __DIR__ . '/../config' => config_path(),
            __DIR__ . '/../database/seeders' => database_path('seeders'),
        ], 'install-adminauth');
    }

    public function register()
    {
    }
}