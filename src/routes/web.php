<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('order.index');
    Route::get('/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/create', [OrderController::class, 'store'])->name('order.store');
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/list', [ProductController::class, 'list'])->name('product.list');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/create', [ProductController::class, 'store'])->name('product.store');
    Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/edit/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::get('/ajax/list', [ProductController::class, 'ajaxList'])->name('product.ajax.list');
});

Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/list', [CustomerController::class, 'list'])->name('customer.list');
    Route::get('/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/create', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/edit/{customer}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/edit/{customer}', [CustomerController::class, 'update'])->name('customer.update');
    Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customer.destroy');
});
