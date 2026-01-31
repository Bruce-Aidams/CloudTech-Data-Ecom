<?php
    $unreadNotifications = auth()->user()->notifications()->where('is_read', false)->latest()->take(5)->get();
    // Cache the count from the collection to avoid another DB hit
    $unreadCount = $unreadNotifications->count();
?>

<header
    class="h-20 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-40 px-6 md:px-10 flex items-center justify-between transition-colors duration-300">
    <div class="flex items-center gap-6 flex-1">
        
        <button @click="sidebarOpen = true"
            class="lg:hidden p-2.5 bg-slate-50 dark:bg-slate-800 rounded-xl text-slate-500 dark:text-slate-400 transition-all active:scale-95">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        
        <div class="lg:hidden flex items-center shrink-0">
            <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center border border-primary/20">
                <img src="<?php echo e(asset('favicon.ico')); ?>" alt="Logo" class="w-6 h-6">
            </div>
        </div>

        
        <button @click="isCollapsed = !isCollapsed"
            class="hidden lg:flex p-2.5 bg-slate-50 dark:bg-slate-800 rounded-xl text-slate-400 dark:text-slate-500 hover:text-primary transition-all active:scale-95 group relative">
            <svg x-show="isCollapsed" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
            </svg>
            <svg x-show="!isCollapsed" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>

        
        <div class="relative w-full max-w-md hidden md:block group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 group-focus-within:text-primary transition-colors duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" placeholder="Search..."
                class="w-full pl-11 pr-4 h-11 bg-slate-50 dark:bg-slate-800 border-none focus:ring-2 focus:ring-primary/20 transition-all rounded-xl outline-none text-[10px] font-bold uppercase tracking-widest text-slate-700 dark:text-slate-200 placeholder:text-slate-400 dark:placeholder:text-slate-600">
        </div>
    </div>

    <div class="flex items-center gap-4">
        
        <?php if (isset($component)) { $__componentOriginal2090438866f3dcdb76cd8b070bcc302d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2090438866f3dcdb76cd8b070bcc302d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.theme-toggle','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('theme-toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2090438866f3dcdb76cd8b070bcc302d)): ?>
<?php $attributes = $__attributesOriginal2090438866f3dcdb76cd8b070bcc302d; ?>
<?php unset($__attributesOriginal2090438866f3dcdb76cd8b070bcc302d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2090438866f3dcdb76cd8b070bcc302d)): ?>
<?php $component = $__componentOriginal2090438866f3dcdb76cd8b070bcc302d; ?>
<?php unset($__componentOriginal2090438866f3dcdb76cd8b070bcc302d); ?>
<?php endif; ?>

        
        <div class="relative" x-data="{ 
            open: false, 
            unreadCount: <?php echo e($unreadCount); ?>,
            notifications: <?php echo \Illuminate\Support\Js::from($unreadNotifications->map(fn($n) => [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'type' => $n->type,
                'time_pretty' => $n->created_at->diffForHumans()
            ]))->toHtml() ?>,
            markNotificationAsRead(id, element) {
                fetch(`/notifications/${id}/read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=&quot;csrf-token&quot;]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(response => {
                    if (response.ok) {
                        this.notifications = this.notifications.filter(n => n.id !== id);
                        this.unreadCount = Math.max(0, this.unreadCount - 1);
                    }
                });
            },
            init() {
                setInterval(() => {
                    fetch('<?php echo e(route('notifications.poll')); ?>')
                        .then(response => response.json())
                        .then(data => {
                            this.unreadCount = data.unreadCount;
                            this.notifications = data.notifications;
                        });
                }, 30000);
            }
        }">
            <button @click="open = !open" @click.outside="open = false"
                class="p-2.5 bg-slate-50 dark:bg-slate-800 text-slate-400 dark:text-slate-500 hover:text-primary rounded-xl transition-all relative group">
                <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <template x-if="unreadCount > 0">
                    <span class="absolute top-2 right-2 flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                </template>
            </button>

            <!-- Notification Panel -->
            <div x-show="open" x-cloak x-transition:enter="duration-200 ease-out"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="absolute right-0 mt-4 w-80 md:w-96 bg-white dark:bg-slate-900 rounded-3xl p-4 shadow-2xl border border-slate-100 dark:border-slate-800 z-50">
                <div
                    class="flex items-center justify-between px-4 pb-4 border-b border-slate-50 dark:border-slate-800 mb-2">
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-tight">
                            Notifications</h4>
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Recent updates
                        </p>
                    </div>
                </div>

                <div class="space-y-1 max-h-[350px] overflow-y-auto custom-scrollbar">
                    <template x-for="notification in notifications" :key="notification.id">
                        <div class="p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all group/item cursor-pointer"
                            @click="markNotificationAsRead(notification.id, $el)">
                            <div class="flex gap-4">
                                <template x-if="notification.type === 'success'">
                                    <div class="w-1.5 h-1.5 rounded-full mt-2 bg-emerald-500"></div>
                                </template>
                                <template x-if="notification.type !== 'success'">
                                    <div class="w-1.5 h-1.5 rounded-full mt-2 bg-primary"></div>
                                </template>
                                <div class="flex-1 min-w-0">
                                    <h5 class="text-[11px] font-black text-slate-800 dark:text-slate-200 uppercase tracking-tight leading-none"
                                        x-text="notification.title"></h5>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold mt-1 line-clamp-2 leading-relaxed"
                                        x-text="notification.message"></p>
                                    <p class="text-[8px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest mt-2"
                                        x-text="notification.time_pretty"></p>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="notifications.length === 0">
                        <div class="py-12 flex flex-col items-center justify-center text-center">
                            <svg class="w-12 h-12 text-slate-100 dark:text-slate-800 mb-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">No notifications
                            </p>
                        </div>
                    </template>
                </div>

                <template x-if="unreadCount > 0">
                    <div class="mt-2 pt-2 border-t border-slate-50 dark:border-slate-800">
                        <a href="<?php echo e(url('/dashboard/notifications')); ?>"
                            class="flex items-center justify-center py-2 text-[9px] font-black text-primary uppercase tracking-[0.2em] hover:bg-primary/5 rounded-xl transition-all">
                            View all notifications
                        </a>
                    </div>
                </template>
            </div>
        </div>

        
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false"
                class="flex items-center gap-3 p-1.5 focus:outline-none transition-all active:scale-95 group">
                <div class="relative lg:w-10 lg:h-10 w-9 h-9">
                    <div
                        class="absolute inset-0 bg-primary/20 blur-md rounded-full scale-0 group-hover:scale-125 transition-transform duration-500">
                    </div>
                    <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode(auth()->user()->name)); ?>&background=6366f1&color=fff&bold=true"
                        class="w-full h-full rounded-xl border border-slate-100 dark:border-slate-800 relative z-10">
                </div>
            </button>

            <div x-show="open" x-cloak x-transition:enter="duration-200 ease-out"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="absolute right-0 mt-4 w-64 bg-white dark:bg-slate-900 rounded-3xl p-3 shadow-2xl border border-slate-100 dark:border-slate-800 z-50">
                <div class="p-4 border-b border-slate-50 dark:border-slate-800 mb-2">
                    <p class="font-bold text-sm text-slate-900 dark:text-white truncate uppercase tracking-tight">
                        <?php echo e(auth()->user()->name); ?>

                    </p>
                    <p class="text-[10px] font-bold text-slate-400 truncate mt-0.5 uppercase tracking-wider">
                        <?php echo e(auth()->user()->email); ?>

                    </p>
                </div>

                <div class="space-y-1">
                    <a href="<?php echo e(url('/dashboard/profile')); ?>"
                        class="flex items-center justify-between px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-all">
                        <span>My Profile</span>
                    </a>
                    <a href="<?php echo e(url('/dashboard/settings')); ?>"
                        class="flex items-center justify-between px-4 py-3 rounded-xl text-[10px] font-black uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-all">
                        <span>Settings</span>
                    </a>
                </div>

                <div class="border-t border-slate-50 dark:border-slate-800 my-2"></div>

                <form action="<?php echo e(route('logout')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                        class="flex items-center gap-3 px-4 py-4 rounded-xl text-[10px] font-black text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all w-full text-left uppercase tracking-[0.2em]">
                        Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header><?php /**PATH C:\Users\Bruce\Desktop\Projects\Megaai2\Megaai\cloudtech\resources\views/components/dashboard-header.blade.php ENDPATH**/ ?>