<?php

use App\Http\Controllers\Admin\AdminVendorController;
use App\Http\Controllers\Admin\CustomerAddressController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\UserController;

use Illuminate\Support\Facades\Route;

Route::prefix('ecommerce/admin')->name('admin.')->group(function () {

    Route::prefix('auth')->group(function () {

        Route::view('/register', 'admin.auth.register');
        Route::post('/register', [AdminController::class, 'register'])->name('register');

        Route::view('/login', 'admin.auth.login');
        Route::post('/login', [AdminController::class, 'login'])->name('login');

        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

        Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    });

    Route::middleware(['authenticate:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        Route::prefix('customers')->name('user.')->group(function () {
            Route::get('/',  [UserController::class, 'index'])->name('list');
            Route::get('/create',  [UserController::class, 'create'])->name('create');
            Route::post('/',  [UserController::class, 'store'])->name('store');
            Route::delete('/{client}', [UserController::class, 'destroy'])->name('destroy');
            Route::get('/{client}/edit',  [UserController::class, 'edit'])->name('edit');
            Route::put('/{client}',  [UserController::class, 'update'])->name('update');


            Route::prefix('address')->name('address.')->group(function () {
                Route::get('/',  [CustomerAddressController::class, 'index'])->name('list');
                Route::get('/create',  [CustomerAddressController::class, 'create'])->name('create');
                Route::post('/',  [CustomerAddressController::class, 'store'])->name('store');
                Route::delete('/{address}', [CustomerAddressController::class, 'destroy'])->name('destroy');
                Route::get('/{address}/edit',  [CustomerAddressController::class, 'edit'])->name('edit');
                Route::put('/{address}',  [CustomerAddressController::class, 'update'])->name('update');
            });
        });

        Route::prefix('vendors')->name('vendor.')->group(function () {
            Route::get('/', [AdminVendorController::class, 'index'])->name('list');
            Route::get('/create', [AdminVendorController::class, 'create'])->name('create');
            Route::get('/pending-approvals', [AdminVendorController::class, 'pending'])->name('pending');
            Route::post('/create', [AdminVendorController::class, 'store'])->name('store');
            Route::get('/{vendor}/edit', [AdminVendorController::class, 'edit'])->name('edit');
            Route::put('/{vendor}/edit', [AdminVendorController::class, 'update'])->name('update');
            Route::delete('/{vendor}', [AdminVendorController::class, 'destroy'])->name('destroy');
            Route::get('/{vendor}/view', [AdminVendorController::class, 'show'])->name('view');
            // Route::get('/{vendor}/products', [VendorController::class, 'products'])->name('products');
            // Route::get('/{vendor}/orders', [VendorController::class, 'orders'])->name('orders');
            // Route::get('/{vendor}/earnings', [VendorController::class, 'earnings'])->name('earnings');

            // // Verification
            // Route::get('/{vendor}/verification', [VendorController::class, 'verification'])->name('verification.view');
            // Route::post('/{vendor}/verify', [VendorController::class, 'verify'])->name('verify');
            // Route::post('/{vendor}/reject-verification', [VendorController::class, 'rejectVerification'])->name('verification.reject');
        });

        // Coman Module Routes
        require __DIR__ . '/coman/category.php';
        require __DIR__ . '/coman/subcategory.php';
        require __DIR__ . '/coman/catalog.php';
        require __DIR__ . '/coman/product.php';

        // Route::prefix('orders')->name('orders.')->group(function () {
        //     Route::get('/', [OrderController::class, 'index'])->name('list');
        // });

    });
});
