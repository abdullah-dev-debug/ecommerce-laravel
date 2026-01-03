<?php

use App\Http\Controllers\Assets\CategoryController;

Route::prefix('category')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('list');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/', [CategoryController::class, 'store'])->name('store');
    Route::get('/{category}', [CategoryController::class, 'edit'])->name('edit');
    Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
    Route::put('/{category}/status', [CategoryController::class, 'toggleStatus'])->name('status');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
});