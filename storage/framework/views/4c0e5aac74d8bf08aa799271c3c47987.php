

<?php $__env->startSection('title', 'Refer & Earn'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-7xl mx-auto space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-700 pb-20"
        x-data="{ copied: false, copyToClipboard() { navigator.clipboard.writeText('<?php echo e(url('/register?ref=' . $user->referral_code)); ?>'); this.copied = true; setTimeout(() => this.copied = false, 2000); } }">

        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-pink-500/10 flex items-center justify-center text-pink-500 ring-1 ring-pink-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Referral Program
                    </h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Invite friends and earn a 5%
                        commission on their purchases.</p>
                </div>
            </div>
            <button @click="copyToClipboard()"
                class="group relative inline-flex items-center justify-center rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-900 dark:text-white h-14 px-10 shadow-sm hover:border-primary transition-all active:scale-95 overflow-hidden">
                <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <svg class="w-4 h-4 mr-3 text-primary transition-transform group-hover:rotate-12 relative z-10" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                    </path>
                </svg>
                <span class="relative z-10">Copy Referral Link</span>
            </button>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <!-- Referral Link - Premium Dark -->
            <div
                class="lg:col-span-2 rounded-[2.5rem] bg-slate-900 dark:bg-slate-800 p-10 text-white shadow-2xl overflow-hidden relative group">
                <div
                    class="absolute -right-16 -top-16 w-64 h-64 bg-primary/20 rounded-full blur-3xl group-hover:bg-primary/30 transition-all duration-700">
                </div>

                <div class="relative z-10 space-y-12">
                    <div>
                        <h3 class="text-2xl font-black tracking-tighter text-white mb-2 uppercase">Your Referral Link
                        </h3>
                        <p class="text-xs font-bold text-white/40 uppercase tracking-widest">Share this link with your
                            network to earn rewards.</p>
                    </div>

                    <div class="flex gap-4 bg-white/5 p-2 rounded-[1.5rem] border border-white/10 backdrop-blur-md">
                        <input readonly value="<?php echo e(url('/register?ref=' . $user->referral_code)); ?>"
                            class="flex-1 bg-transparent px-6 text-xs font-bold tracking-widest text-primary focus:ring-0 font-mono outline-none">
                        <button @click="copyToClipboard()"
                            class="h-14 px-8 rounded-xl bg-primary text-white text-[10px] font-black uppercase tracking-widest hover:opacity-90 transition-all active:scale-95">
                            <span x-show="!copied">Copy Link</span>
                            <span x-show="copied" x-cloak>Copied</span>
                        </button>
                    </div>

                    <div class="flex items-center gap-6">
                        <div class="flex -space-x-3">
                            <?php $__currentLoopData = array_slice($referrals->toArray()['data'] ?? [], 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div
                                    class="w-10 h-10 rounded-xl border-2 border-slate-900 bg-slate-800 flex items-center justify-center text-[10px] font-black text-white hover:z-10 transition-transform hover:-translate-y-1 cursor-default">
                                    <?php echo e(strtoupper(substr($ref['name'], 0, 1))); ?>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($referrals) > 3): ?>
                                <div
                                    class="w-10 h-10 rounded-xl border-2 border-slate-900 bg-primary text-white flex items-center justify-center text-[10px] font-black shadow-lg shadow-primary/20">
                                    +<?php echo e(count($referrals) - 3); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="text-[9px] font-black uppercase tracking-[.25em] text-white/30">Your network's growth at a
                            glance</p>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div
                class="bg-gradient-to-br from-indigo-700 via-indigo-600 to-blue-600 rounded-[2.5rem] p-10 shadow-xl relative overflow-hidden group text-white">
                <div
                    class="absolute bottom-0 left-0 w-32 h-32 bg-slate-50 dark:bg-slate-800/50 rounded-tr-full pointer-events-none group-hover:scale-110 transition-transform">
                </div>

                <h3 class="text-[10px] font-black uppercase tracking-[.3em] text-white/50 mb-12">
                    Program Statistics</h3>

                <div class="space-y-10 relative z-10">
                    <div class="flex items-center gap-6 group/stat">
                        <div
                            class="w-16 h-16 bg-white/10 backdrop-blur-md text-white rounded-[1.5rem] flex items-center justify-center transition-all group-hover/stat:rotate-12 group-hover/stat:scale-110">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-4xl font-black text-white tracking-tighter tabular-nums">
                                <?php echo e(count($referrals)); ?>

                            </p>
                            <p class="text-[9px] font-black uppercase tracking-widest text-white/50">Referred Users</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 group/stat">
                        <div
                            class="w-16 h-16 bg-white/10 backdrop-blur-md text-white rounded-[1.5rem] flex items-center justify-center transition-all group-hover/stat:rotate-12 group-hover/stat:scale-110">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-4xl font-black text-white tracking-tighter tabular-nums">5.0%
                            </p>
                            <p class="text-[9px] font-black uppercase tracking-widest text-white/50">Commission Rate</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div
            class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-[2.5rem] overflow-hidden shadow-sm">
            <div
                class="px-10 py-8 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/20">
                <h3 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 dark:text-slate-600">Referral
                    History</h3>
            </div>

            <div class="overflow-x-auto">
                <?php if($referrals->isEmpty()): ?>
                    <div class="text-center py-24 opacity-30">
                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                        <p class="text-[10px] font-black uppercase tracking-[.25em]">No referrals found yet</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[700px]">
                            <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                                <tr>
                                    <th class="px-10 py-5 text-[9px] font-black uppercase tracking-widest text-slate-400">User
                                    </th>
                                    <th class="px-10 py-5 text-[9px] font-black uppercase tracking-widest text-slate-400">Email
                                        Address</th>
                                    <th
                                        class="px-10 py-5 text-[9px] font-black uppercase tracking-widest text-slate-400 text-right">
                                        Joined On</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                                <?php $__currentLoopData = $referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr
                                        class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all border-b border-slate-50 dark:border-slate-800 md:border-none">
                                        <td class="px-10 py-6">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-slate-100 flex items-center justify-center font-black text-[10px] uppercase shadow-sm group-hover:bg-primary group-hover:text-white transition-all">
                                                    <?php echo e(strtoupper(substr($referral->name, 0, 1))); ?>

                                                </div>
                                                <span
                                                    class="font-bold text-slate-900 dark:text-white uppercase tracking-tight"><?php echo e($referral->name); ?></span>
                                            </div>
                                        </td>
                                        <td class="px-10 py-6">
                                            <span
                                                class="text-xs font-mono font-bold text-slate-400 group-hover:text-primary transition-colors"><?php echo e($referral->email); ?></span>
                                        </td>
                                        <td class="px-10 py-6 text-right">
                                            <span
                                                class="text-[9px] font-black text-slate-400 uppercase tracking-widest tabular-nums"><?php echo e($referral->created_at->format('M d, Y')); ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($referrals->hasPages()): ?>
                <div class="px-10 py-6 border-t border-slate-50 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/10">
                    <?php echo e($referrals->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/referrals.blade.php ENDPATH**/ ?>