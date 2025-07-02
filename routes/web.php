<?php

use Illuminate\Support\Facades\Route;
use Saseuz\LaravelAuthRdy\Http\Controllers\AuthController;

Route::group([
    'prefix' => admin_route(),
    'as'     => admin_route_name(),
    'middleware' => 'web',
], function() {

    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('admin.auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

});
