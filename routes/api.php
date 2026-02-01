<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ProductsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// public route
Route::post('login',[AuthController::class,'login']);

// 1. PUBLIC ROUTES (Anyone can see products)
Route::get('products', [ProductsController::class, 'index']);
Route::get('products/{id}', [ProductsController::class, 'show']);

// protected route
Route::get('/me',[AuthController::class,'me'])->middleware('auth:sanctum');

// 2. PROTECTED ROUTES (Only logged-in users can modify)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('products', [ProductsController::class, 'store']);
    Route::put('products/{id}', [ProductsController::class, 'update']);
    Route::delete('products/{id}', [ProductsController::class, 'destroy']);
});




//Route::apiResource('products', ProductsController::class);


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
