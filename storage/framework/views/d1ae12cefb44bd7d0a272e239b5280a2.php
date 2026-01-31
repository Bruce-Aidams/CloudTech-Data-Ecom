

<?php $__env->startSection('title', 'API Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ 
                                                                                                        tab: 'providers',
                                                                                                        modalOpen: false, 
                                                                                                        editMode: false,
                                                                                                        provider: { id: '', name: '', base_url: '', webhook_url: '', api_key: '', secret_key: '', is_active: true },
                                                                                                        resetForm() {
                                                                                                            this.provider = { id: '', name: '', base_url: '', webhook_url: '', api_key: '', secret_key: '', is_active: true };
                                                                                                            this.editMode = false;
                                                                                                        },
                                                                                                        openAdd() {
                                                                                                            this.resetForm();
                                                                                                            this.modalOpen = true;
                                                                                                        },
                                                                                                        openEdit(p) {
                                                                                                            this.provider = JSON.parse(JSON.stringify(p));
                                                                                                            this.editMode = true;
                                                                                                            this.modalOpen = true;
                                                                                                        }
                                                                                                    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 ring-1 ring-cyan-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">API Infrastructure</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage external provider connections and
                        transmission logs.</p>
                </div>
            </div>

            <button x-show="tab === 'providers'" @click="openAdd()"
                class="h-11 px-6 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Provider
            </button>
        </div>

        <!-- Tab Controls -->
        <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto">
            <button @click="tab = 'providers'"
                :class="tab === 'providers' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap">
                Active Providers
            </button>
            <button @click="tab = 'connectivity'"
                :class="tab === 'connectivity' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap">
                Connectivity (Webhooks)
            </button>
            <button @click="tab = 'logs'"
                :class="tab === 'logs' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap">
                System Logs
            </button>
            <button @click="tab = 'docs'"
                :class="tab === 'docs' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap">
                Documentation
            </button>
        </div>

        <!-- Connectivity View -->
        <div x-show="tab === 'connectivity'" class="space-y-6">
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-4 mb-10">
                    <div
                        class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 transition-transform hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white">Global Webhooks</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-500 mt-1 uppercase tracking-widest font-bold">
                            External Event Sync</p>
                    </div>
                </div>

                <div class="space-y-8 max-w-3xl">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[.2em]">Webhook
                                Endpoint URL</label>
                            <input type="url" name="webhook_url" id="webhook_url"
                                value="<?php echo e(\App\Models\Setting::where('key', 'webhook_url')->first()?->value); ?>"
                                placeholder="https://external-service.com/api/webhook"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                            <p class="text-[9px] text-slate-400 italic">Target URL for automated outbound POST requests.</p>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[.2em]">Signing
                                Secret Key</label>
                            <input type="text" name="webhook_secret" id="webhook_secret"
                                value="<?php echo e(\App\Models\Setting::where('key', 'webhook_secret')->first()?->value); ?>"
                                placeholder="WH_SECRET_KEY..."
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                        </div>
                    </div>

                    <div
                        class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <h5 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-5">
                            Events to Transmit</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = ['Order Created', 'Order Completed', 'Order Failed', 'Deposit Successful', 'Manual Adjustment']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label
                                    class="flex items-center p-3.5 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-xl cursor-pointer hover:border-primary/50 transition-all group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-primary rounded-md border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-primary/20">
                                    <span
                                        class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors"><?php echo e($event); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="button" @click="async () => {
                                                                                                    const url = document.getElementById('webhook_url').value;
                                                                                                    const secret = document.getElementById('webhook_secret').value;
                                                                                                    const response = await fetch('<?php echo e(route('admin.settings.update')); ?>', {
                                                                                                        method: 'PUT',
                                                                                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>' },
                                                                                                        body: JSON.stringify({ settings: { webhook_url: url, webhook_secret: secret } })
                                                                                                    });
                                                                                                    if(response.ok) alert('Webhook configuration synchronized!');
                                                                                                    else alert('Failed to save webhook settings.');
                                                                                                }"
                            class="h-12 px-8 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-bold text-xs uppercase shadow-lg hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                            Save Infrastructure Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Providers View -->
        <div x-show="tab === 'providers'" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                <?php $__empty_1 = true; $__currentLoopData = $providers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div
                        class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col hover:border-primary/30 transition-all group">
                        <div class="flex items-start justify-between mb-8">
                            <div
                                class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-primary transition-transform group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight <?php echo e($p->is_active ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500'); ?>">
                                <span
                                    class="w-1.5 h-1.5 mr-2 rounded-full <?php echo e($p->is_active ? 'bg-emerald-500' : 'bg-slate-500'); ?>"></span>
                                <?php echo e($p->is_active ? 'Active' : 'Offline'); ?>

                            </span>
                        </div>

                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-1"><?php echo e($p->name); ?></h4>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/80 px-3 py-2 rounded-xl border border-slate-100 dark:border-slate-700/50 mb-8 mt-2 overflow-hidden">
                            <code
                                class="text-[10px] text-slate-500 dark:text-slate-400 font-mono block truncate"><?php echo e($p->base_url); ?></code>
                        </div>

                        <div class="mt-auto flex items-center gap-3">
                            <button @click="openEdit(<?php echo e($p->toJson()); ?>)"
                                class="flex-1 h-11 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-[10px] font-bold uppercase text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                Configure
                            </button>
                            <form action="<?php echo e(route('admin.api.providers.destroy', $p->id)); ?>" method="POST"
                                onsubmit="return confirm('Terminate this provider connection?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                    class="w-11 h-11 flex items-center justify-center text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-span-full py-24 text-center">
                        <div
                            class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Empty Infrastructure</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-500 mt-2 max-w-xs mx-auto">Establish a new API
                            connection to begin processing transaction flows.</p>
                        <button @click="openAdd()"
                            class="mt-8 px-6 py-3 bg-primary text-white rounded-2xl font-bold text-xs uppercase shadow-xl shadow-primary/20 hover:opacity-90 transition-all">Add
                            Provider</button>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Logs View -->
        <div x-show="tab === 'logs'" class="space-y-6">
            <div
                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
                <div
                    class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Traffic Logs</h3>
                        <p
                            class="text-[10px] text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest mt-0.5">
                            Real-time Traffic Analysis</p>
                    </div>

                    <div class="relative min-w-[140px]">
                        <form action="<?php echo e(route('admin.api')); ?>" method="GET">
                            <input type="hidden" name="tab" value="logs">
                            <select name="per_page" onchange="this.form.submit()"
                                class="h-10 w-full px-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold uppercase tracking-widest outline-none focus:ring-4 focus:ring-primary/10 transition-all dark:text-slate-400 appearance-none cursor-pointer">
                                <?php $__currentLoopData = [10, 20, 50, 100, 200]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val); ?>" <?php echo e(request('per_page', 10) == $val ? 'selected' : ''); ?>><?php echo e($val); ?>

                                        Per Page</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </form>
                    </div>
                </div>


                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Timestamp</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Provider</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Endpoint</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800 font-medium">
                            <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-sm font-bold text-slate-900 dark:text-white block"><?php echo e($log->created_at->format('M d, H:i')); ?></span>
                                        <span
                                            class="text-[10px] text-slate-500 dark:text-slate-500 uppercase tracking-tighter"><?php echo e($log->created_at->format('s.u')); ?>ms</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2 py-1 rounded-lg text-[10px] font-bold uppercase bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700/50">
                                            <?php echo e($log->provider->name ?? 'SYSTEM'); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-1.5 py-0.5 rounded text-[8px] font-black bg-slate-900 dark:bg-white text-white dark:text-slate-900 uppercase">
                                                <?php echo e($log->method); ?>

                                            </span>
                                            <code class="text-[10px] text-slate-500 font-mono truncate max-w-[200px]"
                                                title="<?php echo e($log->endpoint); ?>"><?php echo e($log->endpoint); ?></code>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php
                                            $hc = $log->status_code >= 400 ? 'bg-rose-50 dark:bg-rose-900/20 text-rose-600' : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600';
                                        ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black <?php echo e($hc); ?>">
                                            <?php echo e($log->status_code); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button @click="$dispatch('open-log-modal', <?php echo e($log->toJson()); ?>)"
                                            class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center text-slate-400 dark:text-slate-600 italic">No
                                        logs available.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($logs->isNotEmpty()): ?>
                    <div
                        class="px-8 py-4 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest italic">Total Records:
                            <?php echo e($logs->total()); ?>

                        </div>
                        <div><?php echo e($logs->links()); ?></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Provider Management Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm shadow-2xl" @click="modalOpen = false"></div>

            <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200 border border-slate-100 dark:border-slate-800"
                @click.stop>
                <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white"
                            x-text="editMode ? 'Edit Provider' : 'Add Provider'"></h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Configure API connection details</p>
                    </div>
                    <button @click="modalOpen = false"
                        class="p-2 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form
                    :action="editMode ? '<?php echo e(url('admin/api-management/providers')); ?>/' + provider.id : '<?php echo e(route('admin.api.providers.store')); ?>'"
                    method="POST" class="p-8 space-y-6">
                    <?php echo csrf_field(); ?>
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Name</label>
                        <input type="text" name="name" x-model="provider.name" required placeholder="e.g. Paystack"
                            class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                    </div>

                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Base
                            URL</label>
                        <input type="url" name="base_url" x-model="provider.base_url" required
                            placeholder="https://api.example.com"
                            class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                    </div>

                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Webhook
                            URL (Optional)</label>
                        <input type="url" name="webhook_url" x-model="provider.webhook_url" placeholder="https://..."
                            class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">API
                                Key</label>
                            <input type="password" name="api_key" x-model="provider.api_key" placeholder="••••••••"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Secret
                                Key</label>
                            <input type="password" name="secret_key" x-model="provider.secret_key" placeholder="••••••••"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center group cursor-pointer">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="is_active" value="1" x-model="provider.is_active"
                                    class="sr-only peer">
                                <div
                                    class="w-10 h-6 bg-slate-200 dark:bg-slate-700 rounded-full peer peer-checked:bg-primary transition-all">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                </div>
                            </div>
                            <div class="ml-4">
                                <span
                                    class="text-xs font-bold text-slate-700 dark:text-slate-200 block uppercase tracking-tight">Active</span>
                                <span
                                    class="text-[9px] text-slate-500 dark:text-slate-500 font-bold uppercase tracking-tighter">Enable
                                    provider</span>
                            </div>
                        </label>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button" @click="modalOpen = false"
                            class="flex-1 h-12 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-[10px] font-bold uppercase text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">Cancel</button>
                        <button type="submit"
                            class="flex-[2] h-12 bg-primary text-white rounded-2xl font-bold text-[10px] uppercase shadow-xl shadow-primary/20 hover:opacity-90 transition-all"
                            x-text="editMode ? 'Update Provider' : 'Save Provider'"></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- API Log Details Modal -->
        <div x-data="{ open: false, log: {} }" x-show="open" @open-log-modal.window="log = $event.detail; open = true"
            class="fixed inset-0 z-[110] flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="open = false"></div>

            <div
                class="relative w-full max-w-3xl bg-white dark:bg-slate-900 rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh] border border-slate-100 dark:border-slate-800 animate-in zoom-in-95 duration-200">
                <div
                    class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/20">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Transaction Details</h3>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold font-mono tracking-widest mt-0.5"
                            x-text="'ID: ' + log.id"></p>
                    </div>
                    <button @click="open = false"
                        class="p-2 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto space-y-8 custom-scrollbar">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[.2em] mb-2">Code</p>
                            <p class="text-2xl font-black"
                                :class="log.status_code >= 400 ? 'text-rose-600' : 'text-emerald-600'"
                                x-text="log.status_code"></p>
                        </div>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[.2em] mb-2">Method</p>
                            <p class="text-lg font-black text-slate-900 dark:text-white uppercase" x-text="log.method"></p>
                        </div>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[.2em] mb-2">Provider</p>
                            <p class="text-sm font-black text-slate-900 dark:text-white truncate uppercase"
                                x-text="log.provider ? log.provider.name : 'SYSTEM'"></p>
                        </div>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[.2em] mb-2">Time</p>
                            <p class="text-sm font-black text-slate-900 dark:text-white"
                                x-text="new Date(log.created_at).toLocaleTimeString()"></p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[.2em]">Endpoint</label>
                            <div class="bg-slate-900 rounded-xl p-4 border border-slate-800 shadow-inner">
                                <code class="text-emerald-400 text-[11px] font-mono break-all" x-text="log.endpoint"></code>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[.2em]">Response</label>
                            <div
                                class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-inner max-h-[400px] overflow-auto custom-scrollbar">
                                <pre class="text-slate-300 text-[10px] font-mono leading-relaxed"
                                    x-text="JSON.stringify(log.response ? (typeof log.response === 'string' ? JSON.parse(log.response) : log.response) : (log.error_message || 'NO_DATA'), null, 2)"></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="px-8 py-5 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex justify-end">
                    <button @click="open = false"
                        class="px-6 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-[10px] font-bold uppercase text-slate-700 dark:text-slate-300">Close</button>
                </div>
            </div>
        </div>
        <!-- CloudTech API Documentation View -->
        <div x-show="tab === 'docs'" class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700">
            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 md:p-12 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden">

                <!-- Documentation Header -->
                <div class="flex items-center gap-6 mb-12">
                    <div
                        class="w-14 h-14 bg-cyan-500/10 rounded-2xl flex items-center justify-center text-cyan-600 dark:text-cyan-400 ring-1 ring-cyan-500/20">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">CloudTech
                            API Documentation</h4>
                        <p class="text-[10px] text-slate-500 dark:text-slate-500 mt-1 uppercase tracking-widest font-black">
                            Technical Integration & Management Guide</p>
                    </div>
                </div>

                <div class="space-y-16">
                    <!-- Getting Started -->
                    <div class="space-y-4">
                        <h5 class="text-xs font-black uppercase tracking-[.2em] text-cyan-600">Getting Started</h5>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 leading-relaxed max-w-3xl">
                            This guide provides comprehensive instructions for both Admin and Agents to connect their
                            systems to the CloudTech platform. Utilize these endpoints to automate orders, manage users, and
                            synchronize data across your infrastructure.
                        </p>
                    </div>

                    <!-- Connectivity Details -->
                    <div class="grid lg:grid-cols-2 gap-8">
                        <!-- Base URL -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black">01</span>
                                <h4 class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400">Endpoint Access
                                </h4>
                            </div>
                            <div
                                class="bg-slate-950 rounded-2xl p-6 font-mono text-xs text-emerald-400 border border-slate-800 flex items-center justify-between group">
                                <span><?php echo e(url('/api')); ?></span>
                                <button onclick="navigator.clipboard.writeText('<?php echo e(url('/api')); ?>')"
                                    class="opacity-0 group-hover:opacity-100 transition-opacity text-slate-500 hover:text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Auth -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black">02</span>
                                <h4 class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400">Authentication
                                </h4>
                            </div>
                            <div
                                class="bg-slate-950 rounded-2xl p-6 font-mono text-xs text-slate-300 border border-slate-800">
                                <div class="text-purple-400 mb-1">headers: <span class="text-white">{</span></div>
                                <div class="pl-4"><span class="text-sky-400">"Authorization"</span>: <span
                                        class="text-emerald-400">"Bearer YOUR_KEY"</span></div>
                                <div class="text-white mt-1">}</div>
                            </div>
                        </div>
                    </div>

                    <!-- API Routes Grid -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span
                                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black">03</span>
                            <h4 class="text-sm font-black uppercase tracking-[.2em] text-slate-400">Core API Routes</h4>
                        </div>

                        <div class="grid xl:grid-cols-2 gap-12">
                            <!-- Agent Section -->
                            <div class="space-y-6">
                                <h5
                                    class="text-[10px] font-black uppercase tracking-[.3em] text-indigo-500 border-b border-indigo-500/10 pb-2">
                                    Agent / Reseller API</h5>
                                <div class="space-y-3">
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                                        <span
                                            class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                        <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/networks</code>
                                        <span
                                            class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Public
                                            networks</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                                        <span
                                            class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                        <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/products</code>
                                        <span
                                            class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Active
                                            Bundles</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl bg-emerald-500/10 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30">
                                        <span
                                            class="px-2 py-0.5 bg-emerald-500/20 text-emerald-600 text-[9px] font-black uppercase rounded">POST</span>
                                        <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/orders</code>
                                        <span
                                            class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Place
                                            Order</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl bg-emerald-500/10 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30">
                                        <span
                                            class="px-2 py-0.5 bg-emerald-500/20 text-emerald-600 text-[9px] font-black uppercase rounded">POST</span>
                                        <code
                                            class="text-xs font-bold text-slate-700 dark:text-slate-200">/orders/bulk</code>
                                        <span
                                            class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Bulk
                                            Upload</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Admin Section -->
                            <div class="space-y-6">
                                <h5
                                    class="text-[10px] font-black uppercase tracking-[.3em] text-rose-500 border-b border-rose-500/10 pb-2">
                                    System Management (Admin Only)</h5>
                                <div class="space-y-3">
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl bg-rose-50/30 dark:bg-rose-950/10 border border-rose-100/50 dark:border-rose-900/30">
                                        <span
                                            class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                        <code
                                            class="text-xs font-bold text-slate-700 dark:text-slate-200">/admin/users</code>
                                        <span
                                            class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">User
                                            List</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl bg-rose-50/30 dark:bg-rose-950/10 border border-rose-100/50 dark:border-rose-900/30">
                                        <span
                                            class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                        <code
                                            class="text-xs font-bold text-slate-700 dark:text-slate-200">/admin/analytics</code>
                                        <span
                                            class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Platform
                                            Stats</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl bg-rose-50/30 dark:bg-rose-950/10 border border-rose-100/50 dark:border-rose-900/30">
                                        <span
                                            class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                        <code
                                            class="text-xs font-bold text-slate-700 dark:text-slate-200">/admin/api-logs</code>
                                        <span
                                            class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Traffic
                                            Logs</span>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-xl bg-rose-50/30 dark:bg-rose-950/10 border border-rose-100/50 dark:border-rose-900/30">
                                        <span
                                            class="px-2 py-0.5 bg-emerald-500/10 text-emerald-500 text-[9px] font-black uppercase rounded">POST</span>
                                        <code
                                            class="text-xs font-bold text-slate-700 dark:text-slate-200">/admin/products</code>
                                        <span
                                            class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Create
                                            Bundle</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Webhooks -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span
                                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black">04</span>
                            <h4 class="text-sm font-black uppercase tracking-[.2em] text-slate-400">Webhook Sync</h4>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-8">
                            <div
                                class="p-8 rounded-3xl bg-indigo-50/30 dark:bg-indigo-950/10 border border-indigo-100/50 dark:border-indigo-900/30 space-y-4">
                                <h5 class="text-[10px] font-black uppercase text-indigo-600 tracking-widest">Outgoing Events
                                </h5>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed">External systems receive
                                    real-time updates for order completions and failure events.</p>
                                <div
                                    class="bg-slate-950 rounded-2xl p-6 font-mono text-[10px] text-slate-300 border border-slate-800">
                                    <span class="text-purple-400">{</span><br>
                                    <span class="pl-4">"event": <span
                                            class="text-emerald-400">"order.completed"</span>,</span><br>
                                    <span class="pl-4">"data": { "status": "success" }</span><br>
                                    <span class="text-purple-400">}</span>
                                </div>
                            </div>

                            <div
                                class="p-8 rounded-3xl bg-emerald-50/30 dark:bg-emerald-950/10 border border-emerald-100/50 dark:border-emerald-900/30 space-y-4">
                                <h5 class="text-[10px] font-black uppercase text-emerald-600 tracking-widest">Incoming
                                    Webhooks</h5>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed">Providers push transaction
                                    status updates to your system via: <code>/api/webhooks/incoming</code></p>
                                <div class="pt-2">
                                    <span
                                        class="inline-flex px-3 py-1 bg-emerald-500 text-white rounded-lg text-[9px] font-black uppercase">Active
                                        Endpoint</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Codes -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span
                                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black">05</span>
                            <h4 class="text-sm font-black uppercase tracking-[.2em] text-slate-400">Infrastructure Result
                                Codes</h4>
                        </div>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-center">
                                <p class="text-[9px] font-black text-indigo-500 mb-1">200</p>
                                <p
                                    class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    Success</p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-center">
                                <p class="text-[9px] font-black text-rose-500 mb-1">401</p>
                                <p
                                    class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    Unauthorized</p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-center">
                                <p class="text-[9px] font-black text-amber-500 mb-1">422</p>
                                <p
                                    class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    Validation</p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-center">
                                <p class="text-[9px] font-black text-slate-400 mb-1">500</p>
                                <p
                                    class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    Server Error</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/api/index.blade.php ENDPATH**/ ?>