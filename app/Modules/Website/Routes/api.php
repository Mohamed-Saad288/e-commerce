<?php

use App\Modules\Website\app\Http\Controllers\Brand\BrandController;
use App\Modules\Website\app\Http\Controllers\Category\CategoryController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/site')->middleware(["set.organization.context"])->group(function () {
    Route::get('categories', [CategoryController::class, "list"]);
    Route::get("brands", [BrandController::class, "list"]);
});
