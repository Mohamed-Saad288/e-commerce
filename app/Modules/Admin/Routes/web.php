<?php

use App\Modules\Admin\app\Http\Controllers\Admin\AdminController;
use App\Modules\Admin\app\Http\Controllers\Auth\AuthController;
use App\Modules\Admin\app\Http\Controllers\Organization\OrganizationController;
use App\Modules\Admin\app\Http\Controllers\Plans\FeaturesController;
use App\Modules\Admin\app\Http\Controllers\Plans\PlansController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . "/admins",
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web'],
    ],
    function () {
        Route::resource("admins", AdminController::class);
        Route::resource("organizations", OrganizationController::class);
        Route::get("login", [AuthController::class, 'getLogin'])->name('login');
        Route::post("login", [AuthController::class, 'login']);
        Route::middleware('guest:admin')->group(function () {
            Route::get("login", [AuthController::class, 'getLogin'])->name('login');
            Route::post("login", [AuthController::class, 'login'])->name('admin.login');
        });

        // Authenticated admin routes
        Route::middleware('auth:admin')->as('admin.')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/admins/profile/edit', [AdminController::class, 'edit'])->name('profile.edit');
            Route::resource("features", FeaturesController::class);
            Route::resource("plans", PlansController::class);
            Route::resource("admins", AdminController::class);

            /**************************change status Routes********************/
            Route::prefix("change_status")->group(function () {
                Route::post("features/{feature}", [FeaturesController::class, 'changeStatus'])->name('features.change_status');
                Route::post("plans/{plan}", [PlansController::class, 'changeStatus'])->name('plans.change_status');
            });
            /**************************change status Routes********************/
        });
    }
);
