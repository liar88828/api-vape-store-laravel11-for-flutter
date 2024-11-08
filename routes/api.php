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

Route::apiResource('/trolley', TrolleyController::class);
Route::apiResource('/checkout', CheckoutController::class);
//Route::apiResource('/user', ProductController::class);
Route::apiResource('/favorite', FavoriteController::class);
Route::apiResource('/product', ProductController::class);
