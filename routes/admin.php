<?php


use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;

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

        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/',  [UserController::class, 'index'])->name('list');
            Route::get('/create',  [UserController::class, 'create'])->name('create');
            Route::post('/',  [UserController::class, 'store'])->name('store');
            Route::delete('/{client}', [UserController::class, 'destroy'])->name('destroy');
            Route::get('/{client}/edit',  [UserController::class, 'edit'])->name('edit');
            Route::put('/{client}',  [UserController::class, 'update'])->name('update');
        });

        // Coman Module Routes
        require __DIR__ . '/coman/category.php';
        require __DIR__ . '/coman/subcategory.php';
        require __DIR__ . '/coman/catalog.php';
        require __DIR__ . '/coman/product.php';

        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('list');
        });
    });
});
