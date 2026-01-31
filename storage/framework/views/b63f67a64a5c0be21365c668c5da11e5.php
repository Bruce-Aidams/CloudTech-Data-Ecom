

<?php $__env->startSection('title', 'Financial Reports'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 ring-1 ring-green-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Financial Reports</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Revenue analysis and profit margins.</p>
                </div>
            </div>
            <div
                class="flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1.5 rounded-full border border-emerald-100 dark:border-emerald-800/50">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Live
                    Sync</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Gross Revenue -->
            <div
                class="relative overflow-hidden bg-slate-900 border border-slate-800 rounded-3xl shadow-lg shadow-slate-900/10 group p-6">
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-primary/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-2">Gross Revenue</p>
                    <h3 class="text-2xl font-black text-white mb-3">GHC <?php echo e(number_format($stats['total_revenue'], 2)); ?></h3>
                    <div
                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg bg-emerald-500/10 text-emerald-400 text-[8px] font-bold uppercase">
                        Total Sales
                    </div>
                </div>
            </div>

            <!-- Transaction Charges -->
            <div
                class="relative overflow-hidden bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl shadow-sm hover:shadow-md transition-all group p-6">
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-blue-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2">
                        Gateway Charges</p>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3">GHC
                        <?php echo e(number_format($stats['total_charges'], 2)); ?>

                    </h3>
                    <div
                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 text-[8px] font-bold uppercase">
                        Platform Fees
                    </div>
                </div>
            </div>

            <!-- Referral Commissions -->
            <div
                class="relative overflow-hidden bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl shadow-sm hover:shadow-md transition-all group p-6">
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-rose-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[8px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-2">
                        Paid Commissions</p>
                    <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-3">GHC
                        <?php echo e(number_format($stats['total_commissions'], 2)); ?>

                    </h3>
                    <div
                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg bg-rose-500/10 text-rose-600 dark:text-rose-400 text-[8px] font-bold uppercase">
                        Referral Payouts
                    </div>
                </div>
            </div>

            <!-- Net Profit -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-emerald-600 to-emerald-700 dark:from-emerald-500 dark:to-emerald-600 rounded-3xl shadow-lg shadow-emerald-500/20 group p-6">
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <p class="text-[8px] font-bold text-emerald-100 uppercase tracking-[0.2em] mb-2">Net Platform Gain</p>
                    <h3 class="text-2xl font-black text-white mb-3">GHC <?php echo e(number_format($stats['net_profit'], 2)); ?></h3>
                    <div
                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-lg bg-white/10 text-white text-[8px] font-bold uppercase">
                        Net Earnings
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Analysis -->
    <div
        class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
        <div
            class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
            <div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Monthly Revenue Breakdown</h3>
                <p class="text-[10px] text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest mt-0.5">
                    Historical Data</p>
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                    <tr>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                            Month / Period</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                            Revenue (GHS)</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                            Profit (GHS)</th>
                        <th
                            class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                            Trend</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                    <?php $__empty_1 = true; $__currentLoopData = $monthlyData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 dark:text-slate-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="font-bold text-sm text-slate-900 dark:text-white">
                                        <?php echo e(\Carbon\Carbon::parse($data->month . '-01')->format('F Y')); ?>

                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <span class="text-base font-black text-slate-900 dark:text-white">
                                    <?php echo e(number_format($data->revenue, 2)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <span class="text-base font-black text-emerald-600 dark:text-emerald-400">
                                    <?php echo e(number_format($data->profit, 2)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 text-emerald-500 font-black text-[10px] uppercase tracking-tighter">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M5 10l7-7 7 7" stroke-width="3"></path>
                                    </svg>
                                    Growth
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-24 text-center text-slate-400 dark:text-slate-700">
                                <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 17v-2m3 2v-4m3 2v-6m-8-2h10a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z">
                                    </path>
                                </svg>
                                <p class="font-bold text-sm uppercase tracking-widest italic">Insufficient Data</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/financials/index.blade.php ENDPATH**/ ?>