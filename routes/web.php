<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\FeaturedProductController;

Route::get('/', [FeaturedProductController::class, 'trending']);


Route::post('/checkout', [OrderController::class, 'stripeCheckout'])
    ->name('stripe.checkout');

Route::get('/payment/success', [OrderController::class, 'stripeSuccess'])
    ->name('stripe.success');

Route::get('/payment/cancel', [OrderController::class, 'stripeCancel'])
    ->name('stripe.cancel');


require __DIR__ . '/admin.php';
