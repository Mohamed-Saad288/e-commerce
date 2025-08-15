<?php

use App\Modules\Organization\app\Http\Controllers\Auth\AuthController;
use App\Modules\Organization\app\Http\Controllers\Brand\BrandController;
use App\Modules\Organization\app\Http\Controllers\Category\CategoryController;
use App\Modules\Organization\app\Http\Controllers\Employee\EmployeeController;
use App\Modules\Organization\app\Http\Controllers\Home\HomeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . "/organizations",
        'middleware' => [
            'localeSessionRedirect',
            'localizationRedirect',
            'localeViewPath',
            'web',
        ],
    ],
    function () {

        // Guest routes (not logged in)
        Route::middleware('guest:organization_employee')->group(function () {
            Route::get('login', [AuthController::class, 'getLogin'])->name('organization.login');
            Route::post('login', [AuthController::class, 'login'])->name('organization.login.submit');
        });

        // Authenticated routes
        Route::middleware('auth:organization_employee')
            ->as('organization.')
            ->group(function () {
                Route::get('/', [HomeController::class, 'home'])->name('home');
                Route::post('logout', [AuthController::class, 'logout'])->name('logout');
                Route::get('profile', [HomeController::class, 'profile'])->name('profile');
                Route::get('user_profile', [HomeController::class, 'user_profile'])->name('user_profile');
                Route::resource('categories', CategoryController::class);
                Route::resource('brands', BrandController::class);
                Route::resource('employees', EmployeeController::class);
            });
    }
);
