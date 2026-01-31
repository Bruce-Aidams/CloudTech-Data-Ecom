<?php
    $menuItems = [
        ['name' => 'Dashboard', 'href' => '/admin', 'icon' => 'layout-dashboard', 'color' => 'indigo'],
        ['name' => 'Orders', 'href' => '/admin/orders', 'icon' => 'shopping-cart', 'color' => 'emerald'],
        ['name' => 'Inventory', 'href' => '/admin/bundles', 'icon' => 'package', 'color' => 'purple'],
        ['name' => 'Users', 'href' => '/admin/users', 'icon' => 'users', 'color' => 'blue'],
        ['name' => 'Resellers', 'href' => '/admin/resellers', 'icon' => 'user-group', 'color' => 'orange'],
        ['name' => 'Referrals', 'href' => '/admin/referrals', 'icon' => 'users', 'color' => 'pink'],
        ['name' => 'API Management', 'href' => '/admin/api-management', 'icon' => 'chip', 'color' => 'cyan'],
        ['name' => 'Analytics', 'href' => '/admin/analytics', 'icon' => 'bar-chart', 'color' => 'violet'],
        ['name' => 'Financials', 'href' => '/admin/financials', 'icon' => 'clipboard-list', 'color' => 'green'],
        ['name' => 'Deposits', 'href' => '/admin/deposits', 'icon' => 'banknotes', 'color' => 'teal'],
        ['name' => 'Payouts', 'href' => '/admin/payouts', 'icon' => 'landmark', 'color' => 'teal'],
        ['name' => 'Notifications', 'href' => '/admin/notifications', 'icon' => 'bell', 'color' => 'amber'],
        ['name' => 'Settings', 'href' => '/admin/settings', 'icon' => 'settings', 'color' => 'slate'],
    ];

    $icons = [
        'layout-dashboard' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
        'shopping-cart' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 0a2 2 0 100 4 2 2 0 000-4z"/></svg>',
        'package' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>',
        'users' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>',
        'user-group' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
        'chip' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>',
        'bar-chart' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
        'clipboard-list' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
        'banknotes' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
        'landmark' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>',
        'bell' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>',
        'settings' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
    ];

    $unreadNotifications = \App\Models\Notification::where('is_read', false)->count();
?>

<aside
    class="h-screen bg-white dark:bg-slate-900 border-r border-slate-100 dark:border-slate-800 flex flex-col fixed left-0 top-0 z-50 transition-all duration-300 transform overflow-x-hidden group/sidebar"
    :class="[
           isCollapsed ? 'w-20' : 'w-64',
           sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
       ]">

    
    <div class="flex items-center h-20 border-b border-slate-50 dark:border-slate-800/50 relative overflow-hidden"
        :class="(isCollapsed && !sidebarOpen) ? 'justify-center' : 'px-6'">
        <a href="<?php echo e(url('/admin')); ?>"
            class="flex items-center gap-3 group/logo whitespace-nowrap overflow-hidden relative z-10">
            <div class="shrink-0">
                <img src="<?php echo e(asset('favicon.ico')); ?>" alt="Logo"
                    class="w-8 h-8 rounded-lg shadow-sm group-hover/logo:scale-110 transition-all duration-500 bg-white p-1 ring-1 ring-slate-100 dark:ring-slate-800">
            </div>
            <div x-show="!isCollapsed || sidebarOpen" x-cloak
                class="flex flex-col animate-in fade-in slide-in-from-left-4 duration-500">
                <span
                    class="font-bold text-lg tracking-tight text-slate-900 dark:text-white leading-none">CloudTech</span>
                <span class="text-[10px] font-medium text-slate-400 mt-1 uppercase tracking-widest">Admin Portal</span>
            </div>
        </a>
    </div>

    
    <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto custom-scrollbar overflow-x-hidden">
        <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $isActive = request()->is(ltrim($item['href'], '/')) || (request()->is('admin') && $item['href'] === '/admin');
                $activeBgClass = 'bg-' . $item['color'] . '-500/10';
                $activeTextClass = 'text-' . $item['color'] . '-500';
            ?>
            <a href="<?php echo e(url($item['href'])); ?>"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group/nav relative <?php echo e($isActive ? $activeBgClass . ' ' . $activeTextClass : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800'); ?>"
                :class="(isCollapsed && !sidebarOpen) && 'justify-center h-12 w-12 mx-auto'"
                :title="(isCollapsed && !sidebarOpen) ? '<?php echo e($item['name']); ?>' : ''">

                
                <span
                    class="shrink-0 transition-all duration-200 <?php echo e($isActive ? $activeTextClass : 'text-slate-400 group-hover/nav:text-' . $item['color'] . '-500'); ?>">
                    <?php echo $icons[$item['icon']]; ?>

                </span>

                
                <span x-show="!isCollapsed || sidebarOpen" x-cloak
                    class="text-sm font-medium transition-all duration-200 truncate"><?php echo e($item['name']); ?></span>

                
                <?php if($item['icon'] === 'bell' && $unreadNotifications > 0): ?>
                    <span x-show="!isCollapsed || sidebarOpen" x-cloak
                        class="ml-auto inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-rose-500 rounded-lg shadow-sm">
                        <?php echo e($unreadNotifications > 9 ? '9+' : $unreadNotifications); ?>

                    </span>
                    <span x-show="(isCollapsed && !sidebarOpen)" x-cloak
                        class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white dark:border-slate-800 animate-pulse"></span>
                <?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </nav>

    
    <div class="p-4 border-t border-slate-50 dark:border-slate-800/50">
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <button type="submit"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 dark:hover:text-rose-400 transition-all duration-200 w-full group overflow-hidden"
                :class="(isCollapsed && !sidebarOpen) ? 'justify-center h-12 w-12 mx-auto' : ''">
                <svg class="w-5 h-5 shrink-0 transition-transform group-hover:-translate-x-0.5" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span x-show="!isCollapsed || sidebarOpen" x-cloak class="text-sm font-medium">Log out</span>
            </button>
        </form>
    </div>
</aside><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/components/admin-sidebar.blade.php ENDPATH**/ ?>