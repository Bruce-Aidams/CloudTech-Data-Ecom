

<?php $__env->startSection('title', 'My Wallet'); ?>

<?php $__env->startSection('content'); ?>
    <div class="relative max-w-full pb-20 animate-in fade-in slide-in-from-bottom-4 duration-700"
        x-data="wallet">

        
        
        <div class="absolute inset-0 bg-slate-50/50 dark:bg-[#0B0F1A] pointer-events-none"></div>
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[400px] bg-gradient-to-b from-primary/5 to-transparent pointer-events-none">
        </div>

        <div class="relative z-10 space-y-8 md:space-y-12">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100 uppercase">My Wallet
                    </h2>
                    <p class="text-sm text-muted-foreground font-medium mt-1">Manage your funds and view transaction
                        history.</p>
                </div>
            </div>

            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                
                <div
                    class="relative overflow-hidden bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/50 dark:shadow-none hover:shadow-primary/20 hover:-translate-y-2 transition-all duration-500 group/card animate-in fade-in zoom-in slide-in-from-bottom-4 duration-700">
                    
                    <div class="absolute -top-24 -right-24 w-48 h-48 bg-primary/10 rounded-full blur-3xl group-hover/card:bg-primary/20 transition-colors"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-6">
                            <span
                                class="text-[11px] font-black uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Available
                                Balance</span>
                            <div class="p-2.5 bg-primary/10 rounded-xl text-primary group-hover/card:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-sm font-bold text-slate-400">GHS</span>
                            <h3 class="text-4xl font-black text-slate-900 dark:text-white tracking-tight tabular-nums group-hover/card:text-primary transition-colors">
                                <?php echo e(number_format($balance, 2)); ?>

                            </h3>
                        </div>
                        <div class="mt-6 flex items-center gap-2">
                            <div class="flex -space-x-1.5 overflow-hidden">
                                <div class="inline-block h-4 w-4 rounded-full ring-2 ring-white dark:ring-slate-900 bg-emerald-500"></div>
                                <div class="inline-block h-4 w-4 rounded-full ring-2 ring-white dark:ring-slate-900 bg-sky-500"></div>
                            </div>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tight">Secured Wallet</span>
                        </div>
                    </div>
                </div>

                
                <div
                    class="relative overflow-hidden bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/50 dark:shadow-none hover:shadow-emerald-500/20 hover:-translate-y-2 transition-all duration-500 group/card animate-in fade-in zoom-in slide-in-from-bottom-4 delay-150 duration-700">
                    <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl"></div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="text-[11px] font-black uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Total Inflow</span>
                            <div class="p-2.5 bg-emerald-500/10 rounded-xl text-emerald-500 group-hover/card:rotate-12 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-sm font-bold text-slate-400">GHS</span>
                            <h3 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight tabular-nums group-hover/card:text-emerald-500 transition-colors">
                                <?php echo e(number_format($transactions->where('type', 'credit')->where('status', 'success')->sum('amount'), 2)); ?>

                            </h3>
                        </div>
                    </div>
                </div>

                
                <div
                    class="relative overflow-hidden bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-[2.5rem] p-8 shadow-2xl shadow-slate-200/50 dark:shadow-none hover:shadow-rose-500/20 hover:-translate-y-2 transition-all duration-500 group/card animate-in fade-in zoom-in slide-in-from-bottom-4 delay-300 duration-700">
                    <div class="absolute -bottom-12 -right-12 w-32 h-32 bg-rose-500/5 rounded-full blur-2xl"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="text-[11px] font-black uppercase tracking-[0.15em] text-slate-500 dark:text-slate-400">Total Outflow</span>
                            <div class="p-2.5 bg-rose-500/10 rounded-xl text-rose-500 group-hover/card:-rotate-12 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-sm font-bold text-slate-400">GHS</span>
                            <h3 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight tabular-nums group-hover/card:text-rose-500 transition-colors">
                                <?php echo e(number_format($transactions->where('type', 'debit')->where('status', 'success')->sum('amount'), 2)); ?>

                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">

                
                <div
                    class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-[2.5rem] p-6 sm:p-10 shadow-2xl shadow-slate-200/50 dark:shadow-none">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Add Funds</h3>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Refill your balance
                            instantly</p>
                    </div>

                    
                    <div class="flex p-1.5 bg-slate-100 dark:bg-slate-800/50 rounded-2xl mb-8">
                        <button @click="activeTab = 'instant'"
                            :class="activeTab === 'instant' ? 'bg-white dark:bg-slate-800 text-primary shadow-sm' : 'text-slate-500 hover:text-slate-900 dark:hover:text-slate-200'"
                            class="flex-1 py-2.5 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-all text-center">
                            Instant Pay
                        </button>
                        <button @click="activeTab = 'manual'"
                            :class="activeTab === 'manual' ? 'bg-white dark:bg-slate-800 text-primary shadow-md' : 'text-slate-500 hover:text-slate-900 dark:hover:text-slate-200'"
                            class="flex-1 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest transition-all text-center">
                            Manual Transfer
                        </button>
                    </div>

                    
                    <div x-show="activeTab === 'instant'" class="space-y-6" x-transition:enter="duration-300 ease-out"
                        x-transition:enter-start="opacity-0 translate-y-2">
                        <div class="space-y-4">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Amount to
                                Credit</label>
                            <div class="relative group">
                                <div class="absolute left-5 top-1/2 -translate-y-1/2 font-bold text-slate-400">GHS</div>
                                <input type="number" x-model="amount" placeholder="0.00" step="0.01" required
                                    :disabled="isLoading"
                                    class="w-full h-16 pl-16 pr-5 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-[1.25rem] text-2xl font-black text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                            </div>
                        </div>

                        <div x-show="amount > 0" x-collapse>
                            <div class="p-5 bg-emerald-50 dark:bg-emerald-500/5 rounded-xl border border-emerald-100 dark:border-emerald-500/10 space-y-3"
                                :class="amount >= <?php echo e($publicSettings['min_payment'] ?? 1); ?> ? '' : 'bg-rose-50 dark:bg-rose-500/5 border-rose-100 dark:border-rose-500/10'">
                                <div
                                    class="flex justify-between text-[10px] font-bold uppercase tracking-widest text-slate-500">
                                    <span>Processing Fee</span>
                                    <span class="text-primary">+ GHS <span x-text="calculateFee()"></span></span>
                                </div>
                                <div
                                    class="flex justify-between items-end pt-2 border-t border-slate-100 dark:border-slate-800">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Total
                                        Debit</span>
                                    <span class="text-2xl font-black text-slate-900 dark:text-white tabular-nums">GHC <span
                                            x-text="calculateTotal()"></span></span>
                                </div>
                            </div>
                        </div>

                        <button @click="initPaystack"
                            :disabled="isLoading || !amount || amount < <?php echo e($publicSettings['min_payment'] ?? 1); ?>"
                            class="w-full h-14 bg-primary hover:bg-primary/90 text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all active:scale-95 disabled:opacity-50 flex items-center justify-center gap-2">
                            <template x-if="isLoading">
                                <svg class="animate-spin w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </template>
                            <template x-if="!isLoading">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </template>
                            <span x-text="isLoading ? 'Preparing Secure Gateway...' : 'Initialize Payment'"></span>
                        </button>

                        
                        <div class="p-4 bg-primary/5 border border-primary/10 rounded-xl flex gap-3">
                            <svg class="w-5 h-5 text-primary shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-[10px] font-medium text-slate-500 leading-relaxed">
                                Payments are processed via Paystack. Your financial details are never stored on our servers.
                            </p>
                        </div>
                    </div>

                    
                    <div x-show="activeTab === 'manual'" class="space-y-8" x-transition:enter="duration-300 ease-out"
                        x-transition:enter-start="opacity-0 translate-y-2">
                        <div
                            class="p-8 rounded-[2rem] bg-slate-50 dark:bg-slate-950/50 border border-slate-200 dark:border-slate-800 space-y-6">
                            <div class="flex items-center gap-3 pb-3 border-b border-slate-100 dark:border-slate-800">
                                <div class="w-8 h-8 rounded-lg bg-primary/10 text-primary flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h4 class="text-xs font-bold uppercase tracking-widest text-slate-900 dark:text-white">Bank
                                    Details</h4>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[8px] text-slate-400 uppercase font-bold tracking-widest">Bank/Network
                                    </p>
                                    <p class="font-bold text-xs"><?php echo e($publicSettings['bank_name'] ?? 'N/A'); ?></p>
                                </div>
                                <div>
                                    <p class="text-[8px] text-slate-400 uppercase font-bold tracking-widest">Receiver</p>
                                    <p class="font-bold text-xs"><?php echo e($publicSettings['bank_account_name'] ?? 'N/A'); ?></p>
                                </div>
                                <div class="col-span-2 pt-2">
                                    <p class="text-[8px] text-slate-400 uppercase font-bold tracking-widest mb-1">Account
                                        Number</p>
                                    <div
                                        class="flex items-center justify-between p-3 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-lg">
                                        <p class="text-lg font-black tracking-widest text-primary">
                                            <?php echo e($publicSettings['bank_account_number'] ?? 'N/A'); ?></p>
                                        <button
                                            @click="copyText('<?php echo e($publicSettings['bank_account_number'] ?? ''); ?>', 'Copied!')"
                                            class="p-1.5 hover:bg-slate-50 dark:hover:bg-slate-800 rounded transition-all text-slate-400 hover:text-primary">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form action="<?php echo e(route('wallet.manual')); ?>" method="POST" enctype="multipart/form-data"
                            class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <div class="space-y-6">
                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground pl-1">Amount
                                        Sent</label>
                                    <div class="relative group/field">
                                        <div
                                            class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-300 group-focus-within/field:text-primary transition-colors">
                                            GHC</div>
                                        <input type="number" name="amount" placeholder="0.00" step="0.01" required
                                            class="w-full h-18 pl-16 pr-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:ring-4 focus:ring-primary/10 focus:border-primary rounded-[1.5rem] text-2xl font-black text-slate-900 dark:text-white outline-none transition-all shadow-inner">
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black uppercase tracking-[0.2em] text-muted-foreground pl-1">Payment
                                        Confirmation Image</label>
                                    <div class="relative">
                                        <input type="file" name="proof_image" id="proof_image" class="hidden" required
                                            @change="proofFile = $event.target.files[0]">
                                        <label for="proof_image"
                                            class="flex flex-col items-center justify-center w-full min-h-[160px] px-6 py-8 rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 hover:bg-white dark:hover:bg-slate-900 hover:border-primary/50 transition-all cursor-pointer group/upload shadow-sm">
                                            <template x-if="!proofFile">
                                                <div class="flex flex-col items-center gap-3">
                                                    <div
                                                        class="w-12 h-12 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 group-hover/upload:text-primary transition-colors">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2.5"
                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                        </svg>
                                                    </div>
                                                    <p
                                                        class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                                        Click to upload transfer screenshot</p>
                                                </div>
                                            </template>
                                            <template x-if="proofFile">
                                                <div class="flex flex-col items-center gap-3 text-emerald-500">
                                                    <svg class="w-12 h-12" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p class="text-[10px] font-black uppercase tracking-widest text-center"
                                                        x-text="proofFile.name"></p>
                                                </div>
                                            </template>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full h-18 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-[1.5rem] font-black text-sm uppercase tracking-widest shadow-xl hover:shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                                Verify Deposit Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            
            <div
                class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border border-slate-200 dark:border-slate-800 rounded-[2.5rem] shadow-2xl shadow-slate-200/50 dark:shadow-none overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-900 dark:text-white">Recent Activity</h3>
                    </div>
                    <a href="<?php echo e(route('transactions.index')); ?>"
                        class="text-[10px] font-bold uppercase tracking-widest text-primary hover:text-primary/80 transition-all">View
                        All</a>
                </div>

                <div class="overflow-x-auto min-h-[300px]">
                    <table class="w-full text-left border-collapse">
                        <thead class="hidden md:table-header-group">
                            <tr
                                class="text-[10px] text-slate-400 uppercase bg-slate-50/30 dark:bg-slate-900/30 border-b border-slate-200/50 dark:border-slate-800/50">
                                <th class="px-8 py-6 font-black tracking-[0.2em]">Action</th>
                                <th class="px-8 py-6 font-black tracking-[0.2em]">Trace Code</th>
                                <th class="px-8 py-6 font-black tracking-[0.2em]">Entry Detail</th>
                                <th class="px-8 py-6 font-black tracking-[0.2em] text-right">Settlement</th>
                                <th class="px-8 py-6 font-black tracking-[0.2em] text-right">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                            <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="block md:table-row group hover:bg-slate-50/50 dark:hover:bg-primary/5 transition-all duration-300 border-b border-slate-100 dark:border-slate-800 md:border-none">
                                    <td class="flex justify-between items-center px-6 py-4 md:table-cell">
                                        <span class="md:hidden text-[10px] font-bold text-slate-400 uppercase tracking-widest">Type</span>
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-7 h-7 rounded-lg flex items-center justify-center <?php echo e($trx->type === 'credit' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500' : 'bg-rose-50 dark:bg-rose-500/10 text-rose-500'); ?>">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <?php if($trx->type === 'credit'): ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                                    <?php else: ?>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                                    <?php endif; ?>
                                                </svg>
                                            </div>
                                            <span
                                                class="text-[10px] font-black text-slate-900 dark:text-white uppercase tracking-tight"><?php echo e($trx->type); ?></span>
                                        </div>
                                    </td>
                                    <td class="flex justify-between items-center px-6 py-4 md:table-cell">
                                        <span class="md:hidden text-[10px] font-bold text-slate-400 uppercase tracking-widest">Reference</span>
                                        <span class="font-mono text-[10px] font-bold text-slate-400">#<?php echo e(substr($trx->reference, 0, 8)); ?></span>
                                    </td>
                                    <td class="flex flex-col md:table-cell px-6 py-4">
                                        <span class="md:hidden text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Details</span>
                                        <p class="text-xs font-medium text-slate-600 dark:text-slate-400">
                                            <?php echo e($trx->description); ?></p>
                                        <div class="mt-1.5">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest <?php echo e($trx->status === 'success' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20' : ($trx->status === 'pending' ? 'bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/20')); ?>">
                                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 <?php echo e($trx->status === 'success' ? 'bg-emerald-500' : ($trx->status === 'pending' ? 'bg-amber-500' : 'bg-rose-500')); ?> animate-pulse"></span>
                                                <?php echo e($trx->status); ?>

                                            </span>
                                        </div>
                                    </td>
                                    <td class="flex justify-between items-center px-6 py-4 md:table-cell md:text-right">
                                        <span class="md:hidden text-[10px] font-bold text-slate-400 uppercase tracking-widest">Amount</span>
                                        <p
                                            class="text-sm font-bold <?php echo e($trx->type === 'credit' ? 'text-emerald-600' : 'text-rose-600'); ?>">
                                            <?php echo e($trx->type === 'credit' ? '+' : '-'); ?>GHS <?php echo e(number_format($trx->amount, 2)); ?>

                                        </p>
                                    </td>
                                    <td class="flex justify-between items-center px-6 py-4 md:table-cell md:text-right">
                                        <span class="md:hidden text-[10px] font-bold text-slate-400 uppercase tracking-widest">Date</span>
                                        <p class="text-[10px] font-bold text-slate-400">
                                            <?php echo e($trx->created_at->format('M d, H:i')); ?></p>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="py-20 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div
                                                class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center text-slate-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">No
                                                activity found</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($transactions->hasPages()): ?>
                    <div
                        class="px-10 py-6 bg-slate-50/50 dark:bg-slate-950/20 border-t border-white/20 dark:border-slate-800/50">
                        <?php echo e($transactions->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div id="wallet-toast"
        class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[100] px-8 py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-2xl transition-all duration-500 translate-y-20 opacity-0 pointer-events-none">
        Copied to clipboard
    </div>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('wallet', () => ({
                    activeTab: 'instant',
                    amount: '',
                    isLoading: false,
                    proofFile: null,

                    feeType: '<?php echo e($publicSettings['charge_type'] ?? 'percentage'); ?>',
                    feeValue: parseFloat('<?php echo e($publicSettings['charge_value'] ?? 0); ?>'),

                    calculateFee() {
                        const amt = parseFloat(this.amount) || 0;
                        if (amt === 0) return '0.00';
                        return (this.feeType === 'percentage' ? (amt * (this.feeValue / 100)) : this.feeValue).toFixed(2);
                    },

                    calculateTotal() {
                        const amt = parseFloat(this.amount) || 0;
                        return (amt + parseFloat(this.calculateFee())).toFixed(2);
                    },

                    copyText(text, msg) {
                        navigator.clipboard.writeText(text);
                        const toast = document.getElementById('wallet-toast');
                        toast.innerText = msg;
                        toast.classList.remove('opacity-0', 'translate-y-20');
                        setTimeout(() => toast.classList.add('opacity-0', 'translate-y-20'), 3000);
                    },

                    async initPaystack() {
                        if (this.amount < <?php echo e($publicSettings['min_payment'] ?? 1); ?>) return;
                        this.isLoading = true;

                        try {
                            const res = await fetch('<?php echo e(route('wallet.topup')); ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                                },
                                body: JSON.stringify({
                                    amount: parseFloat(this.amount),
                                    method: 'paystack',
                                    email: '<?php echo e(auth()->user()->email); ?>'
                                })
                            });

                            const data = await res.json();
                            if (!res.ok) throw new Error(data.message || 'Payment failed.');

                            // Synchronized Redirect Flow
                            window.location.href = data.authorization_url;

                        } catch (e) {
                            alert(e.message);
                            this.isLoading = false;
                        }
                    }
                }));
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/wallet/index.blade.php ENDPATH**/ ?>