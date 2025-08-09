<?php

use App\Modules\Admin\app\Http\Controllers\Admin\AdminController;
use App\Modules\Admin\app\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . "/admins",
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', "web"],
    ],
    function () {
        Route::resource("admins", AdminController::class);
        Route::get("login", [AuthController::class, 'getLogin'])->name('admin.login');
        Route::post("login", [AuthController::class, 'login']);

        Route::middleware('auth:admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
            Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
            Route::get('/admins/edit', [AdminController::class, 'edit'])->name('admin.profile.edit');
        });
    });
