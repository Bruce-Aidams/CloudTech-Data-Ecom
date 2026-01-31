

<?php $__env->startSection('title', 'Reseller Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 ring-1 ring-orange-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Reseller Management</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Oversee reseller accounts, stores and
                        commissions.</p>
                </div>
            </div>

            
            <div class="flex gap-4">
                <div
                    class="px-4 py-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400">Total Resellers</p>
                    <p class="text-lg font-black text-slate-900 dark:text-white"><?php echo e($stats['total_resellers']); ?></p>
                </div>
                <div
                    class="px-4 py-2 bg-white dark:bg-slate-900 rounded-xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <p class="text-[10px] font-black uppercase text-slate-400">Paid Commission</p>
                    <p class="text-lg font-black text-emerald-500">
                        GHC <?php echo e(number_format($stats['total_commission_paid'], 2)); ?>

                    </p>
                </div>
            </div>
        </div>

        
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
            <form method="GET" class="flex gap-4">
                <div class="flex-1 relative">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                        placeholder="Search by name, email, phone or code..."
                        class="w-full pl-10 h-10 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20">
                </div>
                <div class="relative min-w-[120px]">
                    <select name="per_page" onchange="this.form.submit()"
                        class="w-full h-10 px-4 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-xs font-bold uppercase tracking-widest outline-none focus:ring-2 focus:ring-primary/20 transition-all dark:text-slate-400">
                        <?php $__currentLoopData = [10, 20, 50, 100, 200]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($val); ?>" <?php echo e(request('per_page', 10) == $val ? 'selected' : ''); ?>><?php echo e($val); ?> Per Page
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <button type="submit"
                    class="px-6 h-10 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-primary transition-colors">
                    Filter
                </button>
            </form>
        </div>

        
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Reseller
                            </th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Role</th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Wallet
                                Balance</th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Total
                                Profit</th>
                            <th class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Store Link
                            </th>
                            <th
                                class="px-6 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px] text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        <?php $__empty_1 = true; $__currentLoopData = $resellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reseller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                            <?php echo e(substr($reseller->name, 0, 1)); ?>

                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 dark:text-white"><?php echo e($reseller->name); ?></p>
                                            <p class="text-xs text-slate-500"><?php echo e($reseller->email); ?></p>
                                            <p class="text-[10px] text-slate-400 font-mono"><?php echo e($reseller->phone); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wide bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                        <?php echo e($reseller->role); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 font-mono font-bold text-slate-900 dark:text-white">
                                    GHC <?php echo e(number_format($reseller->wallet_balance, 2)); ?>

                                </td>
                                <td class="px-6 py-4 font-mono font-bold text-emerald-500">
                                    GHC <?php echo e(number_format($reseller->storefront_profit + $reseller->referral_earnings, 2)); ?>

                                    <div class="text-[8px] text-slate-400 font-bold uppercase tracking-tight mt-0.5">
                                        S: <?php echo e(number_format($reseller->storefront_profit, 1)); ?> | R:
                                        <?php echo e(number_format($reseller->referral_earnings, 1)); ?>

                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($reseller->referral_code): ?>
                                        <a href="<?php echo e(route('store.show', $reseller->referral_code)); ?>" target="_blank"
                                            class="text-xs text-primary hover:underline flex items-center gap-1">
                                            Visit Store
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                </path>
                                            </svg>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-xs text-slate-400">Not Set</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        
                                        <a href="<?php echo e(route('admin.orders')); ?>?reseller_id=<?php echo e($reseller->id); ?>"
                                            title="View Customers"
                                            class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-all flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </a>

                                        
                                        <button onclick="openCommissionModal(<?php echo e($reseller->id); ?>, '<?php echo e($reseller->name); ?>')"
                                            title="Adjust Commission"
                                            class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/50 transition-all flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>

                                        
                                        <form action="<?php echo e(route('admin.resellers.toggle-store', $reseller->id)); ?>" method="POST"
                                            class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit"
                                                title="<?php echo e($reseller->store_active ? 'Disable Store' : 'Enable Store'); ?>"
                                                class="w-8 h-8 rounded-lg bg-<?php echo e($reseller->store_active ? 'orange' : 'blue'); ?>-50 dark:bg-<?php echo e($reseller->store_active ? 'orange' : 'blue'); ?>-900/30 text-<?php echo e($reseller->store_active ? 'orange' : 'blue'); ?>-600 dark:text-<?php echo e($reseller->store_active ? 'orange' : 'blue'); ?>-400 hover:bg-<?php echo e($reseller->store_active ? 'orange' : 'blue'); ?>-100 dark:hover:bg-<?php echo e($reseller->store_active ? 'orange' : 'blue'); ?>-900/50 transition-all flex items-center justify-center">
                                                <?php if($reseller->store_active): ?>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                    </svg>
                                                <?php else: ?>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                <?php endif; ?>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    No resellers found matching your criteria.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($resellers->hasPages()): ?>
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    <?php echo e($resellers->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div x-data="{ open: false, userId: null, userName: '' }"
        @open-commission-modal.window="open = true; userId = $event.detail.id; userName = $event.detail.name"
        class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="open" x-cloak>

        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-slate-900 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-100 dark:border-slate-800"
                    @click.away="open = false">
                    <form x-bind:action="'/admin/resellers/' + userId + '/commission'" method="POST" class="p-6 space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Adjust
                                Commission</h3>
                            <p class="text-xs text-slate-500">For <span x-text="userName" class="font-bold"></span></p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Action</label>
                                <select name="type"
                                    class="w-full mt-1 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-sm font-bold">
                                    <option value="credit">Credit (+)</option>
                                    <option value="debit">Debit (-)</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Amount</label>
                                <input type="number" step="0.01" name="amount" required
                                    class="w-full mt-1 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-sm font-bold"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Reason</label>
                            <input type="text" name="note" required
                                class="w-full mt-1 bg-slate-50 dark:bg-slate-950 border-none rounded-xl text-sm"
                                placeholder="e.g. Sales Bonus">
                        </div>

                        <div class="pt-4 flex gap-3">
                            <button type="button" @click="open = false"
                                class="flex-1 py-3 text-xs font-bold uppercase tracking-widest text-slate-500 hover:text-slate-900 dark:hover:text-white">Cancel</button>
                            <button type="submit"
                                class="flex-1 py-3 bg-primary text-white rounded-xl text-xs font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:bg-primary-focus">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openCommissionModal(id, name) {
            window.dispatchEvent(new CustomEvent('open-commission-modal', { detail: { id, name } }));
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/resellers/index.blade.php ENDPATH**/ ?>