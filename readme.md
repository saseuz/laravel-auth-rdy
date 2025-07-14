1. install spatie laravel permission by following the doc 
    ```composer require spatie/laravel-permission```
    <br>
    Add this to `app\Providers\AppServiceProvider.php` <br>
    - ```Spatie\Permission\PermissionServiceProvider::class``` <br>
    then `php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"`

2. for uuid change in `model_has_permissions` and `model_has_roles`
```
    - $table->unsignedBigInteger($columnNames['model_morph_key']);
    + $table->uuid($columnNames['model_morph_key']);
```
then run `php artisan migrate`
<br>

Register middlewares in `boostrap/app.php`
```
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ]);
})
```

3. add this code in Providers/AppServiceProvider.php
```
    Gate::before(function ($user, $ability) {
        return $user->hasRole('super-admin') ? true : null;
    });
```

4. Install Laravel Auth Ready ...
Add this code in project composer.json
```
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/saseuz/laravel-auth-rdy"
    }
],
```

Use the package manager composer to install.
```
composer require saseuz/laravel-auth-rdy
```

Run this code in project to install configs and seeders
```
php artisan vendor:publish --tag=install-adminauth
```

And Migrate <br>
`php artisan migrate`

5. add these in config/auth.php
```
'guards' => [
    ...
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],

...

'providers' => [
    ...
    'admins' => [
        'driver' => 'eloquent',
        'model' => Saseuz\LaravelAuthRdy\Models\Admin::class,
    ],

```

Add this code to database/DatabaseSeeder.php
```
$this->call([
    DefaultAdminSeeder::class,
    PermissionSeeder::class,
]);
```
and Run ...
```
php artisan db:seed
```

6. Replace to routes/backend.php
```
<?php

use App\Http\Controllers\Backend\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\RoleController;

Route::group([
    'prefix' => admin_route(),
    'as'     => admin_route_name(),
    'middleware' => ['admin.auth']
], function() {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('site-settings', [DashboardController::class, 'settings'])->name('site-settings');

    Route::resource('roles', RoleController::class);
    Route::post('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('roles.permissions.update');

    Route::resource('admins', AdminController::class);
});
```

7. Replace Controller.php
```
<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    //
}

```

8. Replace code ..
To sidebar.blade.php
```
<!-- Main Sidebar Container -->
<aside class="main-sidebar main-sidebar-custom sidebar-light-primary elevation-4" id="main-sidebar">
    <!-- Brand Logo -->
    <a href="{{ route(admin_route_name().'dashboard') }}" class="brand-link" id="brand-link">
        <img src="{{ asset('adminlte/dist/img/Logo.png') }}" alt="{{ config('app.name') }} Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">{{ ucfirst(auth('admin')->user()->name) }}</a>
        </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            @php
                $sidebars = config('sidebar.backend');
            @endphp

            @isset($sidebars)
            @foreach($sidebars as $key => $sidebar)
                @if(!isset($sidebar['child-view']))
                    @adminCan(isset($sidebar['permission']) ? $sidebar['permission'] : '')
                    <li class="nav-item">
                        <a href="{{ route(admin_route_name().$sidebar['route']) }}" class="nav-link @if(active_state($sidebar['url'])) active @endif">
                            <i class="{{ $sidebar['icon'] }}"></i>
                            <p>
                                {{ $sidebar['name'] }}
                            </p>
                        </a>
                    </li>
                    @endadminCan
                @else
                    @adminCan(isset($sidebar['permission']) ? $sidebar['permission'] : '')
                        <li class="nav-item has-treeview @if(tree_active_state($sidebar['url'])) menu-open @endif">
                            <a href="#" class="nav-link @if(tree_active_state($sidebar['url'])) active @endif">
                                <i class="{{ $sidebar['icon'] }}"></i>
                                <p>
                                    {{ $sidebar['name'] }}
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                @foreach($sidebar['child-view'] as $key => $child)
                                    @adminCan(isset($child['permission']) ? $child['permission'] : '')
                                        <li class="nav-item">
                                            <a href="{{ route(admin_route_name().$child['route']) }}" class="nav-link @if(active_state($child['url'])) active @endif">
                                                <i class="{{ $child['icon'] }}"></i>
                                                <p>{{ $child['name'] }}</p>
                                            </a>
                                        </li>
                                    @endadminCan
                                @endforeach

                            </ul>
                        </li>
                    @endadminCan
                @endif
            @endforeach
            @endisset
        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    <div class="sidebar-custom">
        @adminCan('view-site-settings')
        <a href="{{ route(admin_route_name().'site-settings') }}" class="btn btn-link"><i class="fas fa-cogs"></i></a>
        @endadminCan
        {{-- <a href="#" class="btn btn-secondary hide-on-collapse pos-right">Help</a> --}}
    </div>
</aside>
```

To nav.blade.php
```
@php
  $admin = auth()->guard('admin')->user();
@endphp
<nav class="main-header navbar navbar-expand" id="navbar">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route(admin_route_name().'dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline">{{ ucfirst($admin->name) }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">

            <p>
              {{ ucfirst($admin->name) }} - {{ ucfirst($admin->roles[0]->name) }}
              <small>{{ $admin->created_at->format('d/M/Y') }}</small>
            </p>
          </li>
          <!-- Menu Body -->

          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
            <form action="{{ route(admin_route_name().'logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="btn btn-default btn-flat float-right">Sign out</button>
            </form>
          </li>
        </ul>
      </li>

    </ul>
</nav>
```