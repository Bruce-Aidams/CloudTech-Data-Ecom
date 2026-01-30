<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;

Route::middleware('guest')->group(function () {
    Route::get('login', function (Request $request) {
        if ($request->has('ref')) {
            session(['referred_by_code' => $request->ref]);
        }
        return view('auth.login');
    })->name('login');

    Route::post('login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user && trim(strtolower($user->role)) === 'admin') {
                return redirect()->route('admin.verify');
            }

            session()->flash('success', 'Welcome back, ' . $user->name . '!');
            return redirect()->intended('dashboard');
        }

        throw ValidationException::withMessages([
            'email' => trans('auth.failed'),
        ]);
    });

    Route::get('register', function (Request $request) {
        if ($request->has('ref')) {
            session(['referred_by_code' => $request->ref]);
        }
        return view('auth.register');
    })->name('register');

    Route::post('register', function (Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $referredBy = null;
        if (session()->has('referred_by_code')) {
            $referrer = User::where('referral_code', session('referred_by_code'))->first();
            $referredBy = $referrer ? $referrer->id : null;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => User::ROLE_USER,
            'wallet_balance' => 0.00,
            'is_active' => true,
            'referral_code' => strtoupper(Str::random(10)),
            'referred_by_id' => $referredBy,
        ]);

        Wallet::create([
            'user_id' => $user->id,
            'balance' => 0.00,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');

    Route::get('/dashboard', function () {
        $user = Auth::user();
        $balance = $user->wallet->balance ?? 0.00;
        $recentOrders = $user->orders()->with('bundle')->latest()->take(5)->get();

        $pendingTransactions = $user->transactions()
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subMinutes(30))
            ->get();

        return view('dashboard.index', compact('balance', 'recentOrders', 'pendingTransactions'));
    })->name('dashboard');

    Route::get('/dashboard/transactions', function (Request $request) {
        $transactions = $request->user()->transactions()->latest()->paginate(15);
        return view('dashboard.transactions', compact('transactions'));
    })->name('transactions.index');

    Route::get('/dashboard/orders/new', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.new');
    Route::get('/dashboard/notifications/poll', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.poll');
    Route::get('/products', [\App\Http\Controllers\OrderController::class, 'getBundles'])->name('api.bundles');
    Route::get('/networks', [\App\Http\Controllers\OrderController::class, 'getNetworks'])->name('api.networks');

    Route::get('/dashboard/orders/bulk', function () {
        $bundles = \App\Models\Bundle::all();
        $networks = \App\Models\Bundle::distinct()->pluck('network');
        return view('dashboard.orders.bulk', compact('bundles', 'networks'));
    })->name('orders.bulk');

    Route::get('/dashboard/orders/{order}', function ($id) {
        $order = Auth::user()->orders()->with('bundle')->findOrFail($id);
        return view('dashboard.orders.show', compact('order'));
    })->name('orders.show');

    Route::get('/dashboard/orders', [\App\Http\Controllers\OrderController::class, 'userOrders'])->name('orders.index');

    Route::post('/dashboard/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');

    Route::get('/dashboard/wallet', [\App\Http\Controllers\WalletController::class, 'wallet'])->name('wallet.index');

    Route::post('/dashboard/wallet/topup', [\App\Http\Controllers\WalletController::class, 'topup'])->name('wallet.topup');
    Route::post('/dashboard/wallet/manual', [\App\Http\Controllers\DepositController::class, 'store'])->name('wallet.manual');
    Route::get('/dashboard/wallet/callback', [\App\Http\Controllers\WalletController::class, 'verify'])->name('wallet.callback');

    Route::post('/dashboard/payouts', [\App\Http\Controllers\PayoutController::class, 'store'])->name('payouts.store');
    Route::get('/dashboard/paystack/verify', [\App\Http\Controllers\PaystackController::class, 'verifyPaymentWeb'])->name('paystack.verify');
    Route::get('/dashboard/wallet/verify-web', [\App\Http\Controllers\PaystackController::class, 'verifyPaymentWeb'])->name('wallet.verify_web');
    Route::get('/dashboard/billing/invoice/{id}', [\App\Http\Controllers\WalletController::class, 'invoice'])->name('billing.invoice');

    Route::get('/dashboard/commissions', function (Request $request) {
        $user = Auth::user();
        $balance = $user->commission_balance ?? 0.00;
        $stats = [
            'total_earned' => $user->transactions()->where('description', 'like', '%commission%')->sum('amount'),
            'total_referrals' => User::where('referred_by_id', $user->id)->count(),
        ];
        $payouts = $user->payouts ?? collect();
        $commissions = $user->transactions()->where('description', 'like', '%commission%')->latest()->paginate(15);
        return view('dashboard.commissions', compact('user', 'payouts', 'commissions', 'balance', 'stats'));
    })->name('commissions.index');

    Route::get('/dashboard/referrals', function (Request $request) {
        $user = Auth::user();
        $referrals = User::where('referred_by_id', $user->id)->latest()->paginate(15);
        return view('dashboard.referrals', compact('user', 'referrals'));
    })->name('referrals.index');

    Route::get('/dashboard/reseller-hub', [\App\Http\Controllers\ResellerHubController::class, 'index'])->name('reseller.hub');
    Route::get('/dashboard/reseller-hub/store', [\App\Http\Controllers\ResellerHubController::class, 'manageStore'])->name('reseller.store.manage');
    Route::post('/dashboard/reseller-hub/store/prices', [\App\Http\Controllers\ResellerHubController::class, 'updatePrice'])->name('reseller.store.update-price');
    Route::post('/dashboard/reseller-hub/store/toggle', [\App\Http\Controllers\ResellerHubController::class, 'toggleStoreStatus'])->name('reseller.store.toggle');
    Route::post('/dashboard/reseller-hub/store/regenerate', [\App\Http\Controllers\ResellerHubController::class, 'regenerateStoreLink'])->name('reseller.store.regenerate');

    Route::get('/dashboard/analytics', function (Request $request) {
        $user = Auth::user();
        $orders = $user->orders();

        $stats = [
            'total' => $orders->count(),
            'delivered' => $orders->where('status', 'completed')->count(),
            'validating' => $user->orders()->whereIn('status', ['pending', 'processing'])->count(),
            'failed' => $user->orders()->where('status', 'failed')->count(),
            'daily_orders' => $user->orders()
                ->selectRaw('date(created_at) as date, count(*) as count')
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->pluck('count', 'date'),
        ];

        return view('dashboard.analytics', compact('stats'));
    })->name('analytics.index');

    Route::get('/dashboard/billing', [\App\Http\Controllers\WalletController::class, 'billingHistory'])->name('billing.index');

    Route::get('/dashboard/api-keys', function (Request $request) {
        $apiKeys = $request->user()->apiKeys()->latest()->get();
        return view('dashboard.api-keys', compact('apiKeys'));
    })->name('api-keys.index');

    Route::post('/dashboard/api-keys', [App\Http\Controllers\ApiKeyController::class, 'generateKey'])->name('api-keys.store');
    Route::post('/dashboard/api-keys/{id}/regenerate', [App\Http\Controllers\ApiKeyController::class, 'regenerateKey'])->name('api-keys.regenerate');
    Route::delete('/dashboard/api-keys/{id}', [App\Http\Controllers\ApiKeyController::class, 'revokeKey'])->name('api-keys.destroy');

    Route::get('/dashboard/settings', function () {
        $user = Auth::user();
        return view('dashboard.settings', compact('user'));
    })->name('settings.index');

    Route::put('/dashboard/settings', function (Request $request) {
        $user = Auth::user();
        if ($request->has('current_password')) {
            $request->validate([
                'current_password' => ['required', 'current_password'],
                'new_password' => ['required', 'confirmed', 'min:8'],
            ]);
            $user->update(['password' => Hash::make($request->new_password)]);
            return back()->with('success', 'Security settings updated.');
        }

        $user->update($request->only(['notification_email', 'notification_sms']));
        return back()->with('success', 'System settings updated.');
    })->name('settings.update');

    Route::delete('/dashboard/settings', [App\Http\Controllers\UserController::class, 'destroy'])->name('settings.destroy');

    Route::get('/dashboard/profile', function () {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    })->name('profile.index');

    Route::put('/dashboard/profile', function (Request $request) {
        $user = Auth::user();
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'location' => 'nullable|string|max:255',
        ]);
        $user->update($data);
        return back()->with('success', 'Profile updated successfully.');
    })->name('profile.update');

    Route::post('/dashboard/profile/2fa', [App\Http\Controllers\UserController::class, 'toggle2FA'])->name('profile.toggle2fa');

    Route::post('/dashboard/orders/bulk', [App\Http\Controllers\OrderController::class, 'bulkStore'])->name('orders.bulk.store');
    // Notifications
    Route::get('/dashboard/notifications', [\App\Http\Controllers\NotificationController::class, 'userIndex'])->name('notifications.index');
    Route::post('/dashboard/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read_all');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');

    Route::get('/dashboard/paystack/initialize', [\App\Http\Controllers\PaystackController::class, 'initializePayment'])->name('paystack.initialize');

    // Admin Routes
    Route::middleware([\App\Http\Middleware\IsAdmin::class])->prefix('admin')->group(function () {
        Route::get('/verify', function (Request $request) {
            $intended = $request->query('intended', route('admin.index'));
            session(['admin_verified' => true]);
            return view('admin.verify', ['redirect_to' => $intended]);
        })->name('admin.verify');

        Route::get('/', [\App\Http\Controllers\AdminController::class, 'index']);
        Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');

        // Users Management
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('admin.users');
        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('admin.users.store');
        Route::put('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/users/{user}/toggle-status', [\App\Http\Controllers\UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
        Route::post('/users/{id}/wallet', [\App\Http\Controllers\AdminController::class, 'adjustWallet'])->name('admin.users.wallet');

        // Reseller Management
        Route::get('/resellers', [\App\Http\Controllers\AdminResellerController::class, 'index'])->name('admin.resellers.index');
        Route::post('/resellers/{id}/commission', [\App\Http\Controllers\AdminResellerController::class, 'adjustCommission'])->name('admin.resellers.commission');
        Route::post('/resellers/{id}/toggle-store', [\App\Http\Controllers\AdminResellerController::class, 'toggleStoreStatus'])->name('admin.resellers.toggle-store');

        // Referral Management
        Route::get('/referrals', [\App\Http\Controllers\ReferralController::class, 'adminIndex'])->name('admin.referrals');

        // Orders Management
        Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'adminIndex'])->name('admin.orders');
        Route::get('/orders/create', [\App\Http\Controllers\OrderController::class, 'adminCreate'])->name('admin.orders.create');
        Route::post('/orders/store', [\App\Http\Controllers\OrderController::class, 'adminStore'])->name('admin.orders.store');
        Route::get('/orders/{order}/edit', [\App\Http\Controllers\OrderController::class, 'adminEdit'])->name('admin.orders.edit');
        Route::put('/orders/{order}/update', [\App\Http\Controllers\OrderController::class, 'adminUpdate'])->name('admin.orders.update_v2');
        Route::delete('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'destroy'])->name('admin.orders.destroy');
        Route::get('/orders/export', [\App\Http\Controllers\OrderController::class, 'export'])->name('admin.orders.export');
        Route::put('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'update'])->name('admin.orders.update');
        Route::post('/orders/cleanup', [\App\Http\Controllers\AdminController::class, 'deleteOldOrders'])->name('admin.orders.cleanup');

        // Inventory/Bundles Management
        Route::get('/bundles', [\App\Http\Controllers\ProductController::class, 'adminIndex'])->name('admin.bundles');
        Route::post('/bundles', [\App\Http\Controllers\ProductController::class, 'store'])->name('admin.bundles.store');
        Route::put('/bundles/{bundle}', [\App\Http\Controllers\ProductController::class, 'update'])->name('admin.bundles.update');
        Route::delete('/bundles/{id}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('admin.bundles.destroy');

        // Deposits Management
        Route::get('/deposits', [\App\Http\Controllers\DepositController::class, 'index'])->name('admin.deposits');
        Route::put('/deposits/{id}', [\App\Http\Controllers\DepositController::class, 'update'])->name('admin.deposits.update'); // Assuming standard update for approval

        // Payouts Management
        Route::get('/payouts', [\App\Http\Controllers\PayoutController::class, 'adminIndex'])->name('admin.payouts');
        Route::post('/payouts/{id}/process', [\App\Http\Controllers\PayoutController::class, 'process'])->name('admin.payouts.process'); // Hypothetical, need to check PayoutController

        // Financials & Analytics
        Route::get('/financials', [\App\Http\Controllers\AdminController::class, 'transactions'])->name('admin.financials');
        Route::get('/financials/report', [\App\Http\Controllers\AdminController::class, 'getSalesReport'])->name('admin.financials.report');
        Route::get('/analytics', [\App\Http\Controllers\AdminController::class, 'analytics'])->name('admin.analytics');

        // API Management
        Route::get('/api-management', [\App\Http\Controllers\ApiController::class, 'index'])->name('admin.api');
        Route::post('/api-management/providers', [\App\Http\Controllers\ApiController::class, 'store'])->name('admin.api.providers.store');
        Route::put('/api-management/providers/{id}', [\App\Http\Controllers\ApiController::class, 'update'])->name('admin.api.providers.update');
        Route::delete('/api-management/providers/{id}', [\App\Http\Controllers\ApiController::class, 'destroy'])->name('admin.api.providers.destroy');

        // Notifications
        Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'adminIndex'])->name('admin.notifications');
        Route::post('/notifications', [\App\Http\Controllers\NotificationController::class, 'store'])->name('admin.notifications.store');
        Route::patch('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('admin.notifications.read');
        Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('admin.notifications.destroy');

        // Settings
        Route::get('/settings', [\App\Http\Controllers\AdminController::class, 'getSettings'])->name('admin.settings');
        Route::put('/settings', [\App\Http\Controllers\AdminController::class, 'updateSettings'])->name('admin.settings.update');
        Route::get('/settings/login-activities', [\App\Http\Controllers\AdminController::class, 'getLoginActivities'])->name('admin.settings.login-activities');
    });

    // Password Reset Routes
    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('forgot-password', [\App\Http\Controllers\AuthController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('reset-password/{token}', function (Request $request, $token) {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    })->name('password.reset');

    Route::post('reset-password', [\App\Http\Controllers\AuthController::class, 'resetPasswordBlade'])
        ->name('password.update');
});
