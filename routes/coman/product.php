<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\BaseProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('product')->name('products.')->group(function () {
    Route::get('/', [BaseProductController::class, 'index'])->name('list');
    Route::delete('/', [BaseProductController::class, 'bulkDelete'])->name('bulk-delete');
    Route::get('/pending-approval', [ProductController::class, 'pendingApprovals'])->name('pendingApprovals');
    Route::get('/create', [BaseProductController::class, 'create'])->name('create');
    Route::post('/create', [BaseProductController::class, 'store'])->name('store');
    Route::put('/bulk-products-approved', [ProductController::class, 'bulkApprove'])->name('bulk.approve');
    Route::get('/{product}', [BaseProductController::class, 'edit'])->name('edit');
    Route::delete('/{product}', [BaseProductController::class, 'destroy'])->name('destroy');
    Route::put('/{product}', [BaseProductController::class, 'update'])->name('update');
    Route::put('/{product}/status', [ProductController::class, 'toggleStatus'])->name('status');
    Route::put('/{product}/approved-product', [ProductController::class, 'approvedProduct'])->name('approved');
});
