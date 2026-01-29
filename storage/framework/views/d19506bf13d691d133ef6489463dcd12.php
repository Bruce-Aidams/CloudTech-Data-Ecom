

<?php $__env->startSection('title', 'Order History'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ loading: true }"
        x-init="setTimeout(() => loading = false, 800)">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-primary">Order History</h2>
                <p class="text-muted-foreground font-medium">View and manage your recent data bundle purchases.</p>
            </div>
            <a href="<?php echo e(route('orders.new')); ?>"
                class="inline-flex items-center justify-center rounded-xl text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 shadow-sm">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Order
            </a>
        </div>

        <div class="rounded-xl border bg-card text-card-foreground shadow-sm border-none overflow-hidden" x-data="{ showFilters: false }">
            <!-- Filter Section -->
            <div class="p-4 md:p-6 border-b border-gray-100 dark:border-gray-700 bg-white/50 dark:bg-slate-900/50">
                <div class="flex items-center justify-between mb-4 md:hidden">
                    <button @click="showFilters = !showFilters" class="inline-flex items-center gap-2 text-sm font-black uppercase tracking-widest text-primary">
                        <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': showFilters}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <span x-text="showFilters ? 'Hide Filters' : 'Filters'"></span>
                    </button>
                    <?php if(request()->anyFilled(['search', 'status', 'network', 'start_date', 'end_date'])): ?>
                        <a href="<?php echo e(route('orders.index')); ?>" class="text-[10px] font-black text-rose-500 uppercase tracking-widest bg-rose-50 dark:bg-rose-900/20 px-3 py-1 rounded-lg">Reset</a>
                    <?php endif; ?>
                </div>

                <form action="<?php echo e(route('orders.index')); ?>" method="GET" 
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end"
                    x-show="window.innerWidth > 768 || showFilters"
                    x-cloak>
                    <!-- Search -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Search</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-2.5 h-4 w-4 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Ref or Phone..."
                                class="flex h-10 w-full rounded-xl border-none bg-slate-50 dark:bg-slate-800/50 px-3 py-1 text-sm shadow-inner transition-colors placeholder:text-muted-foreground focus:ring-1 focus:ring-primary pl-10">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Status</label>
                        <select name="status" class="h-10 w-full rounded-xl border-none bg-slate-50 dark:bg-slate-800/50 px-3 py-1 text-sm shadow-inner transition-colors focus:ring-1 focus:ring-primary">
                            <option value="all">All Status</option>
                            <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Delivered</option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Validating</option>
                            <option value="processing" <?php echo e(request('status') == 'processing' ? 'selected' : ''); ?>>Processing</option>
                            <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                        </select>
                    </div>

                    <!-- Network -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Network</label>
                        <select name="network" class="h-10 w-full rounded-xl border-none bg-slate-50 dark:bg-slate-800/50 px-3 py-1 text-sm shadow-inner transition-colors focus:ring-1 focus:ring-primary">
                            <option value="all">All Networks</option>
                            <?php $__currentLoopData = $networks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $network): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($network); ?>" <?php echo e(request('network') == $network ? 'selected' : ''); ?>><?php echo e(strtoupper($network)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Date Range -->
                    <div class="lg:col-span-2 grid grid-cols-2 gap-2">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">From</label>
                            <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>"
                                class="flex h-10 w-full rounded-xl border-none bg-slate-50 dark:bg-slate-800/50 px-3 py-1 text-sm shadow-inner transition-colors focus:ring-1 focus:ring-primary">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">To</label>
                            <div class="flex gap-2">
                                <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>"
                                    class="flex h-10 w-full rounded-xl border-none bg-slate-50 dark:bg-slate-800/50 px-3 py-1 text-sm shadow-inner transition-colors focus:ring-1 focus:ring-primary">
                                <button type="submit" class="h-10 px-4 flex items-center justify-center rounded-xl bg-primary text-primary-foreground hover:bg-primary/90 transition-all active:scale-95 shadow-lg shadow-primary/20">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                                <?php if(request()->anyFilled(['search', 'status', 'network', 'start_date', 'end_date'])): ?>
                                    <a href="<?php echo e(route('orders.index')); ?>" class="h-10 px-4 md:flex hidden items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-rose-500 transition-all shadow-inner" title="Clear Filters">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Mobile View: Card Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:hidden gap-4 px-4 py-8 bg-slate-50/30 dark:bg-slate-900/10">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2rem] p-6 shadow-sm space-y-4 relative overflow-hidden group transition-all hover:border-primary/30">
                        <div class="flex items-start justify-between">
                            <div class="flex flex-col gap-1">
                                <span class="font-mono text-[9px] font-black text-primary tracking-[0.2em] uppercase">#<?php echo e(strtoupper(substr($order->reference, 0, 10))); ?></span>
                                <h4 class="font-black text-sm text-slate-900 dark:text-white leading-tight">
                                    <?php echo e($order->bundle->name ?? 'Data Bundle'); ?></h4>
                            </div>
                            <div class="text-right">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1"><?php echo e($order->bundle->network ?? 'GSM'); ?></p>
                                <p class="text-base font-black text-slate-900 dark:text-white tracking-tighter">₵<?php echo e(number_format($order->cost, 2)); ?></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-50 dark:border-slate-800">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-1">To: <?php echo e($order->recipient_phone); ?></span>
                                <div class="flex items-center gap-2">
                                    <div class="h-1.5 w-1.5 rounded-full <?php echo e($order->status === 'completed' ? 'bg-emerald-500' : ($order->status === 'failed' ? 'bg-rose-500' : 'bg-amber-500')); ?>"></div>
                                    <span class="text-[9px] font-black uppercase tracking-[0.2em] <?php echo e($order->status === 'completed' ? 'text-emerald-600' : ($order->status === 'failed' ? 'text-rose-600' : 'text-amber-600')); ?>">
                                        <?php echo e($order->status === 'completed' ? 'Delivered' : ($order->status === 'failed' ? 'Failed' : 'Validating')); ?>

                                    </span>
                                </div>
                            </div>
                            <div class="text-right text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                <?php echo e($order->created_at->format('M d, Y')); ?>

                            </div>
                        </div>

                        <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="absolute inset-0 z-10"></a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-1 sm:col-span-2 text-center py-20">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">No orders active</p>
                    </div>
                <?php endif; ?>
            </div>

                <!-- Desktop View: Table -->
                <div class="hidden md:block relative w-full overflow-x-auto">
                    <table class="w-full caption-bottom text-sm text-left">
                        <thead class="[&_tr]:border-b">
                            <tr
                                class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted border-gray-100 dark:border-gray-700">
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    ORDER ID</th>
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    PACKAGE</th>
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    RECIPIENT</th>
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    AMOUNT</th>
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    STATUS</th>
                                <th
                                    class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    DATE</th>
                                <th
                                    class="h-12 px-4 text-right align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0">
                                    ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody class="[&_tr:last-child]:border-0">
                            <template x-if="loading">
                                <template x-for="i in 5">
                                    <tr
                                        class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted border-gray-100 dark:border-gray-700">
                                        <td class="p-4 align-middle">
                                            <div class="h-4 w-20 bg-gray-100 dark:bg-gray-800 rounded animate-pulse"></div>
                                        </td>
                                        <td class="p-4 align-middle">
                                            <div class="h-4 w-32 bg-gray-100 dark:bg-gray-800 rounded animate-pulse"></div>
                                        </td>
                                        <td class="p-4 align-middle">
                                            <div class="h-4 w-24 bg-gray-100 dark:bg-gray-800 rounded animate-pulse"></div>
                                        </td>
                                        <td class="p-4 align-middle">
                                            <div class="h-4 w-16 bg-gray-100 dark:bg-gray-800 rounded animate-pulse"></div>
                                        </td>
                                        <td class="p-4 align-middle">
                                            <div class="h-6 w-20 bg-gray-100 dark:bg-gray-800 rounded-full animate-pulse">
                                            </div>
                                        </td>
                                        <td class="p-4 align-middle">
                                            <div class="h-4 w-24 bg-gray-100 dark:bg-gray-800 rounded animate-pulse"></div>
                                        </td>
                                        <td class="p-4 align-middle text-right">
                                            <div class="h-8 w-8 bg-gray-100 dark:bg-gray-800 rounded ml-auto animate-pulse">
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </template>
                            <template x-if="!loading">
                                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr
                                        class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted border-gray-100 dark:border-gray-700 hover:bg-gray-50/50 dark:hover:bg-gray-800/50">
                                        <td class="p-4 align-middle font-mono text-xs font-semibold">#<?php echo e($order->reference); ?>

                                        </td>
                                        <td class="p-4 align-middle">
                                            <div class="flex flex-col">
                                                <span
                                                    class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->bundle->name ?? 'Bundle'); ?></span>
                                                <span
                                                    class="text-[10px] text-muted-foreground uppercase"><?php echo e($order->bundle->network ?? 'Network'); ?></span>
                                            </div>
                                        </td>
                                        <td class="p-4 align-middle font-medium"><?php echo e($order->recipient_phone); ?></td>
                                        <td class="p-4 align-middle font-semibold">GHS <?php echo e(number_format($order->cost, 2)); ?></td>
                                        <td class="p-4 align-middle">
                                            <?php if($order->status === 'completed'): ?>
                                                <div
                                                    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-green-500/15 text-green-700 dark:text-green-400 hover:bg-green-500/25">
                                                    Delivered</div>
                                            <?php elseif($order->status === 'pending'): ?>
                                                <div
                                                    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-blue-500/15 text-blue-700 dark:text-blue-400 hover:bg-blue-500/25">
                                                    Validating</div>
                                            <?php elseif($order->status === 'failed'): ?>
                                                <div
                                                    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-destructive/15 text-destructive dark:text-red-400 hover:bg-destructive/25">
                                                    Failed</div>
                                            <?php else: ?>
                                                <div
                                                    class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80">
                                                    <?php echo e(ucfirst($order->status)); ?>

                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="p-4 align-middle text-muted-foreground text-xs">
                                            <?php echo e($order->created_at->format('M d, Y h:i A')); ?>

                                        </td>
                                        <td class="p-4 align-middle text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <?php if($order->status === 'completed'): ?>
                                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>"
                                                        class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 w-8 text-muted-foreground"
                                                        title="View Invoice">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                            </path>
                                                        </svg>
                                                    </a>
                                                <?php endif; ?>
                                                <a href="<?php echo e(route('orders.show', $order->id)); ?>"
                                                    class="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-8 w-8 text-muted-foreground"
                                                    title="View Details">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="p-4 align-middle text-center py-10">
                                            <div class="flex flex-col items-center justify-center text-muted-foreground">
                                                <svg class="w-10 h-10 opacity-20 mb-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                    </path>
                                                </svg>
                                                <p>No orders found matching your criteria.</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </template>
                        </tbody>
                    </table>
                </div>
                <?php if($orders->hasPages()): ?>
                    <div
                        class="flex items-center justify-end space-x-2 py-4 px-4 border-t border-gray-100 dark:border-gray-700">
                        <?php echo e($orders->appends(request()->query())->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/orders/index.blade.php ENDPATH**/ ?>