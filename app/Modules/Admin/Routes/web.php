<?php

use App\Modules\Admin\app\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


    Route::group(
        [
            'prefix' => "admins/". LaravelLocalization::setLocale(),
            'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
        ],
        function () {
            Route::resource("admins", AdminController::class);
});
