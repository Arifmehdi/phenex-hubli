<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Auth\AuthController; // Import the newly created AuthController
use App\Http\Controllers\Api\ProductController; // Import ProductController
use App\Http\Controllers\Api\ProductCategoryController; // Import ProductCategoryController
use App\Http\Controllers\Api\CartController; // Import CartController
use App\Http\Controllers\Api\OrderController; // Import OrderController
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);

// Public API routes for products and product categories (index and show will be public)
Route::apiResource('products', ProductController::class);
Route::get('products/{product}/overview', [ProductController::class, 'overview']); // New route for product overview
Route::get('products/{product}/no-description', [ProductController::class, 'withoutDescription']); // New route for product without description
Route::get('products-no-description', [ProductController::class, 'indexWithoutDescription']); // New route for all products without description
Route::apiResource('product-categories', ProductCategoryController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthController::class, 'logout']);
    Route::get('/user', [ApiAuthController::class, 'me']);

    // Authenticated API routes for Cart and Orders
    Route::apiResource('cart', CartController::class)->only(['index', 'store', 'destroy']);
    Route::apiResource('orders', OrderController::class)->only(['index', 'store', 'show']);
});



