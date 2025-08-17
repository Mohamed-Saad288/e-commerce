<?php

use App\Modules\Organization\app\Http\Controllers\{About\AboutController,
    Auth\AuthController,
    Brand\BrandController,
    Category\CategoryController,
    Employee\EmployeeController,
    Header\HeaderController,
    Home\HomeController,
    Option\OptionController,
    OptionItem\OptionItemController,
    products\ProductController,
    Question\QuestionController,
    Term\TermController,
    Why\WhyController};
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
                Route::resource('options', OptionController::class);
                Route::resource('option_items', OptionItemController::class);
                Route::resource('products', ProductController::class);
                Route::resource('headers', HeaderController::class);
                Route::resource('questions', QuestionController::class);
                Route::resource('terms', TermController::class);
                Route::resource('abouts', AboutController::class);
                Route::resource('whys', WhyController::class);
            });
    }
);
