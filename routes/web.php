<?php

use App\Models\Bundle;

Route::get('/', function () {
    $bundles = Bundle::all(); // Or maybe filtering by verified/active?
    return view('home', compact('bundles'));
});

Route::get('/store/{referral_code}', [\App\Http\Controllers\StorefrontController::class, 'show'])->name('store.show');

Route::post('/webhooks/paystack', [\App\Http\Controllers\PaystackWebhookController::class, 'handle'])->name('webhooks.paystack');

require __DIR__ . '/auth.php';
