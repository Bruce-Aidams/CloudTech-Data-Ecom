

<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700" <div
        class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{
                    modalOpen: false,
                    editMode: false,
                    walletModalOpen: false,
                    walletUser: { id: '', name: '', balance: 0 },
                    walletData: { type: 'credit', amount: '', note: '', isSubmitting: false },
                    user: { id: '', name: '', email: '', phone: '', role: 'user', is_active: true, password: '' },
                    resetForm() {
                        this.user = { id: '', name: '', email: '', phone: '', role: 'user', is_active: true, password: '' };
                        this.editMode = false;
                    },
                    openAdd() {
                        this.resetForm();
                        this.modalOpen = true;
                    },
                    openEdit(u) {
                        this.user = JSON.parse(JSON.stringify(u));
                        this.user.is_active = !!this.user.is_active;
                        this.user.password = '';
                        this.editMode = true;
                        this.modalOpen = true;
                    },
                    openWallet(u) {
                        this.walletUser = { id: u.id, name: u.name, balance: u.wallet_balance };
                        this.walletData = { type: 'credit', amount: '', note: '', isSubmitting: false };
                        this.walletModalOpen = true;
                    },
                    async submitWalletAdjustment() {
                        if (this.walletData.isSubmitting) return;
                        this.walletData.isSubmitting = true;

                        try {
                            const response = await fetch(`/admin/users/${this.walletUser.id}/wallet`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    type: this.walletData.type,
                                    amount: this.walletData.amount,
                                    note: this.walletData.note
                                })
                            });

                            const data = await response.json();

                            if (response.ok) {
                                alert(data.message + '\nNew Balance: GHS ' + parseFloat(data.new_balance).toFixed(2));
                                this.walletModalOpen = false;
                                window.location.reload();
                            } else {
                                alert(data.message || 'Failed to adjust wallet');
                            }
                        } catch (error) {
                            alert('An error occurred. Please try again.');
                            console.error(error);
                        } finally {
                            this.walletData.isSubmitting = false;
                        }
                    }
                }">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">User Management</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage platform users, roles and access controls.
                </p>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                
                <form action="<?php echo e(route('admin.users')); ?>" method="GET" class="relative flex-1 md:w-64 group">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-primary transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search users..."
                        class="w-full h-11 pl-10 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-medium outline-none focus:ring-4 focus:ring-primary/10 transition-all">
                </form>

                <button @click="openAdd()"
                    class="h-11 px-6 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add User
                </button>
            </div>
        </div>

        
        <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto">
            <a href="<?php echo e(route('admin.users')); ?>"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all <?php echo e(!request('role') ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'); ?>">
                All Users
            </a>
            <?php $__currentLoopData = ['admin', 'user', 'agent', 'dealer', 'super_agent']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('admin.users', ['role' => $role])); ?>"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all capitalize <?php echo e(request('role') === $role ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'); ?>">
                    <?php echo e(str_replace('_', ' ', $role)); ?>

                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>


        
        <div
            class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                User Profile</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                Role</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                                Balance</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">
                                Status</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                                Joined</th>
                            <th
                                class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-center">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold text-xs ring-1 ring-slate-200 dark:ring-slate-700">
                                            <?php echo e(strtoupper(substr($u->name, 0, 1))); ?>

                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-slate-900 dark:text-white leading-none">
                                                <?php echo e($u->name); ?>

                                            </p>
                                            <p class="text-xs text-slate-500 dark:text-slate-500 mt-1.5"><?php echo e($u->email); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <?php
                                        $roleColors = [
                                            'admin' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400',
                                            'user' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                            'agent' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                            'dealer' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
                                            'super_agent' => 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400'
                                        ];
                                        $rc = $roleColors[$u->role] ?? 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-400';
                                    ?>
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-tight <?php echo e($rc); ?>">
                                        <?php echo e(str_replace('_', ' ', $u->role)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <p class="text-sm font-bold text-slate-900 dark:text-white">GHC
                                        <?php echo e(number_format($u->wallet_balance, 2)); ?>

                                    </p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg text-[10px] font-bold
                                                                                                                                                             <?php echo e($u->is_active ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600' : 'bg-rose-50 dark:bg-rose-900/20 text-rose-600'); ?>">
                                        <span
                                            class="w-1 h-1 rounded-full <?php echo e($u->is_active ? 'bg-emerald-500' : 'bg-rose-500'); ?>"></span>
                                        <?php echo e($u->is_active ? 'Active' : 'Suspended'); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span
                                        class="text-xs font-medium text-slate-500 dark:text-slate-500"><?php echo e($u->created_at->format('M d, Y')); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        
                                        <form action="<?php echo e(route('admin.users.toggle-status', $u->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" title="<?php echo e($u->is_active ? 'Suspend User' : 'Activate User'); ?>"
                                                class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 hover:bg-<?php echo e($u->is_active ? 'orange' : 'green'); ?>-50 dark:hover:bg-<?php echo e($u->is_active ? 'orange' : 'green'); ?>-900/30 text-slate-400 hover:text-<?php echo e($u->is_active ? 'orange' : 'green'); ?>-600 transition-all flex items-center justify-center">
                                                <?php if($u->is_active): ?>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                <?php else: ?>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                <?php endif; ?>
                                            </button>
                                        </form>

                                        
                                        <a href="<?php echo e(route('admin.orders', ['user_id' => $u->id])); ?>" title="View User Orders"
                                            class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 transition-all flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </a>

                                        
                                        <button @click="openWallet(<?php echo e($u->toJson()); ?>)" title="Adjust Wallet Balance"
                                            class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 transition-all flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>

                                        <button @click="openEdit(<?php echo e($u->toJson()); ?>)"
                                            class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 hover:bg-primary/5 dark:hover:bg-primary/10 text-slate-400 hover:text-primary transition-all flex items-center justify-center">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </button>
                                        <form action="<?php echo e(route('admin.users.destroy', $u->id)); ?>" method="POST"
                                            onsubmit="return confirm('Permanently delete this user record?');">
                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            <button type="submit"
                                                class="w-8 h-8 rounded-lg bg-slate-50 dark:bg-slate-800 hover:bg-rose-50 dark:hover:bg-rose-900/30 text-slate-400 hover:text-rose-600 transition-all flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center gap-3 text-slate-400 dark:text-slate-600">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="font-medium">No users found</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($users->isNotEmpty()): ?>
                <div
                    class="px-6 py-4 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                    <div class="text-xs font-bold text-slate-500 dark:text-slate-500 uppercase tracking-widest italic">Total
                        Users: <?php echo e($users->total()); ?></div>
                    <div><?php echo e($users->links()); ?></div>
                </div>
            <?php endif; ?>
        </div>

        
        <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="modalOpen = false"></div>
            <div
                class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200">
                
                <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white"
                            x-text="editMode ? 'Edit User' : 'Add New User'"></h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Define account details and access
                            level
                        </p>
                    </div>
                    <button @click="modalOpen = false"
                        class="p-2 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>

                <form :action="editMode ? '<?php echo e(url('admin/users')); ?>/' + user.id : '<?php echo e(route('admin.users.store')); ?>'"
                    method="POST" class="p-6 space-y-6 max-h-[80vh] overflow-y-auto custom-scrollbar">
                    <?php echo csrf_field(); ?>
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Full
                            Name</label>
                        <input type="text" name="name" x-model="user.name" required
                            class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Email
                                Address</label>
                            <input type="email" name="email" x-model="user.email" required
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">Phone
                                Number</label>
                            <input type="text" name="phone" x-model="user.phone" placeholder="+233..."
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all dark:text-white font-mono">
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">User
                                Role</label>
                            <select name="role" x-model="bundle.role" required
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                                <option value="user">Retail User</option>
                                <option value="agent">Agent</option>
                                <option value="dealer">Dealer</option>
                                <option value="super_agent">Super Agent</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em]">
                                <span x-text="editMode ? 'Password (Leave blank to keep current)' : 'Password'"></span>
                            </label>
                            <input type="password" name="password" x-model="user.password" :required="!editMode"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-medium focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-50 dark:border-slate-800" x-show="editMode">
                        <label class="flex items-center group cursor-pointer">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="is_active" value="1" x-model="user.is_active"
                                    class="sr-only peer">
                                <div
                                    class="w-10 h-6 bg-slate-200 dark:bg-slate-700 rounded-full peer peer-checked:bg-primary transition-all">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                </div>
                            </div>
                            <div class="ml-4">
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-200 block">Account
                                    Active</span>
                                <span class="text-[10px] text-slate-500 dark:text-slate-500 mt-0.5">Allow login and
                                    platform
                                    access</span>
                            </div>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full h-12 bg-primary text-white rounded-2xl font-bold hover:opacity-90 active:scale-95 transition-all shadow-lg shadow-primary/20"
                        x-text="editMode ? 'Update User' : 'Create User'"></button>
                </form>
            </div>
        </div>
    </div>

    <?php echo $__env->make('admin.users.wallet-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/admin/users/index.blade.php ENDPATH**/ ?>