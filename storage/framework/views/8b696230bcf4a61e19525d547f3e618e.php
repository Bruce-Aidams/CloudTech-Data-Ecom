<?php
    // Only fetch if authenticated and only fetch what we need
    $notifications = auth()->check() ? auth()->user()->notifications()->where('is_read', false)->latest()->take(3)->get() : collect();
?>

<?php if($notifications->count() > 0): ?>
    <div x-data="notificationManager()" x-init="init()" class="fixed top-24 right-6 z-50 space-y-4 max-w-sm pointer-events-none">
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div x-show="!dismissed.includes(<?php echo e($notification->id); ?>)"
                x-transition:enter="transform ease-out duration-500"
                x-transition:enter-start="translate-x-full opacity-0 scale-90"
                x-transition:enter-end="translate-x-0 opacity-100 scale-100"
                x-transition:leave="transform ease-in duration-300"  
                x-transition:leave-start="translate-x-0 opacity-100 scale-100"
                x-transition:leave-end="translate-x-full opacity-0 scale-90"
                class="bg-white/90 backdrop-blur-xl border border-white/50 shadow-2xl shadow-indigo-200/50 rounded-[1.5rem] p-5 pointer-events-auto cursor-pointer group/toast overflow-hidden relative"
                @click="markAsRead(<?php echo e($notification->id); ?>)">
                
                <!-- Vibrant Glow Icon -->
                <div class="absolute -right-4 -top-4 w-16 h-16 bg-gradient-to-br from-primary/10 to-transparent rounded-full blur-2xl group-hover/toast:scale-150 transition-transform duration-700"></div>

                <div class="flex items-start justify-between gap-4 relative z-10">
                    <div class="flex items-start gap-4 flex-1">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 shadow-lg transition-transform group-hover/toast:rotate-3
                            <?php echo e($notification->type === 'success' ? 'bg-emerald-500 shadow-emerald-500/20 text-white' : 
                               ($notification->type === 'error' ? 'bg-rose-500 shadow-rose-500/20 text-white' : 
                               ($notification->type === 'warning' ? 'bg-amber-500 shadow-amber-500/20 text-white' : 
                               'bg-indigo-500 shadow-indigo-500/20 text-white'))); ?>">
                            <?php if($notification->type === 'success'): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <?php elseif($notification->type === 'error'): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            <?php elseif($notification->type === 'warning'): ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <?php else: ?>
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <?php endif; ?>
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-black text-slate-900 tracking-tight uppercase leading-none mb-1"><?php echo e($notification->title); ?></h4>
                            <p class="text-[11px] text-slate-500 font-bold leading-relaxed line-clamp-2"><?php echo e($notification->message); ?></p>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <a href="<?php echo e(route('notifications.index')); ?>" class="block text-center py-2 text-[10px] font-black text-slate-500 hover:text-primary uppercase tracking-widest bg-white/50 backdrop-blur-md rounded-xl hover:bg-white/80 transition-all">
            See All Notifications
        </a>
    </div>

    <script>
        function notificationManager() {
            return {
                dismissed: [],
                timers: {},
                
                init() {
                    <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        this.timers[<?php echo e($notification->id); ?>] = setTimeout(() => {
                            this.dismiss(<?php echo e($notification->id); ?>);
                        }, 10000);
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                },
                
                dismiss(id) {
                    if (!this.dismissed.includes(id)) {
                        this.dismissed.push(id);
                    }
                    if (this.timers[id]) {
                        clearTimeout(this.timers[id]);
                    }
                },
                
                markAsRead(id) {
                    this.dismiss(id);
                    fetch(`/notifications/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    });
                }
            }
        }
    </script>
<?php endif; ?>
<?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/components/notifications.blade.php ENDPATH**/ ?>