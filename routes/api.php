<?php

use App\Http\Controllers\CheckoutController ;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrolleyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//reference
//https://medium.com/@1415sandalanka/laravel-11-rest-api-crud-with-best-practices-fcc26505e0d2

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
Route::apiResource('/trolley', TrolleyController::class);
Route::apiResource('/checkout', CheckoutController::class);
//Route::apiResource('/user', ProductController::class);
Route::apiResource('/favorite', FavoriteController::class);
Route::apiResource('/product', ProductController::class);
