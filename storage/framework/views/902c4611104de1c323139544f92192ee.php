

<?php $__env->startSection('title', 'Profile Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="max-w-5xl mx-auto space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700"
        x-data="{ isEditing: false, toggle() { if (this.isEditing) { document.getElementById('profile-form').submit(); } this.isEditing = !this.isEditing; } }">

        <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="text-center sm:text-left">
                <h2
                    class="text-3xl font-black tracking-tight text-foreground bg-clip-text text-transparent bg-gradient-to-r from-primary to-indigo-500">
                    Profile Settings</h2>
                <p class="text-muted-foreground font-medium">Manage your personal information and account security.</p>
            </div>

            <button @click="toggle()"
                class="group relative inline-flex items-center justify-center rounded-[1.5rem] text-[10px] font-black uppercase tracking-widest ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-14 px-10 shadow-2xl transition-all"
                :class="isEditing ? 'bg-primary text-primary-foreground shadow-primary/40 scale-[1.02]' : 'bg-card/50 backdrop-blur-xl border border-border/10 text-foreground shadow-slate-200/20 dark:shadow-none hover:scale-[1.02]'">
                <template x-if="isEditing">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-3 transition-transform group-hover:rotate-12" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Save changes
                    </span>
                </template>
                <template x-if="!isEditing">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-3 transition-transform group-hover:rotate-12" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                            </path>
                        </svg>
                        Edit profile
                    </span>
                </template>
            </button>
        </div>

        <div class="grid gap-10 md:grid-cols-3">
            <!-- User Card -->
            <div
                class="rounded-[3rem] border border-border/50 bg-card/50 backdrop-blur-2xl shadow-2xl shadow-slate-200/20 dark:shadow-none h-fit p-10 transition-all hover:scale-[1.01]">
                <div class="flex flex-col items-center">
                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-primary to-indigo-500 rounded-[2.5rem] blur opacity-25 group-hover:opacity-50 transition duration-700">
                        </div>
                        <div
                            class="relative w-36 h-36 rounded-[2.2rem] border-4 border-white dark:border-slate-800 shadow-xl overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($user->name)); ?>&background=696cff&color=fff&size=200"
                                alt="<?php echo e($user->name); ?>"
                                class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-700">
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <h3 class="text-2xl font-black text-foreground tracking-tighter"><?php echo e($user->name); ?></h3>
                        <p
                            class="text-[10px] font-black text-primary uppercase tracking-[0.3em] mt-2 bg-primary/10 px-4 py-1.5 rounded-full inline-block">
                            <?php echo e(str_replace('_', ' ', $user->role)); ?>

                        </p>
                    </div>

                    <div class="w-full mt-10 space-y-6 pt-10 border-t border-border/10">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-black uppercase tracking-widest text-slate-400">Account status</span>
                            <span
                                class="text-emerald-500 font-black uppercase tracking-widest text-[9px] bg-emerald-50 dark:bg-emerald-900/20 px-3 py-1 rounded-lg">Active</span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-black uppercase tracking-widest text-slate-400">Member since</span>
                            <span
                                class="text-foreground font-black tracking-tight font-mono"><?php echo e($user->created_at->format('d.m.Y')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Form -->
            <div class="md:col-span-2 space-y-8">
                <div
                    class="rounded-[3rem] border border-border/50 bg-card/50 backdrop-blur-2xl p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none transition-all hover:scale-[1.005]">
                    <div class="mb-10">
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-xl bg-indigo-100 dark:bg-indigo-900/20 flex items-center justify-center text-indigo-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                    </path>
                                </svg>
                            </div>
                            Basic Information
                        </h3>
                    </div>

                    <form action="<?php echo e(route('profile.update')); ?>" method="POST" id="profile-form" class="space-y-8">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="grid gap-8 sm:grid-cols-2">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Full
                                    Name</label>
                                <div class="relative group">
                                    <input type="text" name="name" value="<?php echo e($user->name); ?>" :readonly="!isEditing"
                                        class="w-full h-14 px-6 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white"
                                        :class="isEditing ? 'bg-white dark:bg-slate-900 shadow-xl' : 'cursor-default'">
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Email
                                    Address</label>
                                <div class="relative group">
                                    <input type="email" name="email" value="<?php echo e($user->email); ?>" :readonly="!isEditing"
                                        class="w-full h-14 px-6 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white"
                                        :class="isEditing ? 'bg-white dark:bg-slate-900 shadow-xl' : 'cursor-default'">
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Phone
                                    Number</label>
                                <div class="relative group">
                                    <input type="text" name="phone" value="<?php echo e($user->phone); ?>" :readonly="!isEditing"
                                        class="w-full h-14 px-6 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white"
                                        :class="isEditing ? 'bg-white dark:bg-slate-900 shadow-xl' : 'cursor-default'">
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Your
                                    Location</label>
                                <div class="relative group">
                                    <input type="text" value="Accra, GH" readonly
                                        class="w-full h-14 px-6 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-black tracking-tight outline-none transition-all dark:text-white opacity-50 cursor-default">
                                </div>
                            </div>
                        </div>
                        <button type="submit" x-show="isEditing" x-cloak class="hidden"></button>
                    </form>
                </div>

                <div
                    class="rounded-[3rem] border border-border/50 bg-card/50 backdrop-blur-2xl p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none transition-all hover:scale-[1.005]">
                    <div class="mb-10">
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-3">
                            <div
                                class="w-8 h-8 rounded-xl bg-rose-100 dark:bg-rose-900/20 flex items-center justify-center text-rose-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </div>
                            Security Settings
                        </h3>
                    </div>

                    <div
                        class="flex flex-col sm:flex-row items-center justify-between gap-6 p-8 rounded-[2rem] bg-slate-50 dark:bg-slate-800/50 border border-border/10 transition-all hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                        <div class="space-y-2 text-center sm:text-left">
                            <p class="text-sm font-black text-foreground tracking-tight">Two-Factor
                                Authentication</p>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                                Two-Factor Authentication</p>
                        </div>
                        <form action="<?php echo e(route('profile.toggle2fa')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                class="h-12 px-8 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all active:scale-95"
                                :class="<?php echo e($user->two_factor_enabled ? 'true' : 'false'); ?> ? 'bg-primary text-white shadow-xl shadow-primary/20' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-300 dark:hover:bg-slate-600'">
                                <?php echo e($user->two_factor_enabled ? '2FA Enabled' : 'Enable 2FA'); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/dashboard/profile.blade.php ENDPATH**/ ?>