

<?php $__env->startSection('title', 'Manage My E-Store'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-8 pb-20 animate-in fade-in slide-in-from-bottom-4 duration-700">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h2
                    class="text-3xl font-black tracking-tight text-foreground dark:text-white bg-clip-text text-transparent bg-gradient-to-r from-primary to-indigo-600 uppercase">
                    Manage E-Store
                </h2>
                <p class="text-sm text-muted-foreground dark:text-slate-400 font-medium mt-1">Set your custom prices and
                    maximize your profit margins.</p>
            </div>

            <div class="flex items-center gap-4">
                
                <form action="<?php echo e(route('reseller.store.toggle')); ?>" method="POST"
                    class="flex items-center gap-3 bg-white dark:bg-slate-900 px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
                    <?php echo csrf_field(); ?>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">Store Status</span>
                    <button type="submit"
                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors <?php echo e($user->store_active ? 'bg-emerald-500' : 'bg-slate-200 dark:bg-slate-700'); ?>">
                        <span
                            class="inline-block h-4 w-4 transform rounded-full bg-white transition <?php echo e($user->store_active ? 'translate-x-6' : 'translate-x-1'); ?>"></span>
                    </button>
                </form>

                <a href="<?php echo e(route('reseller.hub')); ?>"
                    class="h-10 px-6 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-800 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all active:scale-95 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Hub
                </a>
            </div>
        </div>

        
        <div class="relative overflow-hidden group">
            <div
                class="absolute inset-0 bg-gradient-to-br from-primary/10 via-indigo-600/5 to-transparent rounded-[2.5rem]">
            </div>
            <div class="absolute top-0 right-0 p-12 opacity-10 group-hover:scale-110 transition-transform duration-700">
                <svg class="w-32 h-32 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
            </div>

            <div class="relative z-10 p-8 md:p-10 space-y-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-1 bg-primary rounded-full"></div>
                    <h3 class="text-primary font-black uppercase tracking-[0.3em] text-[10px]">Your Digital Storefront</h3>
                </div>

                <div class="flex flex-col lg:flex-row items-center gap-4">
                    <div class="flex-1 w-full group/input relative">
                        <div class="absolute inset-y-0 left-6 flex items-center text-primary/40">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                            </svg>
                        </div>
                        <div
                            class="w-full h-14 md:h-16 bg-white/60 dark:bg-slate-900/60 backdrop-blur-md border border-primary/20 rounded-2xl md:rounded-3xl pl-14 pr-6 flex items-center text-xs md:text-sm font-mono font-bold text-foreground dark:text-white overflow-hidden shadow-inner">
                            <span class="truncate"><?php echo e(route('store.show', $user->referral_code)); ?></span>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                        <button onclick="copyToClipboard('<?php echo e(route('store.show', $user->referral_code)); ?>')"
                            class="flex-1 lg:flex-none h-14 md:h-16 px-6 bg-primary text-white rounded-2xl md:rounded-3xl font-black text-[10px] md:text-xs uppercase tracking-widest shadow-xl shadow-primary/30 active:scale-95 transition-all whitespace-nowrap hover:bg-primary-focus flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            Copy
                        </button>
                        <a href="<?php echo e(route('store.show', $user->referral_code)); ?>" target="_blank"
                            class="flex-1 lg:flex-none h-14 md:h-16 px-6 bg-white dark:bg-slate-800 text-foreground dark:text-white border border-slate-200 dark:border-slate-700 rounded-2xl md:rounded-3xl font-black text-[10px] md:text-xs uppercase tracking-widest shadow-lg active:scale-95 transition-all whitespace-nowrap hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center justify-center gap-2">
                            <span>Preview</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        <form action="<?php echo e(route('reseller.store.regenerate')); ?>" method="POST"
                            onsubmit="return confirm('Are you sure you want to regenerate your store link? Old links will stop working immediately!')"
                            class="flex-1 lg:flex-none">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="w-full h-14 md:h-16 px-6 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 border border-slate-200 dark:border-slate-700 rounded-2xl md:rounded-3xl font-black text-[10px] md:text-xs uppercase tracking-widest shadow hover:bg-slate-200 dark:hover:bg-slate-700 active:scale-95 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Regenerate
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="grid gap-6 md:gap-8 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = $bundles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bundle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div
                    class="group relative bg-white dark:bg-slate-900 rounded-[2rem] border border-slate-100 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    
                    <div
                        class="aspect-[16/9] bg-slate-50 dark:bg-slate-800/50 relative flex items-center justify-center overflow-hidden">
                        
                        <div class="absolute top-4 left-4 z-10">
                            <?php
                                $net = strtoupper($bundle->network);
                                $netColors = [
                                    'MTN' => 'bg-yellow-400 text-yellow-950',
                                    'TELECEL' => 'bg-red-500 text-white',
                                    'AT' => 'bg-blue-600 text-white',
                                    'AIRTELTIGO' => 'bg-blue-600 text-white',
                                ];
                                $nc = $netColors[$net] ?? 'bg-slate-900 text-white';
                            ?>
                            <span
                                class="px-3 py-1 rounded-xl text-[10px] font-black tracking-widest uppercase shadow-lg backdrop-blur-md <?php echo e($nc); ?>">
                                <?php echo e($bundle->network); ?>

                            </span>
                        </div>

                        <?php if($bundle->image_url): ?>
                            <img src="<?php echo e($bundle->image_url); ?>"
                                class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-700">
                        <?php else: ?>
                            <div class="flex flex-col items-center gap-2 text-slate-300 dark:text-slate-600">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div
                            class="absolute bottom-3 right-4 bg-white/80 dark:bg-slate-900/80 backdrop-blur px-3 py-1 rounded-lg border border-slate-100 dark:border-slate-700">
                            <div class="flex items-baseline gap-1">
                                <span class="text-[9px] font-bold text-slate-400 uppercase">Cost</span>
                                <span
                                    class="text-sm font-black text-slate-900 dark:text-white tabular-nums">₵<?php echo e(number_format($bundle->cost_to_reseller, 2)); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div>
                            <h4 class="text-base font-black text-slate-900 dark:text-white uppercase tracking-tight leading-none line-clamp-1"
                                title="<?php echo e($bundle->name); ?>">
                                <?php echo e($bundle->name); ?>

                            </h4>
                            <p class="text-[10px] font-bold text-primary mt-1.5 uppercase tracking-wider">
                                <?php echo e($bundle->data_amount); ?> Data
                            </p>
                        </div>

                        <form action="<?php echo e(route('reseller.store.update-price')); ?>" method="POST" class="space-y-4">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="bundle_id" value="<?php echo e($bundle->id); ?>">

                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Your Price
                                        (GHS)</label>
                                    <?php if($bundle->profit_per_unit > 0): ?>
                                        <div class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <span class="text-[10px] font-black uppercase tracking-wide">Profit:
                                                ₵<?php echo e(number_format($bundle->profit_per_unit, 2)); ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="relative group/field">
                                    <input type="number" step="0.01" name="price"
                                        value="<?php echo e(number_format($bundle->custom_price, 2, '.', '')); ?>" required
                                        class="w-full h-12 pl-4 pr-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-lg font-black tabular-nums focus:ring-2 focus:ring-primary/20 text-slate-900 dark:text-white shadow-inner transition-colors">
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full h-10 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-bold text-[10px] uppercase tracking-widest hover:bg-primary dark:hover:bg-primary dark:hover:text-white transition-all shadow-lg shadow-slate-900/10 dark:shadow-none flex items-center justify-center gap-2 group/btn">
                                <span>Save</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover/btn:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div id="copy-confirm"
        class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[100] px-6 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-2xl transition-all duration-300 translate-y-20 opacity-0 pointer-events-none flex items-center gap-3">
        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
        </svg>
        Link copied to clipboard
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                const toast = document.getElementById('copy-confirm');
                toast.classList.remove('translate-y-20', 'opacity-0');
                setTimeout(() => {
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/reseller/manage-store.blade.php ENDPATH**/ ?>