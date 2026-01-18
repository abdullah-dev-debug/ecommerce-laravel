<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Assets\BrandController;
use Illuminate\Routing\Route;

require __DIR__ . '/attributes.php';

Route::prefix('catalog')->name('catalog.')->group(function () {

    Route::prefix('brands')->name('brand.')->group(function () {
        Route::get('/', [BrandController::class, 'index'])->name('list');
        Route::get('/create', [BrandController::class, 'create'])->name('create');
        Route::post('/', [BrandController::class, 'store'])->name('store');
        Route::get('/{brand}', [BrandController::class, 'edit'])->name('edit');
        Route::delete('/{brand}', [BrandController::class, 'destroy'])->name('destroy');
        Route::put('/{brand}', [BrandController::class, 'update'])->name('update');
        Route::put('//{brand}/status', [BrandController::class, 'toggleStatus'])->name('status');
    });

    Route::get('/vendor', [ProductController::class, 'vendorProducts'])->name('vendor');
    Route::get('/inventory', [ProductController::class, 'inventory'])->name('inventory');

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('list');
        Route::post('/', [ReviewController::class, 'store'])->name('store');
        Route::get('/{review}', [ReviewController::class, 'edit'])->name('edit');
        Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });

});
