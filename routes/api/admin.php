<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClothingItemController;
use App\Http\Controllers\ClothingTypeController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\Store\SectionController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\SubscriptionOfferController;
use Illuminate\Support\Facades\Route;

/**
 * Prefix Here Should : api/admin
 *
 */

Route::prefix('stores')
    ->controller(StoreController::class)
    ->group(function () {
        Route::post('/', 'store');
        Route::put('/{store}', 'update');
        Route::delete('/{store}', 'delete');
        Route::delete('/{store}/image', 'deleteImage');
        Route::delete('/{store}/work-hours/{weekDay}', 'deleteWorkHour');

        /**
         * Clothing items Routes related to store
         */
        Route::post('/{store}/clothing-items', [ClothingItemController::class, 'create']);

    });
Route::prefix('clothing-items')
    ->controller(ClothingItemController::class)
    ->group(function () {
        Route::put('/{clothingItem}', 'update');
        Route::delete('/{clothingItem}', 'delete');

    });

Route::prefix('clothing-types')
    ->controller(ClothingTypeController::class)
    ->group(function () {
        Route::post('/', 'create');
        Route::put('/{clothingType}', 'update');
        Route::delete('/{clothingType}', 'delete');
    });

Route::prefix('sections')
    ->controller(SectionController::class)
    ->group(function () {
        Route::post('/', 'store');
        Route::put('/{section}', 'update');
        Route::delete('/{section}', 'delete');
    });

Route::prefix('employees')
    ->controller(EmployeeController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/', 'create');
        Route::delete('/{id}', 'delete');
    });

Route::prefix('off-yaba-offers')
    ->controller(SubscriptionOfferController::class)
    ->group(function () {
        Route::post('/', 'store');
        Route::put('/{offer}', 'update');
        Route::delete('/{offer}', 'delete');
    });

Route::controller(AdminController::class)
    ->group(function () {
        Route::post('/', 'update');
        Route::delete('/', 'delete');
    });
Route::prefix('/qr-code')
    ->controller(QrCodeController::class)
    ->group(function () {
        Route::post('/create', 'create');
    });

//Route::prefix('/clothi')
