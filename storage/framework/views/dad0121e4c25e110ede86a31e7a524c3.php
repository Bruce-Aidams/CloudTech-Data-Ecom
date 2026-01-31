

<?php $__env->startSection('title', 'Billing & History'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 ring-1 ring-emerald-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Billing & History</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Manage your financial history and export tax-ready invoices.</p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('wallet.index')); ?>"
                    class="inline-flex items-center justify-center rounded-2xl text-xs font-black uppercase tracking-widest bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-6 shadow-lg shadow-primary/20 transition-all hover:scale-105 active:scale-95">
                    Deposit Funds
                </a>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Total Credits -->
            <div
                class="group relative rounded-[2rem] bg-gradient-to-br from-emerald-600 to-teal-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/10">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-1">Total deposits</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-sm font-black text-white/50 uppercase">GHC</span>
                    <p class="text-3xl font-black text-white tracking-tighter">
                        <?php echo e(number_format($stats['total_credits'], 2)); ?></p>
                </div>
            </div>

            <!-- Total Spent -->
            <div
                class="group relative rounded-[2rem] bg-gradient-to-br from-rose-600 to-pink-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/10">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-1">Total spending</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-sm font-black text-white/50 uppercase">GHC</span>
                    <p class="text-3xl font-black text-white tracking-tighter"><?php echo e(number_format($stats['total_spent'], 2)); ?>

                    </p>
                </div>
            </div>

            <!-- This Month -->
            <div
                class="group relative rounded-[2rem] bg-gradient-to-br from-indigo-600 to-blue-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white border border-white/10 sm:col-span-2 lg:col-span-1">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white/10 blur-3xl rounded-full"></div>
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-white transition-transform group-hover:rotate-12">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-white/60 mb-1">Spend this month</p>
                <div class="flex items-baseline gap-1">
                    <span class="text-sm font-black text-white/50 uppercase">GHC</span>
                    <p class="text-3xl font-black text-white tracking-tighter"><?php echo e(number_format($stats['this_month'], 2)); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Payment History -->
        <div class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl shadow-2xl shadow-slate-200/20 dark:shadow-none overflow-hidden"
            x-data="{ showFilters: false }">
            <div class="p-8 md:p-10 border-b border-border/10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400">Transaction History</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <button @click="showFilters = !showFilters"
                            class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-primary bg-primary/5 px-4 py-2 rounded-xl transition-all hover:bg-primary/10">
                            <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': showFilters}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                            <span x-text="showFilters ? 'Hide Filters' : 'Filter Items'"></span>
                        </button>
                        <?php if(request()->anyFilled(['search', 'status', 'type', 'start_date', 'end_date'])): ?>
                            <a href="<?php echo e(route('billing.index')); ?>"
                                class="text-[10px] font-black text-rose-500 uppercase tracking-widest bg-rose-50 dark:bg-rose-900/20 px-4 py-2 rounded-xl">Reset</a>
                        <?php endif; ?>
                    </div>
                </div>

                <form action="<?php echo e(route('billing.index')); ?>" method="GET"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end"
                    x-show="window.innerWidth > 768 || showFilters" x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Search</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Ref or task..."
                                class="flex h-11 w-full rounded-2xl border-none bg-slate-50 dark:bg-slate-800/50 px-4 py-1 text-sm shadow-inner transition-colors placeholder:text-muted-foreground focus:ring-1 focus:ring-primary pl-10">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Status</label>
                        <select name="status"
                            class="h-11 w-full rounded-2xl border-none bg-slate-50 dark:bg-slate-800/50 px-4 py-1 text-sm shadow-inner transition-colors focus:ring-1 focus:ring-primary">
                            <option value="all" <?php echo e(request('status', 'all') == 'all' ? 'selected' : ''); ?>>All Status</option>
                            <option value="success" <?php echo e(request('status') == 'success' ? 'selected' : ''); ?>>Successful</option>
                            <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                            <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Type</label>
                        <select name="type"
                            class="h-11 w-full rounded-2xl border-none bg-slate-50 dark:bg-slate-800/50 px-4 py-1 text-sm shadow-inner transition-colors focus:ring-1 focus:ring-primary">
                            <option value="all" <?php echo e(request('type', 'all') == 'all' ? 'selected' : ''); ?>>All Types</option>
                            <option value="credit" <?php echo e(request('type') == 'credit' ? 'selected' : ''); ?>>Credit (In)</option>
                            <option value="debit" <?php echo e(request('type') == 'debit' ? 'selected' : ''); ?>>Debit (Out)</option>
                        </select>
                    </div>

                    <div class="lg:col-span-2 grid grid-cols-2 gap-2">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">From</label>
                            <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>"
                                class="flex h-11 w-full rounded-2xl border-none bg-slate-50 dark:bg-slate-800/50 px-4 py-1 text-sm shadow-inner focus:ring-1 focus:ring-primary">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">To</label>
                            <div class="flex gap-2">
                                <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>"
                                    class="flex h-11 w-full rounded-2xl border-none bg-slate-50 dark:bg-slate-800/50 px-4 py-1 text-sm shadow-inner focus:ring-1 focus:ring-primary">
                                <button type="submit"
                                    class="h-11 px-5 flex items-center justify-center rounded-2xl bg-primary text-primary-foreground hover:bg-primary/90 transition-all active:scale-95 shadow-lg shadow-primary/20">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="p-0">
                <?php if($transactions->isEmpty()): ?>
                    <div class="text-center py-32">
                        <div
                            class="w-20 h-20 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">No transactions found</p>
                    </div>
                <?php else: ?>
                    
                    <div class="md:hidden divide-y divide-border/10">
                        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-6 space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col gap-1">
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            <?php echo e($transaction->created_at->format('M d, Y')); ?></p>
                                        <p class="font-mono text-[9px] font-black text-primary tracking-widest">
                                            #<?php echo e(strtoupper(substr($transaction->reference, 0, 10))); ?></p>
                                    </div>
                                    <span
                                        class="text-lg font-black tracking-tighter <?php echo e($transaction->type === 'credit' ? 'text-emerald-600' : 'text-rose-600'); ?>">
                                        <?php echo e($transaction->type === 'credit' ? '+' : '-'); ?>GHC <?php echo e(number_format($transaction->amount, 2)); ?>

                                    </span>
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-800/40 rounded-3xl p-5 space-y-4">
                                    <p class="text-xs font-black text-slate-900 dark:text-slate-100 leading-snug">
                                        <?php echo e($transaction->description); ?></p>
                                    <div
                                        class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800/50">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="h-2 w-2 rounded-full <?php echo e($transaction->status === 'success' || $transaction->status === 'completed' ? 'bg-emerald-500 animate-pulse' : ($transaction->status === 'pending' ? 'bg-amber-500' : 'bg-rose-500')); ?>">
                                            </div>
                                            <p class="text-[9px] font-black uppercase text-slate-500 tracking-widest">
                                                <?php echo e($transaction->status === 'success' ? 'Successful' : ($transaction->status === 'pending' ? 'Pending' : ucfirst($transaction->status))); ?>

                                            </p>
                                        </div>
                                        <a href="<?php echo e(route('billing.invoice', $transaction->id)); ?>"
                                            class="inline-flex items-center gap-2 text-[9px] font-black uppercase tracking-widest text-primary bg-primary/10 px-4 py-2 rounded-xl transition-all active:scale-95">
                                            Invoice →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50 dark:bg-slate-800/20 border-b border-border/10">
                                    <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">Date
                                        & Ref</th>
                                    <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Transaction Detail</th>
                                    <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Amount</th>
                                    <th class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Status</th>
                                    <th
                                        class="px-10 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border/10">
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="group hover:bg-white dark:hover:bg-slate-800/50 transition-all duration-300">
                                        <td class="px-10 py-6">
                                            <div class="flex flex-col gap-1">
                                                <p class="text-sm font-black text-foreground">
                                                    <?php echo e($transaction->created_at->format('M d, Y')); ?></p>
                                                <p class="font-mono text-[9px] font-black text-slate-400 tracking-widest">
                                                    #<?php echo e(strtoupper(substr($transaction->reference, 0, 10))); ?></p>
                                            </div>
                                        </td>
                                        <td class="px-10 py-6">
                                            <p
                                                class="text-xs font-black text-slate-500 dark:text-slate-400 tracking-tight leading-tight max-w-xs">
                                                <?php echo e($transaction->description); ?></p>
                                        </td>
                                        <td class="px-10 py-6">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-2 h-2 rounded-full <?php echo e($transaction->type === 'credit' ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500'); ?>">
                                                </div>
                                                <span
                                                    class="text-base font-black tracking-tighter <?php echo e($transaction->type === 'credit' ? 'text-emerald-600' : 'text-rose-600'); ?>">
                                                    <?php echo e($transaction->type === 'credit' ? '+' : '-'); ?>GHC <?php echo e(number_format($transaction->amount, 2)); ?>

                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-10 py-6">
                                            <?php if($transaction->status === 'success'): ?>
                                                <span
                                                    class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">Successful</span>
                                            <?php elseif($transaction->status === 'pending'): ?>
                                                <span
                                                    class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400">Validating</span>
                                            <?php elseif($transaction->status === 'failed'): ?>
                                                <span
                                                    class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400">Failed</span>
                                            <?php else: ?>
                                                <span
                                                    class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.2em] bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400"><?php echo e($transaction->status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <a href="<?php echo e(route('billing.invoice', $transaction->id)); ?>"
                                                class="inline-flex items-center justify-center w-10 h-10 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:bg-primary hover:text-white dark:hover:bg-primary transition-all duration-300 group shadow-inner">
                                                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>


                    <!-- Pagination -->
                    <?php if($transactions->hasPages()): ?>
                        <div
                            class="px-10 py-8 border-t border-border/10 flex flex-col sm:flex-row items-center justify-between gap-6 bg-slate-50/20 dark:bg-slate-900/20">
                            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Page
                                <?php echo e($transactions->currentPage()); ?> of <?php echo e($transactions->lastPage()); ?></span>
                            <div class="modern-pagination">
                                <?php echo e($transactions->links()); ?>

                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/billing.blade.php ENDPATH**/ ?>