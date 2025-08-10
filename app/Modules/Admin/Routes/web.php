<?php

use App\Modules\Admin\app\Http\Controllers\Admin\AdminController;
use App\Modules\Admin\app\Http\Controllers\Auth\AuthController;
use App\Modules\Admin\app\Http\Controllers\Plans\FeaturesController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . "/admins",
        "as" => "admin.",
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', "web"],
    ],
    function () {
        Route::resource("admins", AdminController::class);
        Route::get("login", [AuthController::class, 'getLogin'])->name('login');
        Route::post("login", [AuthController::class, 'login']);

        Route::middleware('auth:admin')->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('/admins/profile/edit', [AdminController::class, 'edit'])->name('profile.edit');
            Route::resource("features", FeaturesController::class);


            /**************************change status Routes********************/
            Route::prefix("change_status")->group(function () {
                Route::get("features/{feature}", [FeaturesController::class, 'changeStatus'])->name('features.change_status');
            });
            /**************************change status Routes********************/

        });
    });
