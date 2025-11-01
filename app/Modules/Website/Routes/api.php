<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\RestPasswordController;
use App\Modules\Website\app\Http\Controllers\Auth\AuthController;
use App\Modules\Website\app\Http\Controllers\Brand\BrandController;
use App\Modules\Website\app\Http\Controllers\Cart\CartController;
use App\Modules\Website\app\Http\Controllers\Category\CategoryController;
use App\Modules\Website\app\Http\Controllers\Faq\FaqController;
use App\Modules\Website\app\Http\Controllers\FavouriteProduct\FavouriteProductController;
use App\Modules\Website\app\Http\Controllers\Header\HeaderController;
use App\Modules\Website\app\Http\Controllers\HomeSection\HomeSectionController;
use App\Modules\Website\app\Http\Controllers\Option\OptionController;
use App\Modules\Website\app\Http\Controllers\Order\OrderController;
use App\Modules\Website\app\Http\Controllers\PaymentMethod\PaymentMethodController;
use App\Modules\Website\app\Http\Controllers\Privacy\PrivacyController;
use App\Modules\Website\app\Http\Controllers\Products\ProductVariationController;
use App\Modules\Website\app\Http\Controllers\Term\TermController;
use App\Modules\Website\app\Http\Controllers\WebStatus\WebStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/site')->middleware(['set.organization.context'])->group(function () {
    // Auth Routes
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    //        Route::get('google', [SocialAuthController::class, 'redirectToGoogle']);
    //        Route::get('google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
    //        Route::get('apple', [SocialAuthController::class, 'redirectToApple']);
    //        Route::get('apple/callback', [SocialAuthController::class, 'handleAppleCallback']);

    /*****************************************REST PASSWORD******************************************/
//    Route::post('send_otp', [RestPasswordController::class, 'sendOtp']);
//    Route::post('check_otp', [RestPasswordController::class, 'checkOtp'])->name('check_otp');
//    Route::post('rest_password', [RestPasswordController::class, 'resetPassword']);
//    Route::post('resend_otp', [RestPasswordController::class, 'resendOtp']);

    // Protected Routes
//    Route::middleware('auth:sanctum')->group(function () {
//        Route::get('logout', [AuthController::class, 'logout']);
//
//        // Email Verification Routes
//        Route::post('email/verification-notification', [EmailVerificationController::class, 'sendVerificationEmail']
//        )
//            ->middleware('throttle:6,1')
//            ->name('verification.send');
//
//        Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
//            ->middleware('signed')
//            ->name('verification.verify');
//    });

    /** Category & Brand Endpoints */
    Route::controller(CategoryController::class)->group(function () {
        Route::post('fetch_categories', 'index');
        Route::post('list_categories', 'list');
        Route::get('show_category/{id}', 'show');
    });
    Route::controller(BrandController::class)->group(function () {
        Route::post('fetch_brands', 'index');
        Route::post('list_brands', 'list');
        Route::get('show_brand/{id}', 'show');
    });

    /** Product Variation */
    Route::controller(ProductVariationController::class)->group(function () {
        Route::post('fetch_products', 'index');
        Route::get('show_products/{id}', 'show');
    });

    /** Terms Endpoints */
    Route::controller(TermController::class)->group(function () {
        Route::post('fetch_terms', 'fetch_terms');
    });

    /** FAQ Endpoints */
    Route::controller(FaqController::class)->group(function () {
        Route::post('fetch_faqs', 'fetch_faqs');
    });

    /** Header Endpoints */
    Route::controller(HeaderController::class)->group(function () {
        Route::post('fetch_header', 'fetch_header');
    });

    /** WebStatus Endpoints */
    Route::controller(WebStatusController::class)->group(function () {
        Route::post('fetch_web_status', 'fetch_web_status');
    });

    /** Privacy Endpoints */
    Route::controller(PrivacyController::class)->group(function () {
        Route::post('fetch_privacy', 'fetch_privacy');
    });

    /** HomeSection Endpoints */
    Route::controller(HomeSectionController::class)->group(function () {
        Route::post('fetch_home_sections', 'fetch_home_sections');
        Route::post('fetch_section_products', 'fetch_section_products');
    });

    Route::middleware('auth:sanctum')->group(function () {
        /** FavouriteProduct Endpoints */
        Route::controller(FavouriteProductController::class)->group(function () {
            Route::post('toggle_favourite', 'toggle_favourite');
            Route::post('fetch_my_favourites', 'fetch_my_favourites');
        });

        /** Cart Endpoints */
        Route::controller(CartController::class)->group(function () {
            Route::post('store_cart', 'store_cart');
            Route::post('update_cart_item', 'update_cart_item');
            Route::post('delete_cart_item', 'delete_cart_item');
            Route::post('clear_cart', 'clear_cart');
            Route::post('get_my_cart', 'get_my_cart');
            Route::post('apply_coupon_code', 'apply_coupon_code');
        });

        /** Order Endpoints */
        Route::controller(OrderController::class)->group(function () {
            Route::post('store_order', 'store');
            Route::post('fetch_my_orders', 'fetch_my_orders');
            Route::post('show_order', 'show_order');
            Route::post('update_order', 'update_order');
            Route::post('delete_order', 'delete_order');
        });
    });

    /** Option Endpoints */
    Route::controller(OptionController::class)->group(function () {
        Route::post('fetch_options', 'index');
    });

    /** Payment Method EndPoint */
    Route::controller(PaymentMethodController::class)->group(function () {
        Route::post('fetch_payment_methods', 'index');
    });
});
