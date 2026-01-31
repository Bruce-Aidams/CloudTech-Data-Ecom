

<?php $__env->startSection('title', 'Order History'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ loading: true }"
        x-init="setTimeout(() => loading = false, 800)">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 ring-1 ring-blue-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Order History
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">View and manage your recent data
                        bundle purchases.</p>
                </div>
            </div>
            <a href="<?php echo e(route('orders.new')); ?>"
                class="inline-flex items-center justify-center rounded-xl text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-sm">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Order
            </a>
        </div>

        <div class="rounded-2xl md:rounded-[2.5rem] border border-slate-100 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 shadow-sm overflow-hidden"
            x-data="{ showFilters: false }">
            <!-- Filter Section -->
            
            <div
                class="px-6 py-6 border-b border-slate-100 dark:border-slate-800 flex flex-wrap items-center justify-between gap-4 bg-slate-50/30 dark:bg-slate-950/20">
                <div class="flex items-center gap-3">
                    <button @click="showFilters = !showFilters"
                        class="h-10 px-5 rounded-xl bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 text-xs font-bold uppercase tracking-widest text-slate-600 dark:text-slate-400 hover:border-primary/50 transition-all flex items-center gap-2 shadow-sm">
                        <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': showFilters}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span x-text="showFilters ? 'Hide Filters' : 'Filters'"></span>
                    </button>

                    <?php if(request()->anyFilled(['search', 'status', 'network', 'start_date', 'end_date'])): ?>
                        <a href="<?php echo e(route('orders.index')); ?>"
                            class="h-10 px-4 rounded-xl bg-rose-50 dark:bg-rose-900/10 text-rose-600 dark:text-rose-400 text-[10px] font-bold uppercase tracking-widest hover:bg-rose-100 transition-all flex items-center gap-2 border border-rose-100 dark:border-rose-900/20">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Clear
                        </a>
                    <?php endif; ?>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden lg:block text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        Records: <?php echo e($orders->firstItem() ?? 0); ?>-<?php echo e($orders->lastItem() ?? 0); ?> of <?php echo e($orders->total()); ?>

                    </div>
                    <div class="flex items-center gap-2">
                        <?php echo e($orders->appends(request()->query())->links('pagination::simple-tailwind')); ?>

                    </div>
                </div>
            </div>

            
            <div x-show="showFilters" x-collapse x-cloak
                class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800">
                <div class="p-6 md:p-8">
                    <form action="<?php echo e(route('orders.index')); ?>" method="GET" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Search -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Search
                                    ID/Phone</label>
                                <div class="relative group">
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-primary transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                        placeholder="Reference code..."
                                        class="w-full h-11 pl-11 pr-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all outline-none">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</label>
                                <select name="status"
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="all">All Status</option>
                                    <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>
                                        Delivered</option>
                                    <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Validating
                                    </option>
                                    <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>
                                        Processing</option>
                                    <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>Failed
                                    </option>
                                </select>
                            </div>

                            <!-- Network -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Network</label>
                                <select name="network"
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all outline-none appearance-none cursor-pointer">
                                    <option value="all">All Networks</option>
                                    <?php $__currentLoopData = $networks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $network): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($network); ?>" <?php echo e(request('network') == $network ? 'selected' : ''); ?>>
                                            <?php echo e(strtoupper($network)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- Per Page -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">View
                                    Count</label>
                                <select name="per_page"
                                    class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 transition-all outline-none appearance-none cursor-pointer">
                                    <?php $__currentLoopData = [10, 15, 30, 50, 100]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($val); ?>" <?php echo e(request('per_page', 10) == $val ? 'selected' : ''); ?>>
                                            <?php echo e($val); ?> Per Page
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <!-- Date Range -->
                            <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                                <div class="space-y-2 text-left">
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-wider text-slate-400">From</label>
                                    <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>"
                                        class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white outline-none">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400">To</label>
                                    <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>"
                                        class="w-full h-11 px-4 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 text-xs font-bold text-slate-900 dark:text-white outline-none">
                                </div>
                            </div>

                            <div class="lg:col-span-2 flex items-end gap-3">
                                <button type="submit"
                                    class="flex-1 h-11 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all">
                                    Apply Filters
                                </button>
                                <a href="<?php echo e(route('orders.index')); ?>"
                                    class="h-11 px-6 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all flex items-center justify-center">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Dashboard Optimized Layouts -->
            <div class="relative">
                <!-- Desktop Table View (Hidden on Mobile) -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="text-[10px] text-slate-400 dark:text-slate-500 uppercase bg-slate-50/50 dark:bg-slate-950/20 border-b border-slate-200/50 dark:border-white/5">
                                <th class="px-8 py-5 font-black tracking-[0.2em]">Reference</th>
                                <th class="px-6 py-5 font-black tracking-[0.2em]">Package Info</th>
                                <th
                                    class="px-6 py-5 font-black tracking-[0.2em] border-x border-slate-100/50 dark:border-white/5 text-center">
                                    Recipient</th>
                                <th class="px-6 py-5 font-black tracking-[0.2em] text-right">Amount</th>
                                <th class="px-6 py-5 font-black tracking-[0.2em] text-center">Status</th>
                                <th class="px-6 py-5 font-black tracking-[0.2em] text-right">Timestamp</th>
                                <th class="px-8 py-5 font-black tracking-[0.2em] text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100/30 dark:divide-slate-800/30">
                            <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr
                                    class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all border-b border-slate-100/50 dark:border-slate-800/50">
                                    <td class="px-8 py-5">
                                        <span
                                            class="font-mono text-[11px] font-black text-primary tracking-tighter uppercase whitespace-nowrap bg-primary/5 px-2 py-1 rounded-md border border-primary/10">
                                            #<?php echo e(strtoupper(substr($order->reference, 0, 10))); ?>...
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex flex-col">
                                            <span
                                                class="text-sm font-black text-slate-900 dark:text-white"><?php echo e($order->bundle->name ?? 'Data Bundle'); ?></span>
                                            <span
                                                class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1"><?php echo e($order->bundle->network ?? 'GSM'); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 border-x border-slate-100/50 dark:border-white/5 text-center">
                                        <span
                                            class="text-sm font-black text-slate-900 dark:text-white font-mono tracking-widest"><?php echo e($order->recipient_phone); ?></span>
                                    </td>
                                    <td class="px-6 py-5 text-right whitespace-nowrap">
                                        <span
                                            class="text-sm font-black text-slate-900 dark:text-white tabular-nums">₵<?php echo e(number_format($order->cost, 2)); ?></span>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <?php
                                            $statusConfig = [
                                                'completed' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-600', 'label' => 'Delivered'],
                                                'failed' => ['bg' => 'bg-rose-500/10', 'text' => 'text-rose-600', 'label' => 'Failed'],
                                                'processing' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-600', 'label' => 'Processing'],
                                                'pending' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-600', 'label' => 'Validating'],
                                            ];
                                            $conf = $statusConfig[$order->status] ?? ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-600', 'label' => $order->status];
                                        ?>
                                        <span
                                            class="inline-flex items-center px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-tight <?php echo e($conf['bg']); ?> <?php echo e($conf['text']); ?> border border-transparent group-hover:border-current/20 transition-all">
                                            <?php echo e($conf['label']); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-5 text-right">
                                        <div class="flex flex-col items-end">
                                            <span
                                                class="text-[10px] font-black text-slate-900 dark:text-white uppercase"><?php echo e($order->created_at->format('M d, Y')); ?></span>
                                            <span
                                                class="text-[9px] font-medium text-slate-400 mt-0.5"><?php echo e($order->created_at->format('h:i A')); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="<?php echo e(route('orders.show', $order->id)); ?>"
                                                class="h-9 w-9 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl hover:bg-primary hover:text-white transition-all active:scale-90 border border-slate-100 dark:border-slate-800"
                                                title="View Ledger">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M9 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                            <?php if($order->status === 'completed'): ?>
                                                <a href="<?php echo e(route('billing.invoice', $order->id)); ?>"
                                                    class="h-9 w-9 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-xl hover:bg-emerald-600 hover:text-white transition-all active:scale-90 border border-slate-100 dark:border-slate-800"
                                                    title="View Invoice">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-8 py-24 text-center">
                                        <p class="text-[11px] font-black uppercase tracking-[0.3em] text-slate-300">No order
                                            activity recorded</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View (Hidden on Desktop) -->
                <div class="md:hidden p-4 space-y-4">
                    <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div
                            class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 p-5 space-y-4 shadow-sm relative overflow-hidden group active:scale-[0.98] transition-all">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-primary/5 rounded-bl-full pointer-events-none transition-transform group-hover:scale-110">
                            </div>

                            <div class="flex items-center justify-between relative">
                                <span
                                    class="font-mono text-[10px] font-black text-primary bg-primary/10 px-2.5 py-1 rounded-lg border border-primary/10">
                                    #<?php echo e(strtoupper(substr($order->reference, 0, 10))); ?>

                                </span>
                                <?php
                                    $conf = $statusConfig[$order->status] ?? ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-600', 'label' => $order->status];
                                ?>
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest <?php echo e($conf['bg']); ?> <?php echo e($conf['text']); ?> px-2 py-1 rounded-lg">
                                    <?php echo e($conf['label']); ?>

                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-end justify-between">
                                    <div class="space-y-1">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Data Package
                                        </p>
                                        <h4 class="text-sm font-black text-slate-900 dark:text-white">
                                            <?php echo e($order->bundle->name ?? 'Bundle'); ?>

                                        </h4>
                                        <p class="text-[9px] font-bold text-primary uppercase tracking-wider">
                                            <?php echo e($order->bundle->network ?? 'GSM'); ?>

                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1">Cost</p>
                                        <span
                                            class="text-lg font-black text-slate-900 dark:text-white tabular-nums">₵<?php echo e(number_format($order->cost, 2)); ?></span>
                                    </div>
                                </div>

                                <div
                                    class="pt-3 border-t border-slate-50 dark:border-slate-800 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-7 h-7 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center text-slate-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-xs font-black text-slate-600 dark:text-slate-400 font-mono"><?php echo e($order->recipient_phone); ?></span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="<?php echo e(route('orders.show', $order->id)); ?>"
                                            class="h-9 w-9 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 rounded-xl active:bg-primary active:text-white border border-slate-100 dark:border-slate-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                        <?php if($order->status === 'completed'): ?>
                                            <a href="<?php echo e(route('billing.invoice', $order->id)); ?>"
                                                class="h-9 w-9 flex items-center justify-center bg-slate-50 dark:bg-slate-800 text-slate-500 rounded-xl active:bg-emerald-600 active:text-white border border-slate-100 dark:border-slate-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="py-12 text-center text-[10px] font-black uppercase text-slate-300 tracking-widest">Zero
                            Transmission History</div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($orders->hasPages()): ?>
                <div
                    class="px-6 py-6 border-t border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-white/[0.02] flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        Records: <?php echo e($orders->firstItem() ?? 0); ?>-<?php echo e($orders->lastItem() ?? 0); ?> of <?php echo e($orders->total()); ?>

                    </div>
                    <div class="flex-1 md:flex-none">
                        <?php echo e($orders->appends(request()->query())->links()); ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/orders/index.blade.php ENDPATH**/ ?>