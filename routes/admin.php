<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/verify', [OrderController::class, 'verify'])->name('orders.verify');
    Route::post('/orders/{order}/shipping', [OrderController::class, 'updateShipping'])->name('orders.shipping');
    Route::post('/orders/{order}/ship', [OrderController::class, 'ship'])->name('orders.ship');
    Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
    
    Route::resource('/products', ProductController::class);
    Route::resource('/categories', CategoryController::class)->except(['create', 'show', 'edit']);
    
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});
