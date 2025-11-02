<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('v1')->group(function () {

    // Public: Only read
    Route::get('categories', [CategoryApiController::class, 'index']);
    Route::get('categories/{id}', [CategoryApiController::class, 'show']);
    Route::get('products', [ProductApiController::class, 'index']);
    Route::get('products/{id}', [ProductApiController::class, 'show']);

    // Protected: Write operations
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('categories', [CategoryApiController::class, 'store']);
        Route::put('categories/{id}', [CategoryApiController::class, 'update']);
        Route::delete('categories/{id}', [CategoryApiController::class, 'destroy']);

        Route::post('products', [ProductApiController::class, 'store']);
        Route::put('products/{id}', [ProductApiController::class, 'update']);
        Route::delete('products/{id}', [ProductApiController::class, 'destroy']);

        Route::get('/user', fn(Request $request) => $request->user());
    });
});