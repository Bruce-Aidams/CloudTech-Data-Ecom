

<?php $__env->startSection('title', 'Order Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Order Management</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Coordinate logistics and monitor data deliveries.
                </p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                
                <a href="<?php echo e(route('admin.orders.export', request()->all())); ?>"
                    class="h-11 px-6 bg-emerald-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-200/50 hover:bg-emerald-700 active:scale-95 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Export
                </a>

                
                <div class="relative flex-1 md:w-80 group">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-primary transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Search reference, phone, customer..."
                        value="<?php echo e(request('search')); ?>"
                        class="h-11 w-full pl-10 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-medium outline-none focus:ring-4 focus:ring-primary/10 transition-all">
                </div>
            </div>
        </div>

        <?php if(request('user_id')): ?>
            <?php $filteredUser = \App\Models\User::find(request('user_id')); ?>
            <?php if($filteredUser): ?>
                <div
                    class="flex items-center gap-3 bg-primary/5 border border-primary/10 px-4 py-2.5 rounded-2xl w-fit animate-in fade-in slide-in-from-left-4 duration-500">
                    <div
                        class="w-8 h-8 rounded-lg bg-primary text-white flex items-center justify-center font-black text-xs shadow-lg shadow-primary/20">
                        <?php echo e(strtoupper(substr($filteredUser->name, 0, 1))); ?>

                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 leading-none">Filtering Protocol
                        </p>
                        <p class="text-sm font-black text-slate-900 dark:text-white mt-1"><?php echo e($filteredUser->name); ?>'s Ledger</p>
                    </div>
                    <a href="<?php echo e(route('admin.orders')); ?>"
                        class="ml-2 p-1.5 hover:bg-rose-50 dark:hover:bg-rose-900/20 text-slate-400 hover:text-rose-600 rounded-lg transition-all"
                        title="Clear Filter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        
        <div class="flex flex-col gap-4">
            
            <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto scrollbar-hide">
                <?php
                    $statusMap = ['all' => 'All Status', 'awaiting_transfer' => 'Awaiting Transfer', 'pending' => 'Validating', 'processing' => 'Processing', 'completed' => 'Delivered', 'failed' => 'Failed'];
                ?>
                <?php $__currentLoopData = ['all', 'awaiting_transfer', 'pending', 'processing', 'completed', 'failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button onclick="filterBy('status', '<?php echo e($s); ?>')" class="px-4 py-2 rounded-lg text-xs font-bold capitalize transition-all whitespace-nowrap
                                                                                                                        <?php echo e(request('status', 'all') == $s
                    ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm'
                    : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'); ?>">
                            <?php echo e($statusMap[$s]); ?>

                        </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="flex items-center gap-3">
                
                <div
                    class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto scrollbar-hide">
                    <button onclick="filterBy('network', 'all')" class="px-4 py-2 rounded-lg text-xs font-bold capitalize transition-all whitespace-nowrap
                                                                        <?php echo e(request('network', 'all') == 'all'
        ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm'
        : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'); ?>">
                        All Networks
                    </button>
                    <?php $__currentLoopData = $networks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $network): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <button onclick="filterBy('network', '<?php echo e($network); ?>')" class="px-4 py-2 rounded-lg text-xs font-bold uppercase transition-all whitespace-nowrap
                                                                                                                        <?php echo e(request('network') == $network
                        ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm'
                        : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'); ?>">
                                    <?php echo e($network); ?>

                                </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if(request()->anyFilled(['status', 'network', 'user_id', 'search'])): ?>
                    <a href="<?php echo e(route('admin.orders')); ?>"
                        class="px-4 py-2 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-rose-100 transition-all flex items-center gap-2">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        Clear All
                    </a>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-7 gap-4">
            
            <div class="p-4 rounded-2xl border border-primary/20 bg-primary/5 shadow-sm flex items-center justify-between group transition-all cursor-pointer hover:bg-primary/10 hover:scale-[1.02] active:scale-95"
                onclick="window.location.href='<?php echo e(route('admin.orders')); ?>'">
                <div>
                    <p class="text-[11px] font-black uppercase tracking-widest text-primary/60">Global Stream</p>
                    <p class="text-2xl font-black tabular-nums text-primary"><?php echo e($totalFilteredOrders); ?></p>
                </div>
                <div
                    class="w-10 h-10 rounded-xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                </div>
            </div>

            <?php $__currentLoopData = $networks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $net): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $count = $networkCounts[$net] ?? 0;
                    $netColors = [
                        'MTN' => 'bg-amber-400 text-amber-950 border-amber-500/50',
                        'Telecel' => 'bg-rose-600 text-white border-rose-700/50',
                        'AirtelTigo' => 'bg-sky-600 text-white border-sky-700/50',
                        'AT' => 'bg-sky-600 text-white border-sky-700/50',
                    ];
                    $nc = $netColors[$net] ?? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white border-slate-100 dark:border-slate-800';
                ?>
                <?php if($count > 0): ?>
                    <div class="p-4 rounded-2xl border shadow-sm flex items-center justify-between group transition-all cursor-pointer <?php echo e($nc); ?> hover:scale-[1.02] active:scale-95"
                        onclick="filterBy('network', '<?php echo e($net); ?>')">
                        <div>
                            <p class="text-[11px] font-black uppercase tracking-widest opacity-80"><?php echo e($net); ?></p>
                            <p class="text-2xl font-black tabular-nums"><?php echo e($count); ?></p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="relative" x-data="{ loading: false }">
            <!-- Helper for loading overlay if needed in future ajax -->
            <div x-show="loading"
                class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl"
                style="display: none;">
                <svg class="animate-spin h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <!-- Mobile: Card View (2-Column Grid) -->
            <div class="grid grid-cols-2 md:hidden gap-3 p-4">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $net = $order->bundle->network ?? '';
                        $netCardColors = [
                            'MTN' => 'bg-amber-50/50 border-amber-200/50 dark:bg-amber-900/5 dark:border-amber-800/30',
                            'Telecel' => 'bg-rose-50/50 border-rose-200/50 dark:bg-rose-900/5 dark:border-rose-800/30',
                            'AT' => 'bg-sky-50/50 border-sky-200/50 dark:bg-sky-900/5 dark:border-sky-800/30',
                            'AirtelTigo' => 'bg-sky-50/50 border-sky-200/50 dark:bg-sky-900/5 dark:border-sky-800/30',
                        ];
                        $ncc = $netCardColors[$net] ?? 'bg-white dark:bg-slate-900 border-slate-100 dark:border-slate-800';

                        $statuses = [
                            'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                            'processing' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400 border-blue-200 dark:border-blue-800',
                            'completed' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800',
                            'failed' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/40 dark:text-rose-400 border-rose-200 dark:border-rose-800',
                        ];
                        $sc = $statuses[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                    ?>
                    <div class="<?php echo e($ncc); ?> p-4 rounded-2xl border shadow-sm space-y-3 relative overflow-hidden group">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-[9px] font-black text-slate-400 tracking-tighter uppercase">Ref:
                                <?php echo e(substr($order->reference, 0, 8)); ?></span>
                            <span
                                class="text-[9px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($order->created_at->format('M d, H:i')); ?></span>
                        </div>

                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded bg-slate-900 dark:bg-white flex items-center justify-center text-white dark:text-slate-900 font-black text-[10px]">
                                    <?php echo e(strtoupper(substr($order->user->name ?? '?', 0, 1))); ?>

                                </div>
                                <p
                                    class="text-[11px] font-black text-slate-900 dark:text-white uppercase truncate leading-none">
                                    <?php echo e($order->user->name); ?>

                                </p>
                            </div>
                            <div class="flex items-center justify-between pt-1">
                                <p class="text-[10px] font-black text-slate-500 truncate"><?php echo e($order->bundle->name); ?></p>
                                <span
                                    class="px-1.5 py-0.5 rounded text-[8px] font-black uppercase <?php echo e($nc ?? ''); ?>"><?php echo e($net); ?></span>
                            </div>
                            <p class="text-xs font-black tracking-tighter text-slate-900 dark:text-white">
                                ₵<?php echo e(number_format($order->cost, 2)); ?></p>
                        </div>

                        <div
                            class="w-full text-center py-2 rounded-xl <?php echo e($sc); ?> text-[8px] font-black uppercase tracking-[0.2em] border shadow-sm">
                            <?php echo e($statusLabels[$order->status] ?? $order->status); ?>

                        </div>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false"
                                class="w-full h-9 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-black text-[9px] uppercase active:scale-95 transition-all shadow-lg shadow-slate-900/10 dark:shadow-none">Manage
                                Protocol</button>
                            <div x-show="open" x-cloak
                                class="absolute right-0 bottom-full mb-3 w-40 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 z-30 p-1.5 animate-in slide-in-from-bottom-2 duration-200">
                                <?php $__currentLoopData = ['pending', 'processing', 'completed', 'failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button onclick="updateStatus(<?php echo e($order->id); ?>, '<?php echo e($st); ?>')"
                                        class="w-full text-left px-4 py-2.5 rounded-xl text-[9px] font-black uppercase hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors <?php echo e($order->status === $st ? 'text-primary' : 'text-slate-500'); ?>">
                                        Mark as <?php echo e($statusLabels[$st] ?? $st); ?>

                                    </button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-2 text-center py-12">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">No activity found</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($orders->hasPages()): ?>
                <div class="pt-4">
                    <?php echo e($orders->links()); ?>

                </div>
            <?php endif; ?>
            <!-- Desktop: Table View -->
            <div
                class="hidden md:block bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Order ID</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Customer</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Bundle Info</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                                    Cost</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-mono text-sm font-bold text-primary">#<?php echo e(substr($order->reference, 0, 12)); ?>...</span>
                                            <span
                                                class="text-[10px] text-slate-500 dark:text-slate-500 mt-1 uppercase tracking-tighter"><?php echo e($order->created_at->format('M d, H:i')); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold text-[10px]">
                                                <?php echo e(strtoupper(substr($order->user->name, 0, 1))); ?>

                                            </div>
                                            <div>
                                                <p class="font-bold text-sm text-slate-900 dark:text-white leading-none">
                                                    <?php echo e($order->user->name); ?>

                                                </p>
                                                <p class="text-[10px] text-slate-500 dark:text-slate-500 mt-1">
                                                    <?php echo e($order->user->phone); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 uppercase border border-slate-200 dark:border-slate-700">
                                                <?php echo e($order->bundle->network); ?>

                                            </span>
                                            <div class="flex flex-col">
                                                <span
                                                    class="text-sm font-semibold text-slate-900 dark:text-slate-200"><?php echo e($order->bundle->name); ?></span>
                                                <span
                                                    class="text-[10px] text-slate-500 font-mono"><?php echo e($order->recipient_phone); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">GHC
                                            <?php echo e(number_format($order->cost, 2)); ?>

                                        </p>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php
                                            $statuses = [
                                                'pending' => 'bg-amber-50 dark:bg-amber-900/20 text-amber-600',
                                                'processing' => 'bg-blue-50 dark:bg-blue-900/20 text-blue-600',
                                                'completed' => 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600',
                                                'failed' => 'bg-rose-50 dark:bg-rose-900/20 text-rose-600',
                                            ];
                                            $sc = $statuses[$order->status] ?? 'bg-slate-50 dark:bg-slate-800 text-slate-600';
                                        ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tight <?php echo e($sc); ?>">
                                            <?php echo e($statusLabels[$order->status] ?? $order->status); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2" x-data="{ open: false }">
                                            <div class="relative">
                                                <button @click="open = !open" @click.outside="open = false"
                                                    class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 hover:bg-primary/5 dark:hover:bg-primary/10 text-slate-400 hover:text-primary transition-all flex items-center justify-center">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                        </path>
                                                    </svg>
                                                </button>

                                                <div x-show="open" x-cloak
                                                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-100 dark:border-slate-800 z-10 p-1 animate-in slide-in-from-top-2 duration-200">
                                                    <?php $__currentLoopData = ['pending', 'processing', 'completed', 'failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $st): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <button onclick="updateStatus(<?php echo e($order->id); ?>, '<?php echo e($st); ?>')"
                                                            class="w-full text-left px-3 py-2 rounded-lg text-xs font-bold capitalize hover:bg-slate-50 dark:hover:bg-slate-800 border-none <?php echo e($order->status === $st ? 'text-primary' : 'text-slate-600 dark:text-slate-400'); ?>">
                                                            Mark as <?php echo e($statusLabels[$st] ?? $st); ?>

                                                        </button>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-600">
                                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                            <p class="font-medium">No order activity recorded</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if($orders->isNotEmpty()): ?>
            <div
                class="px-6 py-4 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                <div class="text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-widest italic">Global
                    Stream: <?php echo e($orders->total()); ?> Records</div>
                <div><?php echo e($orders->links()); ?></div>
            </div>
        <?php endif; ?>
    </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function filterBy(key, value) {
                const url = new URL(window.location.href);
                if (value === 'all') {
                    url.searchParams.delete(key);
                } else {
                    url.searchParams.set(key, value);
                }
                // Reset page on filter change
                url.searchParams.delete('page');
                window.location.href = url.href;
            }

            async function updateStatus(orderId, status) {
                if (!confirm(`Update order #${orderId} to ${status}?`)) return;

                try {
                    const response = await fetch(`<?php echo e(url('admin/orders')); ?>/${orderId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ status })
                    });

                    if (response.ok) {
                        window.location.reload();
                    } else {
                        const data = await response.json();
                        alert(data.message || 'Verification Error');
                    }
                } catch (e) {
                    alert('Network Communication Error');
                }
            }

            document.getElementById('searchInput').addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    const url = new URL(window.location.href);
                    url.searchParams.set('search', this.value);
                    window.location.href = url.href;
                }
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>