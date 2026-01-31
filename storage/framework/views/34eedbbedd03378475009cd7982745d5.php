

<?php $__env->startSection('title', 'Referral Earnings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700"
        x-data="{ withdrawOpen: false }">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 ring-1 ring-amber-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Earnings Center
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Earn commissions by referring new
                        users to the platform.</p>
                </div>
            </div>

            <button @click="withdrawOpen = true"
                class="group relative inline-flex items-center justify-center rounded-[1.5rem] text-sm font-black ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-14 px-10 shadow-2xl shadow-primary/40 hover:scale-[1.02] active:scale-95">
                <svg class="w-5 h-5 mr-3 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Withdraw Funds
            </button>
        </div>

        <!-- Withdraw Modal -->
        <div x-show="withdrawOpen" x-cloak class="relative z-50">
            <div x-show="withdrawOpen" x-transition.opacity class="fixed inset-0 bg-slate-950/40 backdrop-blur-md"></div>
            <div x-show="withdrawOpen" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                class="fixed inset-0 z-50 flex items-center justify-center p-4">
                <div @click.away="withdrawOpen = false"
                    class="rounded-[3rem] border border-border/10 bg-card/80 backdrop-blur-2xl text-card-foreground shadow-2xl w-full max-w-lg p-10 space-y-8 animate-in zoom-in-95 duration-200">
                    <div class="text-center sm:text-left">
                        <h3 class="text-2xl font-black tracking-tighter text-foreground mb-2">Withdrawal Request</h3>
                        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            Available Balance: <span class="text-primary tracking-tight">GHS
                                <?php echo e(number_format($balance, 2)); ?></span>
                        </p>
                    </div>

                    <form action="<?php echo e(route('payouts.store')); ?>" method="POST" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Amount to
                                Withdraw</label>
                            <div class="relative">
                                <span
                                    class="absolute left-5 top-1/2 -translate-y-1/2 text-lg font-black text-slate-400">GHS</span>
                                <input type="number" name="amount" step="0.01" placeholder="0.00" required
                                    class="w-full h-14 pl-12 pr-6 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Bank /
                                    Mobile Money Name</label>
                                <input type="text" name="bank_name" placeholder="MTN MoMo, GCB..." required
                                    class="w-full h-12 px-5 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-xs font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Account
                                    Number / Phone</label>
                                <input type="text" name="account_number" placeholder="024XXXXXXX" required
                                    class="w-full h-12 px-5 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-xs font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Account
                                Holder Name</label>
                            <input type="text" name="account_name" placeholder="Full Registered Name" required
                                class="w-full h-12 px-5 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-xs font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="button" @click="withdrawOpen = false"
                                class="h-14 px-8 rounded-2xl border border-border/10 bg-slate-100 dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest text-foreground hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                                Cancel
                            </button>
                            <button type="submit"
                                class="flex-1 h-14 bg-primary text-primary-foreground rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                                Submit Request
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid gap-8 md:grid-cols-3">
            <!-- Commission Balance -->
            <div
                class="group relative rounded-[2.5rem] border-none bg-gradient-to-br from-primary via-indigo-600 to-blue-700 p-8 shadow-2xl shadow-primary/20 transition-all hover:scale-[1.02] overflow-hidden">
                <div
                    class="absolute right-[-5%] bottom-[-5%] opacity-20 group-hover:scale-125 transition-transform duration-700 text-white">
                    <svg class="w-40 h-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div class="relative z-10 text-white">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-70 mb-1">Available Balance</p>
                    <p class="text-4xl font-black tracking-tighter">GHS <?php echo e(number_format($balance, 2)); ?></p>
                </div>
            </div>

            <!-- Total Earned -->
            <div
                class="group relative rounded-[2.5rem] bg-gradient-to-br from-emerald-600 to-teal-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/50 mb-1">Total Earned</p>
                <p class="text-4xl font-black text-white tracking-tighter">GHS
                    <?php echo e(number_format($stats['total_earned'], 2)); ?>

                </p>
            </div>

            <!-- Active Referrals -->
            <div
                class="group relative rounded-[2.5rem] bg-gradient-to-br from-amber-500 to-orange-500 p-8 shadow-xl transition-all hover:scale-[1.02] overflow-hidden text-white">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/50 mb-1">Total Referrals</p>
                <p class="text-4xl font-black text-white tracking-tighter"><?php echo e($stats['total_referrals']); ?> <span
                        class="text-xs font-black text-white/50 tracking-widest uppercase">Users</span></p>
            </div>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">
            <!-- Recent Commissions -->
            <div
                class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl shadow-2xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
                <div class="p-8 border-b border-border/10">
                    <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Recent Earnings
                    </h3>
                </div>
                <div class="p-0">
                    <div class="md:hidden grid grid-cols-2 gap-3 px-6 pb-8">
                        <?php $__empty_1 = true; $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div
                                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm space-y-3 relative overflow-hidden group">
                                <div class="flex items-center justify-between">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-500">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <span
                                        class="text-[8px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($commission->created_at->format('M d')); ?></span>
                                </div>
                                <div class="space-y-1">
                                    <p
                                        class="text-[9px] font-black text-slate-900 dark:text-white uppercase truncate tracking-tight leading-none">
                                        <?php echo e($commission->referredUser->name ?? 'Order #' . $commission->order_id); ?>

                                    </p>
                                    <p class="text-sm font-black text-emerald-600 tracking-tighter">+ GHS
                                        <?php echo e(number_format($commission->amount, 2)); ?>

                                    </p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-span-2 text-center py-12">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">No records</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-border/10">
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Referrer</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Amount</th>
                                    <th
                                        class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                        Timestamp</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border/10">
                                <?php $__empty_1 = true; $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                                        <td class="px-8 py-6">
                                            <p class="text-sm font-black text-foreground">
                                                <?php echo e($commission->referredUser->name ?? 'Order #' . $commission->order_id); ?>

                                            </p>
                                        </td>
                                        <td class="px-8 py-6">
                                            <p class="text-lg font-black text-emerald-600 tracking-tighter">+ GHS
                                                <?php echo e(number_format($commission->amount, 2)); ?>

                                            </p>
                                        </td>
                                        <td class="px-8 py-6 text-right">
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                <?php echo e($commission->created_at->format('M d, Y')); ?>

                                            </p>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="3" class="px-8 py-20 text-center">
                                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">No
                                                earnings records found.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if($commissions->hasPages()): ?>
                        <div class="p-6 border-t border-border/10">
                            <?php echo e($commissions->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payout History -->
            <div
                class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl shadow-2xl shadow-slate-200/20 dark:shadow-none overflow-hidden">
                <div class="p-8 border-b border-border/10">
                    <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/20 flex items-center justify-center text-rose-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        Withdrawal History
                    </h3>
                </div>
                <div class="p-0">
                    <div class="md:hidden grid grid-cols-2 gap-3 px-6 pb-8">
                        <?php $__empty_1 = true; $__currentLoopData = $payouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div
                                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl p-4 shadow-sm space-y-3 relative overflow-hidden group">
                                <div class="flex items-center justify-between">
                                    <span
                                        class="font-mono text-[8px] font-black text-primary/60 tracking-tighter">#<?php echo e(strtoupper(substr($payout->reference, 0, 6))); ?></span>
                                    <span
                                        class="text-[8px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($payout->created_at->format('M d')); ?></span>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-sm font-black text-slate-900 dark:text-white tracking-tighter">GHS
                                        <?php echo e(number_format($payout->amount, 2)); ?>

                                    </p>

                                    <?php if($payout->status === 'completed'): ?>
                                        <div
                                            class="w-fit px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[7px] font-black uppercase tracking-widest">
                                            Delivered</div>
                                    <?php elseif($payout->status === 'pending'): ?>
                                        <div
                                            class="w-fit px-2 py-0.5 rounded-md bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 text-[7px] font-black uppercase tracking-widest">
                                            Validating</div>
                                    <?php else: ?>
                                        <div
                                            class="w-fit px-2 py-0.5 rounded-md bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 text-[7px] font-black uppercase tracking-widest">
                                            Failed</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-span-2 text-center py-12">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">No records</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-border/10">
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Reference</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Amount</th>
                                    <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                        Status</th>
                                    <th
                                        class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                        Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border/10">
                                <?php $__empty_1 = true; $__currentLoopData = $payouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all">
                                        <td class="px-8 py-6 font-mono text-[9px] font-black text-primary tracking-widest">
                                            #<?php echo e(strtoupper(substr($payout->reference, 0, 8))); ?>

                                        </td>
                                        <td class="px-8 py-6 font-black text-foreground">
                                            GHS <?php echo e(number_format($payout->amount, 2)); ?>

                                        </td>
                                        <td class="px-8 py-6">
                                            <?php if($payout->status === 'completed'): ?>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">Delivered</span>
                                            <?php elseif($payout->status === 'pending'): ?>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400">Validating</span>
                                            <?php elseif($payout->status === 'failed'): ?>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400">Failed</span>
                                            <?php else: ?>
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-lg text-[8px] font-black uppercase tracking-widest bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400"><?php echo e($payout->status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td
                                            class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                            <?php echo e($payout->created_at->format('M d, Y')); ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="px-8 py-20 text-center">
                                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-300">No
                                                withdrawal history found.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/commissions.blade.php ENDPATH**/ ?>