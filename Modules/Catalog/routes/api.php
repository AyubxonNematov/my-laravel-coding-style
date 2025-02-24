<?php

use Illuminate\Support\Facades\Route;
use Modules\Catalog\Http\Controllers\EnumController;
use Modules\Catalog\Http\Controllers\OptionController;
use Modules\Catalog\Http\Controllers\CategoryController;
use Modules\Catalog\Http\Controllers\SpecificationController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::prefix('v1/catalog')->group(function () {

    Route::apiResource('/categories', CategoryController::class);
    Route::get('/categories-tree', [CategoryController::class, 'getTree']);
    Route::get('/categories-search/{search}', [CategoryController::class, 'search']);
    Route::get('/categories-breadcrumbs/{leafCategory}', [CategoryController::class, 'getBreadcrumbs']);

    Route::apiResource('specifications', SpecificationController::class)->except('show');
    Route::apiResource('options', OptionController::class);

    Route::get('/enums/specification-types', [EnumController::class, 'getSpecificationTypes']);
});
