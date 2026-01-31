

<?php $__env->startSection('title', 'System Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-6xl mx-auto space-y-6 pb-20 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="settingsForm()">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-slate-500/10 flex items-center justify-center text-slate-500 ring-1 ring-slate-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Global Configuration</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Fine-tune platform parameters and security protocols.</p>
                </div>
            </div>

            <div x-show="successMessage" x-transition
                class="px-4 py-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-100 dark:border-emerald-800/50 text-xs font-bold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                <span x-text="successMessage"></span>
            </div>
        </div>

        <!-- System Navigation -->
        <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto">
            <?php $__currentLoopData = [
                    'general' => ['icon' => 'globe-alt', 'label' => 'General'],
                    'security' => ['icon' => 'shield-check', 'label' => 'Security'],
                    'financials' => ['icon' => 'credit-card', 'label' => 'Financials'],
                    'notifications' => ['icon' => 'bell', 'label' => 'Notifications'],
                    'history' => ['icon' => 'clock', 'label' => 'Login History']
                ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <button @click="tab = '<?php echo e($t); ?>'"
                                                                            :class="tab === '<?php echo e($t); ?>' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                                                                            class="px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-2 whitespace-nowrap">
                                                                            <span x-show="tab === '<?php echo e($t); ?>'" class="w-1.5 h-1.5 rounded-full bg-primary animate-pulse"></span>
                                                                            <?php echo e($info['label']); ?>

                                                                        </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Configuration Panels -->
        <div class="grid gap-8 lg:grid-cols-12">
            <!-- Left: Settings Form -->
            <div class="lg:col-span-8 space-y-6">

                
                <div x-show="tab === 'general'" class="space-y-6">
                    <div class="space-y-6">
                         <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                            <div class="space-y-6">
                                <div class="grid md:grid-cols-2 gap-6">
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Site Designation</label>
                                        <input type="text" x-model="settings.site_name" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Support Line</label>
                                        <input type="text" x-model="settings.support_phone" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Public Description</label>
                                    <textarea x-model="settings.site_description" rows="3" class="w-full p-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white resize-none"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm" x-data="{ mmLoading: false }">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full" :class="(settings.maintenance_mode == '1' || settings.maintenance_mode == 'true') ? 'bg-rose-500 animate-pulse' : 'bg-emerald-500'"></span>
                                System Status
                            </h3>

                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                <div class="flex items-start gap-4">
                                     <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors"
                                        :class="(settings.maintenance_mode == '1' || settings.maintenance_mode == 'true') ? 'bg-rose-100 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400' : 'bg-emerald-100 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400'">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-base font-bold text-slate-900 dark:text-white">Maintenance Mode</h4>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 max-w-sm leading-relaxed">
                                            When active, only administrators can access the system. Other users will see a "Under Maintenance" page.
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <span class="text-xs font-bold uppercase tracking-wider" 
                                        :class="(settings.maintenance_mode == '1' || settings.maintenance_mode == 'true') ? 'text-rose-500' : 'text-slate-400'">
                                        <span x-text="(settings.maintenance_mode == '1' || settings.maintenance_mode == 'true') ? 'System Offline' : 'System Online'"></span>
                                    </span>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" 
                                            :checked="settings.maintenance_mode == '1' || settings.maintenance_mode == 'true'"
                                            @change="
                                                settings.maintenance_mode = $event.target.checked ? '1' : '0';
                                                mmLoading = true;
                                                fetch('<?php echo e(route('admin.settings.update')); ?>', {
                                                    method: 'PUT',
                                                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                                                    body: JSON.stringify({ settings: { maintenance_mode: settings.maintenance_mode } })
                                                })
                                                .then(res => res.json())
                                                .then(data => {
                                                    successMessage = data.message || 'Status Updated';
                                                    setTimeout(() => successMessage = '', 2000);
                                                })
                                                .finally(() => mmLoading = false);
                                            ">
                                        <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-rose-300 dark:peer-focus:ring-rose-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-rose-500"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div x-show="tab === 'security'" class="space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-8 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-purple-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 012 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            Access Control & API
                        </h3>
                        <div class="space-y-6">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Universal API Authorization</label>
                                <div class="relative group">
                                    <input :type="showKey ? 'text' : 'password'" x-model="settings.api_token" class="w-full h-12 pl-4 pr-12 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                    <button @click="showKey = !showKey" type="button" class="absolute right-3 top-1/2 -translate-y-1/2 p-1.5 text-slate-400 hover:text-primary transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div x-show="tab === 'financials'" class="space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-8 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            Economic Parameters
                        </h3>
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Min Deposit (GHS)</label>
                                        <input type="number" x-model="settings.min_payment" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                    </div>
                                    <div class="space-y-1.5">
                                        <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Max Deposit (GHS)</label>
                                        <input type="number" x-model="settings.max_payment" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                    </div>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Global Commission Rate (%)</label>
                                    <input type="number" step="0.1" x-model="settings.commission_rate" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Paystack Public Key</label>
                                    <input type="text" x-model="settings.paystack_public" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white" placeholder="pk_test_...">
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Paystack Secret Key</label>
                                    <input type="password" x-model="settings.paystack_secret" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-xs font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white" placeholder="sk_test_...">
                                </div>
                            </div>
                            <div class="space-y-6">
                                <div class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                                    <h4 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-4">Gateway Protocols</h4>
                                    <div class="space-y-4">
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="checkbox" :checked="settings.enable_paystack == '1'" @change="settings.enable_paystack = $event.target.checked ? '1' : '0'" class="w-4 h-4 text-primary rounded-md border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:ring-primary/20">
                                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">Enable Paystack Gateway</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="checkbox" :checked="settings.enable_momo_deposits == '1'" @change="settings.enable_momo_deposits = $event.target.checked ? '1' : '0'" class="w-4 h-4 text-primary rounded-md border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:ring-primary/20">
                                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">Permit MOMO Payments</span>
                                        </label>
                                        <label class="flex items-center gap-3 cursor-pointer group">
                                            <input type="checkbox" :checked="settings.enable_manual_transfer == '1'" @change="settings.enable_manual_transfer = $event.target.checked ? '1' : '0'" class="w-4 h-4 text-primary rounded-md border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 focus:ring-primary/20">
                                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">Allow Manual Bank Transfers</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="space-y-1.5 pt-2">
                                    <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Momo Charge Type</label>
                                    <select x-model="settings.charge_type" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                        <option value="percentage">Percentage (%)</option>
                                        <option value="flat">Flat Fee (GHS)</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Gateway Fee Value</label>
                                    <input type="number" step="0.01" x-model="settings.charge_value" class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div x-show="tab === 'notifications'" class="space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-8 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-xl bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </div>
                            Communication Node
                        </h3>
                        <div class="space-y-6">
                            <div class="space-y-1.5">
                                <label class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Global Announcement Payload</label>
                                <textarea x-model="settings.site_alert_message" rows="4" class="w-full p-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white resize-none"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div x-show="tab === 'history'" class="space-y-6" x-data="{ historySearch: '' }">
                    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                Login Activity
                            </h3>
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <input type="text" x-model="historySearch" @keydown.enter.prevent="loadActivities(1, historySearch)" placeholder="Search user or IP..." 
                                        class="h-9 px-3 pl-9 bg-slate-50 dark:bg-slate-800 border-none rounded-lg text-xs font-medium focus:ring-2 focus:ring-indigo-500/20 outline-none w-48">
                                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                                <button @click="loadActivities(1, historySearch)" :disabled="activitiesLoading" class="p-2 text-slate-400 hover:text-primary transition-colors rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800">
                                    <svg class="w-4 h-4" :class="{ 'animate-spin': activitiesLoading }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                </button>
                            </div>
                        </div>

                        <!-- Desktop Table / Mobile Grid -->
                        <div class="relative">
                            <!-- Helper for loading overlay -->
                            <div x-show="activitiesLoading" class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm z-10 flex items-center justify-center rounded-2xl">
                                <svg class="animate-spin h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>

                            <div class="space-y-4">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-100 dark:border-slate-800">
                                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">User</th>
                                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">IP Address</th>

                                        <th class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Time</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <template x-for="activity in activities" :key="activity.id">
                                        <tr class="group hover:bg-white dark:hover:bg-slate-800 transition-colors">
                                            <td class="px-6 py-4 text-xs font-bold text-slate-700 dark:text-slate-300">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-[10px]">
                                                        <span x-text="activity.user ? activity.user.name.charAt(0) : '?'"></span>
                                                    </div>
                                                    <span x-text="activity.user ? activity.user.name : 'Unknown'"></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-xs font-mono text-slate-500" x-text="activity.ip_address"></td>

                                            <td class="px-6 py-4 text-xs text-slate-500 text-right" x-text="new Date(activity.created_at).toLocaleString()"></td>
                                        </tr>
                                    </template>
                                    <template x-if="activities.length === 0 && !activitiesLoading">
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-xs text-slate-400 font-medium">No login activities recorded.</td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>

                             <!-- Loading State -->
                            <div x-show="activitiesLoading" class="p-8 flex justify-center">
                                <svg class="animate-spin h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            </div>
                        </div>

                        <!-- Simple Pagination -->
                        <div class="flex justify-between items-center mt-6 pt-6 border-t border-slate-100 dark:border-slate-800" x-show="activitiesLastPage > 1">
                             <button @click="loadActivities(activitiesPage - 1, historySearch)" :disabled="activitiesPage <= 1" 
                                class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-900 dark:hover:text-white disabled:opacity-30 transition-colors flex items-center gap-2">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                Prev
                             </button>
                             <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Page <span x-text="activitiesPage"></span> / <span x-text="activitiesLastPage"></span></span>
                             <button @click="loadActivities(activitiesPage + 1, historySearch)" :disabled="activitiesPage >= activitiesLastPage" 
                                class="px-4 py-2 text-xs font-bold text-slate-500 hover:text-slate-900 dark:hover:text-white disabled:opacity-30 transition-colors flex items-center gap-2">
                                Next
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                             </button>
                        </div>
                    </div>
                </div>

                <!-- Footer Action -->
                <div class="flex items-center justify-end pt-6 border-t border-slate-100 dark:border-slate-800">
                    <button @click="saveSettings()" :disabled="loading"
                        class="h-14 px-10 bg-primary text-white rounded-2xl font-bold text-sm shadow-xl shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-3 disabled:opacity-50">
                        <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="loading ? 'Synchronizing...' : 'Save System State'"></span>
                    </button>
                </div>
            </div>

            <!-- Right: Info/Sidebar -->
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 text-white relative overflow-hidden group">
                    <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-primary/20 rounded-full blur-3xl group-hover:bg-primary/30 transition-all"></div>
                    <div class="relative z-10">
                        <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                             <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             Configuration Guide
                        </h4>
                        <div class="space-y-4">
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                                <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1">State Integrity</p>
                                <p class="text-xs text-slate-400 leading-relaxed">Changes to global settings take effect immediately across all system nodes.</p>
                            </div>
                            <div class="p-4 bg-white/5 rounded-2xl border border-white/10">
                                <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest mb-1">Security Protocol</p>
                                <p class="text-xs text-slate-400 leading-relaxed">Ensure API tokens and secrets are rotated periodically for maximum security.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-6">System Health</h4>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">Environment</span>
                            <span class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-lg text-[10px] font-bold">Production</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-500 font-bold uppercase tracking-widest">Version</span>
                            <span class="text-xs font-mono text-slate-400">v2.4.8-stable</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function settingsForm() {
            return {
                tab: 'general',
                loading: false,
                settings: <?php echo json_encode($settings, 15, 512) ?>,
                successMessage: '',
                errorMessage: '',
                showKey: false,
                activities: [],
                activitiesLoading: false,
                activitiesPage: 1,
                activitiesLastPage: 1,
                historySearch: '',

                async init() {
                    // Watch for tab change to history
                    this.$watch('tab', (value) => {
                        if (value === 'history' && this.activities.length === 0) {
                            this.loadActivities();
                        }
                    });
                },

                async loadActivities(page = 1, search = '') {
                    this.activitiesLoading = true;
                    try {
                        let url = `<?php echo e(route('admin.settings.login-activities')); ?>?page=${page}`;
                        if (search) url += `&search=${encodeURIComponent(search)}`;

                        const response = await fetch(url);
                        const data = await response.json();
                        this.activities = data.data;
                        this.activitiesPage = data.current_page;
                        this.activitiesLastPage = data.last_page;
                    } catch (e) {
                        this.errorMessage = 'Failed to load login history.';
                    } finally {
                        this.activitiesLoading = false;
                    }
                },

                async toggleMaintenance(checked) {
                    this.settings.maintenance_mode = checked ? '1' : '0';
                    this.loading = true; // reusing main loading or could verify separate one

                    try {
                        const response = await fetch('<?php echo e(route('admin.settings.update')); ?>', {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                            body: JSON.stringify({ settings: { maintenance_mode: this.settings.maintenance_mode } })
                        });

                        const data = await response.json();
                        this.successMessage = data.message || 'Status Updated';
                        setTimeout(() => this.successMessage = '', 2000);
                    } catch (e) {
                         this.errorMessage = 'Failed to update status';
                    } finally {
                        this.loading = false;
                    }
                },

                async saveSettings() {
                    this.loading = true;
                    this.successMessage = '';
                    this.errorMessage = '';

                    try {
                        const response = await fetch('<?php echo e(route('admin.settings.update')); ?>', {
                            method: 'PUT',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                            },
                            body: JSON.stringify({ settings: this.settings })
                        });

                        const data = await response.json();
                        if (response.ok) {
                            this.successMessage = data.message || 'Configuration synchronized!';
                            setTimeout(() => this.successMessage = '', 3000);
                        } else {
                            this.errorMessage = data.message || 'Sync failed.';
                        }
                    } catch (e) {
                        this.errorMessage = 'Network protocol error.';
                    } finally {
                        this.loading = false;
                    }
                }
            }
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/settings.blade.php ENDPATH**/ ?>