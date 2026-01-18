<?php

use App\Http\Controllers\Customer\FeaturedProductController ;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;


Route::get('/', [FeaturedProductController::class, 'trending']);


Route::post('/checkout', [OrderController::class, 'stripeCheckout'])
    ->name('stripe.checkout');

Route::get('/payment/success', [OrderController::class, 'stripeSuccess'])
    ->name('stripe.success');

Route::get('/payment/cancel', [OrderController::class, 'stripeCancel'])
    ->name('stripe.cancel');


require __DIR__ . '/admin.php';
require __DIR__ . '/vendor.php';
