<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ClothingItemController;
use App\Http\Controllers\ClothingTypeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\Store\SectionController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\SubscriptionOfferController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/**
 * Prefix Here Should : api/
 *
 */

Route::middleware(['auth.any:user,employee,admin'])
    ->group(function () {
        Route::apiResource('items', ItemController::class);

        Route::prefix('stores')
            ->controller(StoreController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::get('/{store}', 'show');
                Route::get('/{store}/items', 'getStoreItems');
            });
        Route::prefix('clothing-items')
            ->controller(ClothingItemController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::get('/{clothingItem}', 'show');
                Route::get('/target-groups/get', 'targetGroups');
            });

        Route::prefix('clothing-types')
            ->controller(ClothingTypeController::class)
            ->group(function () {
                Route::get('/', 'index');
            });

        Route::prefix('sections')
            ->controller(SectionController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::get('/{section}', 'show');
            });

        Route::prefix('off-yaba-offers')
            ->controller(SubscriptionOfferController::class)
            ->group(function () {
                Route::get('/', 'index');
            });
    });

Route::prefix('/user')
    ->controller(UserController::class)
    ->middleware(['auth.any:user'])
    ->group(function () {
        Route::get('/', 'show');
        Route::put('/', 'update');
        Route::put('/verify-update', 'verifyUpdate');
        Route::delete('/delete', 'delete');
    });
Route::prefix('/qr-code')
    ->middleware(['auth.any:user'])
    ->controller(QrCodeController::class)
    ->group(function () {
        Route::get('/', 'index');
        Route::post('/user-scan', 'scan');
    });

Route::prefix('/cart')
    ->middleware(['auth.any:user'])
    ->controller(CartController::class)
    ->group(function () {
        Route::get('/', 'show');
        Route::post('/add', 'addItem');
        Route::delete('/remove/{itemId}', 'removeItem');
        Route::delete('/clear', 'clearCart');
        Route::post('/checkout', 'checkout');
    });

Route::middleware('auth.any:user')->group(function () {
    Route::get('/orders', [OrderController::class, 'getOrdersForUser']);
});
Route::middleware('auth.any:user')
    ->post(
        '/user/add-fcm-token',
        [UserController::class, 'addFirebaseToken']
    );

Route::get('/image/', ImageController::class);
