<?php

use App\Modules\Organization\app\Http\Controllers\About\AboutController;
use App\Modules\Organization\app\Http\Controllers\Auth\AuthController;
/**
 * --------------------------------------------------------------
 *  Organization Module Routes
 * --------------------------------------------------------------
 * These routes handle the organization dashboard for authenticated
 * organization employees and also provide guest routes for login.
 * --------------------------------------------------------------
 */

// #region Import Controllers (cleaned & grouped)
use App\Modules\Organization\app\Http\Controllers\Brand\BrandController;
use App\Modules\Organization\app\Http\Controllers\Category\CategoryController;
use App\Modules\Organization\app\Http\Controllers\Coupon\CouponController;
use App\Modules\Organization\app\Http\Controllers\Employee\EmployeeController;
use App\Modules\Organization\app\Http\Controllers\Header\HeaderController;
use App\Modules\Organization\app\Http\Controllers\Home\HomeController;
use App\Modules\Organization\app\Http\Controllers\HomeSection\HomeSectionController;
use App\Modules\Organization\app\Http\Controllers\Option\OptionController;
use App\Modules\Organization\app\Http\Controllers\OptionItem\OptionItemController;
use App\Modules\Organization\app\Http\Controllers\OrganizationSetting\OrganizationPaymentMethodController;
use App\Modules\Organization\app\Http\Controllers\OrganizationSetting\OrganizationSettingController;
use App\Modules\Organization\app\Http\Controllers\OurTeam\OurTeamController;
use App\Modules\Organization\app\Http\Controllers\Privacy\PrivacyController;
use App\Modules\Organization\app\Http\Controllers\products\ProductController;
use App\Modules\Organization\app\Http\Controllers\Question\QuestionController;
use App\Modules\Organization\app\Http\Controllers\Term\TermController;
use App\Modules\Organization\app\Http\Controllers\Why\WhyController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// #endregion

Route::group(
    [
        // Localized prefix, e.g. /en/organizations or /ar/organizations
        'prefix' => LaravelLocalization::setLocale().'/organizations',

        // Localization middlewares for translated views & URLs
        'middleware' => [
            'localeSessionRedirect',
            'localizationRedirect',
            'localeViewPath',
            'web',
        ],
    ],
    function () {

        /**
         * --------------------------------------------------------------
         * Guest Routes (accessible only when not logged in)
         * --------------------------------------------------------------
         */
        Route::middleware('guest:organization_employee')->group(function () {
            Route::get('login', [AuthController::class, 'getLogin'])->name('organization.login');
            Route::post('login', [AuthController::class, 'login'])->name('organization.login.submit');
        });

        /**
         * --------------------------------------------------------------
         * Export Routes
         * --------------------------------------------------------------
         * Handles data exports for products and other resources.
         */
        Route::get('products/export', [ProductController::class, 'export'])
            ->name('organization.products.export');

        /**
         * --------------------------------------------------------------
         * Authenticated Organization Routes
         * --------------------------------------------------------------
         * Only accessible for logged-in organization employees.
         */
        Route::middleware(['auth:organization_employee', 'set.organization.context'])
            ->as('organization.') // All routes under this group will be prefixed with "organization."
            ->group(function () {

                // #region Dashboard & Profile
                Route::get('/', [HomeController::class, 'home'])->name('home');
                Route::post('logout', [AuthController::class, 'logout'])->name('logout');
                Route::get('profile', [HomeController::class, 'profile'])->name('profile');
                Route::get('user_profile', [HomeController::class, 'user_profile'])->name('user_profile');
                Route::get('change_password', [HomeController::class, 'create_change_password'])->name('password.change');
                Route::post('store_change_password', [HomeController::class, 'store_change_password'])->name('password.store');
                // #endregion

                // #region CRUD Resources

                /** Search Route */
                Route::get('employees/search', [EmployeeController::class, 'search'])
                    ->name('employees.search');
                /** End Search Route */

                /** Categories Routes */
                Route::controller(CategoryController::class)->group(function () {
                    Route::get('categories/{id}/subcategories', 'subcategories')->name('categories.subcategories');
                    Route::get('categories/{id}/children', 'getChildren');
                    Route::get('categories/{id}/path', 'getCategoryPath');
                    Route::get("categories/roots", 'getRoots');
                    Route::get("categories/{id}/children", 'getChildren');
                    Route::get('categories/{id}/options', [CategoryController::class, 'getCategoryOptions']);
                    Route::get('categories/roots', 'getRoots');
                    Route::get('categories/{id}/children', 'getChildren');
                });

                Route::resources([
                    'categories' => CategoryController::class,
                    'brands' => BrandController::class,
                    'employees' => EmployeeController::class,
                    'options' => OptionController::class,
                    'option_items' => OptionItemController::class,
                    'products' => ProductController::class,
                    'questions' => QuestionController::class,
                    'abouts' => AboutController::class,
                    'whys' => WhyController::class,
                    'our_teams' => OurTeamController::class,
                    'home_sections' => HomeSectionController::class,
                    'coupons' => CouponController::class,
                ]);
                // #endregion

                // #region Settings Pages (single edit/update routes)
                Route::controller(OrganizationSettingController::class)->prefix('organization_settings')->name('organization_settings.')->group(function () {
                    Route::get('edit', 'edit')->name('edit');
                    Route::post('edit', 'update')->name('update');
                });

                Route::controller(HeaderController::class)->prefix('headers')->name('headers.')->group(function () {
                    Route::get('edit', 'edit')->name('edit');
                    Route::post('edit', 'update')->name('update');
                });

                Route::controller(PrivacyController::class)->prefix('privacy')->name('privacy.')->group(function () {
                    Route::get('edit', 'edit')->name('edit');
                    Route::post('edit', 'update')->name('update');
                });

                Route::controller(TermController::class)->prefix('terms')->name('terms.')->group(function () {
                    Route::get('edit', 'edit')->name('edit');
                    Route::post('edit', 'update')->name('update');
                });

                // #region Payment Methods
                Route::controller(OrganizationPaymentMethodController::class)->prefix('payment-methods')->name('payment_methods.')->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::put('/{id}', 'update')->name('update');
                });
                // #endregion

                // #region Status Change Routes
                Route::prefix('change_status')->group(function () {
                    Route::post('products/{product}', [ProductController::class, 'changeStatus'])
                        ->name('products.change_status');
                });
                // #endregion

                Route::post('coupons/{id}/toggle-status', [CouponController::class, 'toggleStatus'])
                    ->name('coupons.toggleStatus');

            });
    }
);
