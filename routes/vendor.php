<?php

use App\Http\Controllers\Auth\VendorController;
use App\Http\Controllers\Vendor\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('ecommerce/vendor')->name('vendor.')->group(function () {
    Route::prefix('auth')->group(function () {

        Route::view('/register', 'vendor.auth.register');
        Route::post('/register', [VendorController::class, 'register'])->name('register');

        Route::view('/login', 'vendor.auth.login');
        Route::post('/login', [VendorController::class, 'login'])->name('login');

        Route::get('/profile', [VendorController::class, 'profile'])->name('profile');

        Route::get('/logout', [VendorController::class, 'logout'])->name('logout');
    });

    Route::middleware(['authenticate:vendor'])->group(function () {
        Route::get('/dashboard', [VendorController::class, 'dashboard'])->name('dashboard');
        Route::prefix('/product')->name('product.')->group(function () {
            Route::get('/', [ProductController::class, 'myProducts'])->name('list');
            Route::get('/draft', [ProductController::class, 'draftProducts'])->name('draft');
            Route::post('/{product}/submit-for-approval', [ProductController::class, 'submitForApproval'])->name('send-approval-request');
        });
    });
});
