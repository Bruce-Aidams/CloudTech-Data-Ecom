

<?php $__env->startSection('title', 'Referral Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-pink-500/10 flex items-center justify-center text-pink-500 ring-1 ring-pink-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Referral Management</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Monitor and manage user referrals</p>
                </div>
            </div>
            
            
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div
                    class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total
                                Referrals</p>
                            <p class="text-2xl font-bold text-slate-900 dark:text-white mt-2">
                                <?php echo e(number_format($stats['total_referrals'])); ?></p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Active
                                Referrers</p>
                            <p class="text-2xl font-bold text-slate-900 dark:text-white mt-2">
                                <?php echo e(number_format($stats['active_referrers'])); ?></p>
                        </div>
                        <div
                            class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total
                                Commissions</p>
                            <p class="text-2xl font-bold text-slate-900 dark:text-white mt-2">GHS
                                <?php echo e(number_format($stats['total_commissions'], 2)); ?></p>
                        </div>
                        <div
                            class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Validating
                            </p>
                            <p class="text-2xl font-bold text-slate-900 dark:text-white mt-2">GHS
                                <?php echo e(number_format($stats['pending_commissions'], 2)); ?></p>
                        </div>
                        <div
                            class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 shadow-sm"
                        x-data="{ 
                        rate: '<?php echo e($commissionRate); ?>', 
                        loading: false, 
                        message: '' 
                     }">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex items-start gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-500 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">Global Commission Rate</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 max-w-xl">Set the percentage earned by
                                        referrers for every purchase made by their referrals. Changes apply immediately to new
                                        transactions.</p>
                                </div>
                            </div>
        
                            <div class="flex items-center gap-3 w-full md:w-auto">
                                <div class="relative flex-1 md:w-48">
                                    <input type="number" step="0.1" x-model="rate"
                                        class="w-full h-11 pl-4 pr-12 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white"
                                        placeholder="0.0">
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">%</div>
                                </div>
                                <button @click="
                                loading = true;
                                fetch('<?php echo e(route('admin.settings.update')); ?>', {
                                    method: 'PUT',
                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                                    body: JSON.stringify({ settings: { commission_rate: rate } })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    message = 'Updated!';
                                    setTimeout(() => message = '', 2000);
                                })
                                .finally(() => loading = false)
                            " :disabled="loading"
                                    class="h-11 px-6 bg-slate-900 dark:bg-slate-700 text-white rounded-xl font-bold text-sm hover:opacity-90 active:scale-95 transition-all flex items-center gap-2 disabled:opacity-50 min-w-[100px] justify-center">
                                    <span x-show="!loading && !message">Update</span>
                                    <span x-show="loading"
                                        class="animate-spin w-4 h-4 border-2 border-white/30 border-t-white rounded-full"></span>
                                    <span x-show="message" x-text="message" class="text-emerald-400"></span>
                                </button>
                            </div>
                        </div>
                    </div>

            
            <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                <form action="<?php echo e(route('admin.referrals')); ?>" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="relative flex-1 group">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-primary transition-colors"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" name="search" placeholder="Search by name or email..."
                            value="<?php echo e(request('search')); ?>"
                            class="h-11 w-full pl-10 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-medium outline-none focus:ring-4 focus:ring-primary/10 transition-all dark:text-white">
                    </div>

                    <div class="relative min-w-[140px]">
                        <select name="per_page" onchange="this.form.submit()"
                            class="h-11 w-full px-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold uppercase tracking-widest outline-none focus:ring-4 focus:ring-primary/10 transition-all dark:text-slate-400 appearance-none cursor-pointer">
                            <?php $__currentLoopData = [10, 20, 50, 100, 200]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($val); ?>" <?php echo e(request('per_page', 10) == $val ? 'selected' : ''); ?>><?php echo e($val); ?> Per
                                    Page</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </form>
            </div>

            
            <div
                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white">All Referrals</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 dark:bg-slate-800/50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Referred User</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Referrer</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Joined</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <?php $__empty_1 = true; $__currentLoopData = $referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div>
                                            <p class="text-sm font-bold text-slate-900 dark:text-white"><?php echo e($referral->name); ?>

                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400"><?php echo e($referral->email); ?></p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($referral->referrer): ?>
                                            <div>
                                                <p class="text-sm font-medium text-slate-900 dark:text-white">
                                                    <?php echo e($referral->referrer->name); ?></p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                                    <?php echo e($referral->referrer->email); ?></p>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-xs text-slate-400">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm text-slate-600 dark:text-slate-400">
                                            <?php echo e($referral->created_at->format('M d, Y')); ?></p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500">
                                            <?php echo e($referral->created_at->diffForHumans()); ?></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if($referral->is_active): ?>
                                            <span
                                                class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold rounded-lg">Active</span>
                                        <?php else: ?>
                                            <span
                                                class="px-2 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-bold rounded-lg">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">No referrals found
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($referrals->hasPages()): ?>
                    <div class="p-6 border-t border-slate-100 dark:border-slate-800">
                        <?php echo e($referrals->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/referrals/index.blade.php ENDPATH**/ ?>