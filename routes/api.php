<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\PayoutController;
use App\Http\Middleware\EnsureAccountActive;
use App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/verify-2fa', [AuthController::class, 'verifyTwoFactor']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::get('/products', [ProductController::class, 'index']); // Public list
Route::get('/networks', [ProductController::class, 'getNetworks']); // Dynamic network list
Route::get('/settings/public', [App\Http\Controllers\AdminController::class, 'getPublicSettings']);

// Protected Routes
Route::middleware(['auth:sanctum', EnsureAccountActive::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/me', [UserController::class, 'me']);
    Route::get('/user', [UserController::class, 'me']);
    Route::get('/referrals', [UserController::class, 'referrals']);
    Route::get('/commissions', [UserController::class, 'commissions']);

    // User Profile & Settings
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'updatePassword']);
    Route::put('/user/settings', [UserController::class, 'updateSettings']);
    Route::post('/user/toggle-2fa', [UserController::class, 'toggle2FA']);
    Route::post('/user/deactivate', [UserController::class, 'deactivateAccount']);

    // Wallet
    Route::get('/wallet', [WalletController::class, 'index']);
    Route::post('/wallet/topup', [WalletController::class, 'topup']);
    Route::get('/wallet/verify', [WalletController::class, 'verify']);

    // Paystack Payment
    Route::prefix('paystack')->group(function () {
        Route::post('/initialize', [PaystackController::class, 'initializePayment']);
        Route::get('/verify', [PaystackController::class, 'verifyPayment']);
        Route::get('/history', [PaystackController::class, 'getPaymentHistory']);
        Route::get('/public-key', [PaystackController::class, 'getPublicKey']);
    });

    // Payouts
    Route::get('/payouts', [PayoutController::class, 'index']);
    Route::post('/payouts', [PayoutController::class, 'store']);

    // API Key Management
    Route::prefix('api-keys')->group(function () {
        Route::get('/', [ApiKeyController::class, 'listKeys']);
        Route::post('/', [ApiKeyController::class, 'generateKey']);
        Route::delete('/{id}', [ApiKeyController::class, 'revokeKey']);
        Route::post('/{id}/regenerate', [ApiKeyController::class, 'regenerateKey']);
        Route::get('/{id}/stats', [ApiKeyController::class, 'getKeyStats']);
    });

    // Orders (User)
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/bulk', [OrderController::class, 'bulkStore']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    // Admin Routes
    Route::middleware(IsAdmin::class)->prefix('admin')->group(function () {
        Route::get('/check-role', function (Request $request) {
            return response()->json([
                'user' => $request->user(),
                'role' => $request->user()->role,
                'is_admin' => strtolower($request->user()->role) === 'admin'
            ]);
        });
        Route::get('/analytics', [App\Http\Controllers\AdminController::class, 'analytics']);
        Route::get('/dashboard-stats', [App\Http\Controllers\AdminController::class, 'getDashboardStats']);
        Route::get('/agent-stats', [App\Http\Controllers\AdminController::class, 'getAgentStats']);
        Route::get('/login-activities', [App\Http\Controllers\AdminController::class, 'getLoginActivities']);
        Route::post('/delete-old-orders', [App\Http\Controllers\AdminController::class, 'deleteOldOrders']);
        Route::get('/sales-report', [App\Http\Controllers\AdminController::class, 'getSalesReport']);

        Route::get('/transactions', [App\Http\Controllers\AdminController::class, 'transactions']); // New Financial Module

        // System Settings
        Route::get('/settings', [App\Http\Controllers\AdminController::class, 'getSettings']);
        Route::post('/settings', [App\Http\Controllers\AdminController::class, 'updateSettings']);

        // User Management
        Route::get('/users', [UserController::class, 'index']);
        Route::apiResource('users', UserController::class);
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPassword']);
        Route::post('users/{user}/adjust-wallet', [App\Http\Controllers\AdminController::class, 'adjustWallet']);

        // Order Management
        Route::get('/orders', [OrderController::class, 'adminIndex']);
        Route::get('/orders/{order}', [OrderController::class, 'show']);
        Route::put('/orders/{order}', [OrderController::class, 'update']);

        // Product Management
        Route::get('/products', [ProductController::class, 'adminIndex']); // Admin list all
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{bundle}', [ProductController::class, 'update']);
        Route::delete('/products/{id}', [ProductController::class, 'destroy']);

        // Deposit Management
        Route::get('/deposits', [App\Http\Controllers\DepositController::class, 'index']);
        Route::put('/deposits/{id}', [App\Http\Controllers\DepositController::class, 'update']);

        // Payout Management
        Route::get('/payouts', [PayoutController::class, 'adminIndex']);
        Route::put('/payouts/{id}', [PayoutController::class, 'updateStatus']);

        // Notification Management
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'adminIndex']);
        Route::post('/notifications', [App\Http\Controllers\NotificationController::class, 'store']);

        // API Management
        Route::get('/api-providers', [App\Http\Controllers\ApiController::class, 'index']);
        Route::post('/api-providers', [App\Http\Controllers\ApiController::class, 'store']);
        Route::put('/api-providers/{id}', [App\Http\Controllers\ApiController::class, 'update']);
        Route::delete('/api-providers/{id}', [App\Http\Controllers\ApiController::class, 'destroy']);
        Route::get('/api-logs', [App\Http\Controllers\ApiController::class, 'logs']);
    });
});


Route::post('/paystack/webhook', [PaystackController::class, 'handleWebhook']);
Route::post('/webhooks/incoming', [App\Http\Controllers\WebhookController::class, 'handle']);

// Public Status Endpoint (Outside auth middleware)
Route::get('/system/status', function () {
    return response()->json([
        'maintenance_mode' => \App\Models\Setting::where('key', 'maintenance_mode')->value('value') === '1',
        'message' => \App\Models\Setting::where('key', 'site_alert_message')->value('value')
    ]);
});
