<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrolleyController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//reference
//https://medium.com/@1415sandalanka/laravel-11-rest-api-crud-with-best-practices-fcc26505e0d2

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');


//Route::post('/tokens/create', function (Request $request) {
//    $token = $request->user()->createToken('test');
//    return response()->json(['token' => $token->plainTextToken], 200);
//});

Route::prefix('auth')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserController::class, 'logout']);
    });
    Route::controller(UserController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
//                Route::delete('logout', 'logout');
    });
});

Route::prefix('/trolley')->group(function () {
    Route::controller(TrolleyController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::get('/id-user/{id}', 'findByUserId');
        Route::get('/id-user/count/{id}', 'findByUserIdCount');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });
});
Route::apiResource('/checkout', CheckoutController::class);
//Route::apiResource('/user', ProductController::class);
Route::apiResource('/favorite', FavoriteController::class);
//Route::apiResource('/product', ProductController::class);


Route::prefix('/product')->group(function () {
    Route::controller(ProductController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/new-product', 'newProduct');
        Route::get('/favorite', 'favorite');
        Route::get('/flash-sale', 'flashSale');
        Route::get('/{id}', 'show');
        Route::get('/id-user/{id}', 'findByProductId');
        Route::post('/', 'create');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');

    });
});
