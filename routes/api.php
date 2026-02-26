<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\MenuItemController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ReservationController;
use App\Http\Controllers\API\TableController;
use App\Http\Controllers\API\StockController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\UserController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/menu-items', [MenuItemController::class, 'index']);
Route::get('/menu-items/{id}', [MenuItemController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/tables/available', [TableController::class, 'available']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Client routes
    Route::get('/user/orders', [OrderController::class, 'userOrders']);
    Route::get('/user/reservations', [ReservationController::class, 'userReservations']);
    Route::apiResource('orders', OrderController::class)->except(['index', 'destroy']);
    Route::apiResource('reservations', ReservationController::class)->except(['index', 'destroy']);

    // Manager + Admin routes
    Route::middleware('role:admin,manager')->group(function () {
        Route::apiResource('tables', TableController::class)->except(['index']);
        Route::get('/all-orders', [OrderController::class, 'index']);
        Route::get('/all-reservations', [ReservationController::class, 'index']);
        Route::apiResource('stocks', StockController::class);
        Route::post('/payments/process', [PaymentController::class, 'process']);
    });

    // Admin only routes
    Route::middleware('role:admin')->group(function () {
        Route::apiResource('categories', CategoryController::class)->except(['index']);
        Route::apiResource('menu-items', MenuItemController::class)->except(['index', 'show']);
        Route::apiResource('users', UserController::class);
        Route::put('/users/{user}/role', [UserController::class, 'updateRole']);
    });
});