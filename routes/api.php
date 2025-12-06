<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/settings', [SettingsController::class, 'index']);
    
    // Auth routes
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);
    
    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        
        // Cart
        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart', [CartController::class, 'store']);
        Route::put('/cart/{id}', [CartController::class, 'update']);
        Route::delete('/cart/{id}', [CartController::class, 'destroy']);
        
        // Orders
        Route::get('/orders', [OrderController::class, 'index']);
        Route::post('/checkout', [OrderController::class, 'checkout']);
        
        // Admin routes
        Route::prefix('admin')->group(function () {
            Route::get('/orders', [OrderController::class, 'adminOrders']);
            Route::post('/products', [OrderController::class, 'adminCreateProduct']);
            Route::put('/products/{id}', [OrderController::class, 'adminUpdateProduct']);
            Route::delete('/products/{id}', [OrderController::class, 'adminDeleteProduct']);
            
            Route::post('/settings', [SettingsController::class, 'update']);
            Route::post('/payments/confirm', [PaymentController::class, 'confirm']);
        });
    });
});