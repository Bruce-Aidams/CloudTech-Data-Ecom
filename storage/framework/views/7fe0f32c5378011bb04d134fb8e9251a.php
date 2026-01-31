

<?php $__env->startSection('title', 'Analytics'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8 pb-20 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-violet-500/10 flex items-center justify-center text-violet-500 ring-1 ring-violet-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Business Intelligence</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Monitor high-level performance metrics and
                        usage density.</p>
                </div>
            </div>

            <div class="flex items-center gap-2 p-1.5 bg-slate-100 dark:bg-slate-800/50 rounded-2xl w-fit">
                <?php $__currentLoopData = ['24H', '7D', '30D', '1Y']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('admin.analytics', ['range' => $range])); ?>"
                        class="px-4 py-2 text-[10px] font-bold uppercase tracking-widest rounded-xl transition-all <?php echo e(request('range', '30D') === $range ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'); ?>">
                        <?php echo e($range); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            
            <div
                class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute right-[-10px] top-[-10px] opacity-5 transition-transform duration-700 group-hover:rotate-12 text-indigo-500">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div class="relative z-10 space-y-4">
                    <div class="flex items-center justify-between">
                        <span
                            class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400 dark:text-slate-500">Gross
                            Flow</span>
                        <?php if(isset($revenueGrowth) && $revenueGrowth > 0): ?>
                            <span
                                class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-[9px] font-black rounded-lg">+<?php echo e($revenueGrowth); ?>%</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white leading-none">GHS
                        <?php echo e(number_format($totalRevenue, 2)); ?>

                    </h3>
                </div>
            </div>

            
            <div
                class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute right-[-10px] top-[-10px] opacity-5 transition-transform duration-700 group-hover:rotate-12 text-violet-500">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
                <div class="relative z-10 space-y-4">
                    <div class="flex items-center justify-between">
                        <span
                            class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400 dark:text-slate-500">Entity
                            Count</span>
                        <?php if(isset($usersGrowth) && $usersGrowth > 0): ?>
                            <span
                                class="px-2 py-0.5 bg-violet-50 dark:bg-violet-900/20 text-violet-600 dark:text-violet-400 text-[9px] font-black rounded-lg">+<?php echo e($usersGrowth); ?>%</span>
                        <?php endif; ?>
                    </div>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white leading-none">
                        <?php echo e(number_format($totalUsers)); ?>

                    </h3>
                </div>
            </div>

            
            <div
                class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute right-[-10px] top-[-10px] opacity-5 transition-transform duration-700 group-hover:rotate-12 text-emerald-500">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="relative z-10 space-y-4">
                    <p class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400 dark:text-slate-500">Total
                        Transmissions</p>
                    <h3 class="text-3xl font-black text-slate-900 dark:text-white leading-none">
                        <?php echo e(number_format($totalOrders)); ?>

                    </h3>
                    <p class="text-[9px] text-slate-400 font-bold uppercase">Processed Logistics</p>
                </div>
            </div>

            
            <div
                class="bg-white dark:bg-slate-900 p-8 rounded-[2rem] border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute right-[-10px] top-[-10px] opacity-5 transition-transform duration-700 group-hover:rotate-12 text-rose-500">
                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <div class="relative z-10 space-y-4">
                    <p class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400 dark:text-slate-500">Critical
                        Priority</p>
                    <h3 class="text-3xl font-black text-rose-600 dark:text-rose-500 leading-none">
                        <?php echo e($pendingDeposits + $pendingOrders); ?>

                    </h3>
                    <p class="text-[9px] text-rose-500 font-bold uppercase">Attention Required</p>
                </div>
            </div>
        </div>

        
        <div class="grid gap-8 lg:grid-cols-3">
            
            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 shadow-sm lg:col-span-2 h-[460px] flex flex-col">
                <div class="mb-10">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Temporal Traffic Density</h3>
                    <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest mt-1">
                        Transaction volume distribution over time</p>
                </div>
                <div class="flex-1 relative">
                    <canvas id="analyticsChart"></canvas>
                </div>
            </div>

            
            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 shadow-sm">
                <div class="mb-10">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Operational State</h3>
                    <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest mt-1">
                        Transmission status entropy</p>
                </div>

                <div class="space-y-6">
                    <?php $__currentLoopData = $orderStatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="group">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-1.5 h-1.5 rounded-full <?php echo e($item->status === 'completed' ? 'bg-emerald-500' : ($item->status === 'pending' ? 'bg-amber-500' : ($item->status === 'processing' ? 'bg-blue-500' : 'bg-rose-500'))); ?>">
                                    </div>
                                    <span
                                        class="text-[10px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-widest"><?php echo e($item->status === 'pending' ? 'Validating' : ($item->status === 'completed' ? 'Delivered' : $item->status)); ?></span>
                                </div>
                                <span class="text-xs font-black text-slate-900 dark:text-white"><?php echo e($item->count); ?></span>
                            </div>
                            <div
                                class="w-full bg-slate-50 dark:bg-slate-800 h-2 rounded-full overflow-hidden border border-slate-100 dark:border-slate-700">
                                <div class="h-full rounded-full transition-all duration-1000 <?php echo e($item->status === 'completed' ? 'bg-emerald-500' : ($item->status === 'pending' ? 'bg-amber-500' : ($item->status === 'processing' ? 'bg-blue-500' : 'bg-rose-500'))); ?>"
                                    style="width: <?php echo e($totalOrders > 0 ? ($item->count / $totalOrders) * 100 : 0); ?>%">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div
                    class="mt-12 p-6 bg-slate-50 dark:bg-slate-800/40 rounded-3xl border border-slate-100 dark:border-slate-800">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">System Insight</p>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed italic">Success rates are currently
                        within acceptable protocol parameters.</p>
                </div>
            </div>
        </div>

        
        <div
            class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-8 shadow-sm overflow-hidden">
            <div class="mb-8 flex flex-col xl:flex-row xl:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">User Performance Overview</h3>
                    <p class="text-[10px] text-slate-500 dark:text-slate-500 font-black uppercase tracking-widest mt-1">
                        Detailed earnings and transaction reports for all users</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                    
                    <div class="flex gap-1 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl overflow-x-auto max-w-full no-scrollbar">
                        <a href="<?php echo e(route('admin.analytics', array_merge(request()->query(), ['role' => 'all']))); ?>"
                            class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all whitespace-nowrap <?php echo e(!request('role') || request('role') === 'all' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'); ?>">
                            All
                        </a>
                        <?php $__currentLoopData = ['user', 'agent', 'dealer', 'super_agent', 'admin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a href="<?php echo e(route('admin.analytics', array_merge(request()->query(), ['role' => $role]))); ?>"
                                class="px-3 py-1.5 rounded-lg text-[10px] font-black uppercase transition-all whitespace-nowrap <?php echo e(request('role') === $role ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'); ?>">
                                <?php echo e(str_replace('_', ' ', $role)); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <form action="<?php echo e(route('admin.analytics')); ?>" method="GET" class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center w-full sm:w-auto">
                        <?php if(request('role')): ?>
                            <input type="hidden" name="role" value="<?php echo e(request('role')); ?>">
                        <?php endif; ?>
                        <div class="relative flex-1 sm:flex-none">
                            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search entities..."
                                class="h-10 pl-4 pr-10 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-black placeholder:text-slate-400 placeholder:font-bold focus:ring-2 focus:ring-indigo-500/20 w-full sm:w-64 transition-all">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="relative">
                            <select name="per_page" onchange="this.form.submit()"
                                class="w-full sm:w-auto h-10 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-[10px] font-black uppercase tracking-widest outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all dark:text-slate-400 appearance-none cursor-pointer pr-10">
                                <?php $__currentLoopData = [10, 20, 50, 100, 200]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" <?php echo e(request('per_page', 10) == $val ? 'selected' : ''); ?>><?php echo e($val); ?>

                                        Entries</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto -mx-8 px-8 pb-4 scrollbar-hide">
                <table class="w-full text-left border-collapse min-w-[1000px]">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800">
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                Reseller Profile
                            </th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 text-center whitespace-nowrap">
                                Role
                            </th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 text-right whitespace-nowrap">
                                Logistics Count
                            </th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 text-right whitespace-nowrap">
                                Revenue Flow
                            </th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 text-right whitespace-nowrap text-emerald-500">
                                Gross Returns
                            </th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 text-right whitespace-nowrap">
                                Node Balance
                            </th>
                            <th
                                class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 text-center whitespace-nowrap">
                                Operations
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        <?php $__empty_1 = true; $__currentLoopData = $resellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reseller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr
                                class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all border-b border-transparent hover:border-indigo-500/10">
                                <td class="px-6 py-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/10 dark:to-blue-900/10 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black text-xs border border-indigo-100/50 dark:border-indigo-900/30">
                                            <?php echo e(strtoupper(substr($reseller->name, 0, 1))); ?>

                                        </div>
                                        <div>
                                            <p class="text-sm font-black text-slate-900 dark:text-white leading-tight">
                                                <?php echo e($reseller->name); ?></p>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter mt-0.5">
                                                <?php echo e($reseller->email); ?>

                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200/50 dark:border-slate-700/50">
                                        <?php echo e(str_replace('_', ' ', $reseller->role)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-6 text-right whitespace-nowrap">
                                    <div class="space-y-1">
                                        <span
                                            class="text-xs font-black text-slate-700 dark:text-slate-300"><?php echo e(number_format($reseller->total_orders)); ?>

                                            Tx</span>
                                        <p class="text-[9px] font-black text-emerald-500/80 uppercase tracking-tighter">
                                            <?php echo e(number_format($reseller->completed_orders_count)); ?> Solved
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-6 text-right whitespace-nowrap">
                                    <span class="text-xs font-black text-slate-900 dark:text-white">GHS
                                        <?php echo e(number_format($reseller->total_spent, 2)); ?></span>
                                </td>
                                <td class="px-6 py-6 text-right whitespace-nowrap">
                                    <span class="text-xs font-black text-emerald-500">GHS
                                        <?php echo e(number_format($reseller->total_commission_earned, 2)); ?></span>
                                </td>
                                <td class="px-6 py-6 text-right whitespace-nowrap">
                                    <span class="text-xs font-black text-indigo-500">GHS
                                        <?php echo e(number_format($reseller->wallet_balance, 2)); ?></span>
                                </td>
                                <td class="px-6 py-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="<?php echo e(route('admin.orders', ['user_id' => $reseller->id])); ?>"
                                            title="View Transactions"
                                            class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-indigo-500 hover:text-white dark:hover:bg-indigo-600 text-slate-400 transition-all flex items-center justify-center shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="<?php echo e(route('admin.users', ['search' => $reseller->email])); ?>"
                                            title="Manage Profile"
                                            class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-600 text-slate-400 transition-all flex items-center justify-center shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-32 text-center">
                                    <div class="flex flex-col items-center gap-6">
                                        <div
                                            class="w-20 h-20 rounded-[2rem] bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center border border-dashed border-slate-200 dark:border-slate-700">
                                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="space-y-1">
                                            <p
                                                class="font-black uppercase tracking-[.2em] text-sm text-slate-900 dark:text-white">
                                                Null Results</p>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No
                                                matching reseller entities detected in the current range</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($resellers->hasPages()): ?>
                <div class="px-6 py-6 border-t border-slate-50 dark:border-slate-800">
                    <?php echo e($resellers->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('analyticsChart')?.getContext('2d');
            if (!ctx) return;

            const isDark = document.documentElement.classList.contains('dark');
            const velocityData = <?php echo json_encode($velocity, 15, 512) ?>;

            const labels = velocityData.map(item => {
                const date = new Date(item.date);
                return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
            });
            const data = velocityData.map(item => item.count);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Transmissions',
                        data: data,
                        backgroundColor: '#4f46e5',
                        hoverBackgroundColor: '#4338ca',
                        borderRadius: 12,
                        maxBarThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 16,
                            titleFont: { family: 'Inter', size: 10, weight: 'bold' },
                            bodyFont: { family: 'Inter', size: 13, weight: '900' },
                            cornerRadius: 16,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0,0,0,0.05)', drawBorder: false },
                            ticks: { color: '#94a3b8', font: { family: 'Inter', weight: 'bold', size: 10 } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#94a3b8', font: { family: 'Inter', weight: 'bold', size: 10 } }
                        }
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/analytics/index.blade.php ENDPATH**/ ?>