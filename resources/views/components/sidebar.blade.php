@php
    $menuItems = [
        ['name' => 'Dashboard', 'href' => '/dashboard', 'icon' => 'layout-dashboard', 'color' => 'indigo'],
        ['name' => 'Reseller Hub', 'href' => '/dashboard/reseller-hub', 'icon' => 'globe', 'color' => 'indigo', 'reseller_only' => true],
        ['name' => 'Customer Orders', 'href' => '/dashboard/reseller-hub/customer-orders', 'icon' => 'clipboard-list', 'color' => 'emerald', 'reseller_only' => true],
        ['name' => 'Usage Reports', 'href' => '/dashboard/analytics', 'icon' => 'bar-chart', 'color' => 'indigo'],
        ['name' => 'Buy Data', 'href' => '/dashboard/orders/new', 'icon' => 'shopping-cart', 'color' => 'orange'],
        ['name' => 'Order History', 'href' => '/dashboard/orders', 'icon' => 'clipboard-list', 'color' => 'blue'],
        ['name' => 'My Wallet', 'href' => '/dashboard/wallet', 'icon' => 'credit-card', 'color' => 'emerald'],
        ['name' => 'Billing & History', 'href' => '/dashboard/billing', 'icon' => 'credit-card', 'color' => 'emerald'],
        ['name' => 'Refer & Earn', 'href' => '/dashboard/referrals', 'icon' => 'users', 'color' => 'pink'],
        ['name' => 'Referral Earnings', 'href' => '/dashboard/commissions', 'icon' => 'activity', 'color' => 'amber'],
        ['name' => 'Transactions', 'href' => '/dashboard/transactions', 'icon' => 'clipboard-list', 'color' => 'amber'],
        ['name' => 'API Access', 'href' => '/dashboard/api-keys', 'icon' => 'key', 'color' => 'cyan'],
        ['name' => 'My Profile', 'href' => '/dashboard/profile', 'icon' => 'user', 'color' => 'teal'],
        ['name' => 'Settings', 'href' => '/dashboard/settings', 'icon' => 'settings', 'color' => 'rose'],
    ];

    $icons = [
        'layout-dashboard' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
        'globe' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>',
        'activity' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
        'shopping-cart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/>',
        'package' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
        'wallet' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
        'credit-card' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
        'gift' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V6a2 2 0 10-2 2h2zm0 8H4.3a2 2 0 00-2 2v3a2 2 0 002 2H12m0-7h7.7a2 2 0 012 2v3a2 2 0 01-2 2H12"/>',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
        'history' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'key' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>',
        'user' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
        'settings' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>',
        'clipboard-list' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
        'bar-chart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>',
    ];
@endphp

<aside
    class="h-screen bg-white dark:bg-slate-900 border-r border-slate-100 dark:border-slate-800 flex flex-col fixed left-0 top-0 z-50 transition-all duration-300 transform shadow-sm lg:shadow-none overflow-x-hidden group/sidebar"
    :class="[
           (sidebarOpen || !isCollapsed) ? 'w-64' : 'w-20',
           sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
       ]">

    <div class="flex items-center h-20 border-b border-slate-50 dark:border-slate-800/50 relative overflow-hidden"
        :class="(isCollapsed && !sidebarOpen) ? 'justify-center' : 'px-8'">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-transparent opacity-50"></div>
        <a href="{{ url('/dashboard') }}"
            class="flex items-center gap-4 group/logo whitespace-nowrap overflow-hidden relative z-10">
            <div class="shrink-0">
                <img src="{{ asset('favicon.ico') }}" alt="Logo"
                    class="w-8 h-8 rounded-lg shadow-sm group-hover/logo:scale-110 transition-all duration-500 bg-white p-1 ring-1 ring-slate-100 dark:ring-slate-800">
            </div>
            <div x-show="!isCollapsed || sidebarOpen" x-cloak
                class="flex flex-col animate-in fade-in slide-in-from-left-4 duration-500">
                <span
                    class="font-bold text-lg tracking-tight text-slate-900 dark:text-slate-100 leading-none group-hover/logo:text-primary transition-colors">CloudTech</span>
                <span
                    class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mt-1">Platform</span>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-8 space-y-1 overflow-y-auto custom-scrollbar overflow-x-hidden">
        @foreach($menuItems as $item)
            @if(isset($item['reseller_only']) && $item['reseller_only'] && !auth()->user()->isReseller())
                @continue
            @endif
            @php
                $isActive = request()->is(ltrim($item['href'], '/')) || (request()->is('dashboard') && $item['href'] === '/dashboard');
                // Active Colors Mapping
                $activeBgClass = 'bg-' . $item['color'] . '-500/10';
                $activeTextClass = 'text-' . $item['color'] . '-500';
                $activeShadowClass = 'shadow-lg shadow-' . $item['color'] . '-500/20';
            @endphp
            <a href="{{ url($item['href']) }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 group/nav {{ $isActive ? $activeBgClass . ' ' . $activeTextClass . ' ' . $activeShadowClass : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 border border-transparent' }}"
                :class="(isCollapsed && !sidebarOpen) && 'justify-center px-0 h-12 w-12 mx-auto'"
                :title="(isCollapsed && !sidebarOpen) ? '{{ $item['name'] }}' : ''">
                <span
                    class="shrink-0 transition-all duration-300 group-hover/nav:scale-110 {{ $isActive ? $activeTextClass : 'text-slate-400 group-hover/nav:text-' . $item['color'] . '-500' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $icons[$item['icon']] !!}
                    </svg>
                </span>
                <span x-show="!isCollapsed || sidebarOpen" x-cloak
                    class="text-[11px] font-bold uppercase tracking-wider transition-all duration-300 animate-in slide-in-from-left-2">{{ $item['name'] }}</span>
            </a>

            {{-- Dividers --}}
            @if($loop->index === 1 || $loop->index === 5 || $loop->index === 9)
                <div x-show="!isCollapsed || sidebarOpen" class="px-5 pt-6 pb-2">
                    <div class="h-px bg-slate-100 dark:bg-slate-800 flex-1"></div>
                </div>
            @endif
        @endforeach
    </nav>

    {{-- Footer/Logout --}}
    <div class="p-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 dark:text-slate-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400 transition-all duration-300 w-full group overflow-hidden border border-transparent font-bold text-[10px] uppercase tracking-widest"
                :class="(isCollapsed && !sidebarOpen) ? 'justify-center px-0 h-12 w-12 mx-auto' : ''">
                <svg class="w-5 h-5 shrink-0 transition-transform group-hover:scale-110" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!isCollapsed || sidebarOpen" x-cloak>Sign Out</span>
            </button>
        </form>
    </div>
</aside>