<?php

use App\Modules\Organization\app\Http\Controllers\Auth\AuthController;
use App\Modules\Organization\app\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('organization')->middleware(["web"])->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('organization.home');
    Route::get("login", [AuthController::class, 'getLogin'])->name('organization.getLogin');
    Route::post("login", [AuthController::class, 'login'])->name("organization.login");

    Route::middleware('auth:organization_employee')->as('organization.')->group(function () {
        Route::post("logout", [AuthController::class, 'logout'])->name('logout');
        Route::get("profile", [HomeController::class, 'profile'])->name('profile');
        Route::get("user_profile", [HomeController::class, 'user_profile'])->name('user_profile');
    });
});
