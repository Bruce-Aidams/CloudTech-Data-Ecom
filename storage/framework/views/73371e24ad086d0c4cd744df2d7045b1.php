

<?php $__env->startSection('title', 'System Notifications'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700">
        <!-- Header -->
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 ring-1 ring-amber-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Notification Center</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Broadcast alerts and direct messages to the user base.</p>
                </div>
            </div>

        <?php if(session('success')): ?>
            <div
                class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800/50 rounded-2xl p-4 text-emerald-700 dark:text-emerald-400 text-sm font-bold flex items-center gap-3 animate-in slide-in-from-top-2 duration-300">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                </svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid gap-6 lg:grid-cols-12">
            <!-- Composer Column -->
            <div class="lg:col-span-5 space-y-6">
                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-5">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-8">
                            <div
                                class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Compose Alert</h3>
                                <p
                                    class="text-xs text-slate-500 dark:text-slate-500 mt-1 uppercase tracking-widest font-bold">
                                    Transmission Terminal</p>
                            </div>
                        </div>

                        <form action="<?php echo e(route('admin.notifications.store')); ?>" method="POST" class="space-y-6">
                            <?php echo csrf_field(); ?>
                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Target
                                    Personnel</label>
                                <select name="user_id"
                                    class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                    <option value="all">Broadcast: All Active Entities</option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> (<?php echo e($user->email); ?>)</option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Priority
                                        Index</label>
                                    <select name="type" required
                                        class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                        <option value="info">Standard</option>
                                        <option value="success">Success</option>
                                        <option value="warning">Warning</option>
                                        <option value="error">Critical</option>
                                    </select>
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Header</label>
                                    <input type="text" name="title" required placeholder="Subject..."
                                        class="w-full h-12 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <label
                                    class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Message
                                    Content</label>
                                <textarea name="message" required rows="5" placeholder="Payload details..."
                                    class="w-full p-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 outline-none transition-all resize-none dark:text-white"></textarea>
                            </div>

                            <button type="submit"
                                class="w-full h-14 bg-primary text-white rounded-2xl font-bold text-sm shadow-xl shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Engage Transmission
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- History Column -->
            <div class="lg:col-span-7">
                <div
                    class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col h-full min-h-[600px]">
                    <div
                        class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/20">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Transmission History</h3>
                            <p
                                class="text-[10px] text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest mt-0.5">
                                Communication Ledger</p>
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto divide-y divide-slate-50 dark:divide-slate-800 custom-scrollbar">
                        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-6 hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all flex gap-5 group">
                                <div class="shrink-0">
                                    <?php
                                        $types = [
                                            'error' => 'bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400',
                                            'warning' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400',
                                            'success' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400',
                                            'info' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400'
                                        ];
                                        $tc = $types[$n->type] ?? $types['info'];
                                    ?>
                                    <div
                                        class="w-12 h-12 rounded-2xl flex items-center justify-center <?php echo e($tc); ?> transition-transform group-hover:scale-105">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <?php if($n->type === 'error'): ?>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            <?php elseif($n->type === 'warning'): ?>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                                </path>
                                            <?php elseif($n->type === 'success'): ?>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            <?php else: ?>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            <?php endif; ?>
                                        </svg>
                                    </div>
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1">
                                        <h4 class="font-bold text-sm text-slate-900 dark:text-white truncate pr-4">
                                            <?php echo e($n->title); ?></h4>
                                        <span
                                            class="shrink-0 text-[10px] font-bold text-slate-400 dark:text-slate-600 uppercase tracking-tighter"><?php echo e($n->created_at->diffForHumans()); ?></span>
                                    </div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-3"><?php echo e($n->message); ?>

                                    </p>

                                    <div
                                        class="flex items-center justify-between border-t border-slate-50 dark:border-slate-800/50 pt-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-5 h-5 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[8px] font-bold text-slate-500">
                                                <?php echo e(strtoupper(substr($n->user->name ?? 'G', 0, 1))); ?>

                                            </div>
                                            <span
                                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?php echo e($n->user->name ?? 'Broadcast'); ?></span>
                                        </div>

                                        <form action="<?php echo e(route('admin.notifications.destroy', $n->id)); ?>" method="POST"
                                            onsubmit="return confirm('Purge this record?');">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="p-1.5 text-slate-300 hover:text-rose-500 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="flex flex-col items-center justify-center py-24 text-slate-400 dark:text-slate-700">
                                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4a2 2 0 012-2m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                    </path>
                                </svg>
                                <p class="font-bold text-sm uppercase tracking-widest italic">Silenced History</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>