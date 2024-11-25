<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrolleyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//reference
//https://medium.com/@1415sandalanka/laravel-11-rest-api-crud-with-best-practices-fcc26505e0d2

Route::get('/user/{id}', [UserController::class, 'show']);
Route::prefix('auth')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::controller(UserController::class)->group(function () {

            Route::get('/user', 'getUser');
            Route::delete('/logout', function (Request $request) {
                return $request->user()->currentAccessToken()->delete();
            });
        });
    });

    Route::controller(UserController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });
});

Route::prefix('/trolley')->group(function () {
    Route::controller(TrolleyController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/id-checkout/{id}', 'findByCheckoutId');
        Route::get('/id-user/{id}', 'findByUserId');
        Route::get('/id-user/count/{id}', 'findByUserIdCount');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});

Route::prefix('/checkout')->group(function () {
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/id-user/{id}', 'findByIdUser');
        Route::get('/id-checkout/{id}', 'findAllCheckout');
        Route::get('/{id}', 'show');
        Route::post('/many', 'storeMany');
        Route::post('/one', 'storeOne');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});

Route::prefix('/favorite')->group(function () {
    Route::controller(FavoriteController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/id-user/count/{id}', 'findByIdUserCount');
        Route::get('/id-user/{id}', 'findByIdUser');
        Route::get('/id-list/{id}', 'findByIdList');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::post('/list/{id}', 'addToFavoriteList');
        Route::delete('/list/{id}', 'deleteToFavoriteList');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});

Route::prefix('/product')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/new-product', 'newProduct');
        Route::get('/favorite', 'favorite');
        Route::get('/flash-sale', 'flashSale');
        Route::get('/{id}', 'show');
//        Route::get('/id-user/{id}', 'findByProductId');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});

Route::prefix('/delivery')->group(function () {
    Route::controller(DeliveryController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});

Route::prefix('/bank')->group(function () {
    Route::controller(BankController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});
