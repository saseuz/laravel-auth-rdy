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

        // Super Admin Blade Directive
        // Usge: @superAdmin ... @endsuperAdmin
        Blade::if('superAdmin', function() {
            $user = auth('admin')->user();
            return $user && $user->hasRole('super-admin');
        });

        // Admin Can Blade Directive
        // Usage: @adminCan('permission_name') ... @endadminCan
        Blade::if('adminCan', function ($permission) {
            $user = auth('admin')->user();
            return $user && $user->canAny($permission);
        });

        $this->publishes([
            __DIR__ . '/../config' => config_path(),
            __DIR__ . '/../database/seeders' => database_path('seeders'),
            __DIR__ . '/Http/Controllers/Backend' => app_path('Http/Controllers/Backend'),
            __DIR__ . '/../resources/views/backend' => resource_path('views/backend'),
        ], 'install-adminauth');
    }

    public function register()
    {
    }
}