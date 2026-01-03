<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('list');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::delete('/', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::get('/{product}', [ProductController::class, 'edit'])->name('edit');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::put('/{product}/status', [ProductController::class, 'toggleStatus'])->name('status');
});
