<?php

use App\Models\Bundle;

Route::get('/', function () {
    $bundles = Bundle::all(); // Or maybe filtering by verified/active?
    return view('home', compact('bundles'));
});

Route::get('/store/{referral_code}', [\App\Http\Controllers\StorefrontController::class, 'show'])->name('store.show');

Route::post('/webhooks/paystack', [\App\Http\Controllers\PaystackWebhookController::class, 'handle'])->name('webhooks.paystack');

// Storefront Payment Routes
Route::post('/store/purchase', [\App\Http\Controllers\StorefrontPaymentController::class, 'initialize'])->name('store.purchase');
Route::get('/store/payment/callback', [\App\Http\Controllers\StorefrontPaymentController::class, 'callback'])->name('store.callback');

require __DIR__ . '/auth.php';
