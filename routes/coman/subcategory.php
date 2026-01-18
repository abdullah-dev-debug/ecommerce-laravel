<?php

use App\Http\Controllers\Assets\SubCategoryController;
use Illuminate\Routing\Route;

Route::prefix('sub-category')->name('subcategories.')->group(function () {
    Route::get('/', [SubCategoryController::class, 'index'])->name('list');
    Route::get('/create', [SubCategoryController::class, 'create'])->name('create');
    Route::post('/', [SubCategoryController::class, 'store'])->name('store');
    Route::get('/{subcategory}', [SubCategoryController::class, 'edit'])->name('edit');
    Route::put('/{subcategory}', [SubCategoryController::class, 'update'])->name('update');
    Route::put('/{subcategory}/status', [SubCategoryController::class, 'toggleStatus'])->name('status');
    Route::delete('/{subcategory}', [SubCategoryController::class, 'destroy'])->name('destroy');
    Route::get('/by-category/{categoryId}', [SubCategoryController::class, 'getByCategory'])->name('by-category');

});