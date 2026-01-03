<?php

use App\Http\Controllers\Assets\BrandController;
use App\Http\Controllers\FeaturedProductController;
use App\Http\Controllers\ProductManageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VendorProductController;

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

    Route::get('/vendor-products', [VendorProductController::class, 'index'])->name('vendor.products');
    Route::get('/featured-products', [FeaturedProductController::class, 'index'])->name('featured.products');
    Route::get('/inventory', [ProductManageController::class, 'inventory'])->name('inventory');

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('list');
        Route::post('/', [ReviewController::class, 'store'])->name('store');
        Route::get('/{review}', [ReviewController::class, 'edit'])->name('edit');
        Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });

});