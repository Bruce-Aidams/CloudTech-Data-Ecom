<div x-data="{ 
    toasts: [],
    addToast(message, type = 'success') {
        const id = Date.now();
        this.toasts.push({ id, message, type });
        setTimeout(() => {
            this.dismiss(id);
        }, 5000);
    },
    dismiss(id) {
        this.toasts = this.toasts.filter(t => t.id !== id);
    }
}" x-init="
    @if(session('success'))
        addToast('{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        addToast('{{ session('error') }}', 'error');
    @endif
    @if($errors->any())
        addToast('{{ $errors->first() }}', 'error');
    @endif
" @toast.window="addToast($event.detail.message, $event.detail.type)"
    class="fixed top-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="true" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
            class="pointer-events-auto min-w-[320px] shadow-[0_8px_30px_rgb(0,0,0,0.18)] rounded-[1.25rem] p-4 flex items-center gap-3 transition-all duration-300 border"
            :class="{
                'bg-emerald-600 text-white border-emerald-500': toast.type === 'success',
                'bg-rose-600 text-white border-rose-500': toast.type === 'error'
            }">

            <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 shadow-inner bg-white/20">
                <template x-if="toast.type === 'success'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </template>
            </div>

            <div class="flex-1 min-w-0">
                <p class="text-[9px] font-black uppercase tracking-[0.2em] text-white/60 mb-0.5"
                    x-text="toast.type === 'success' ? 'Confirmed' : 'System Alert'"></p>
                <p class="text-sm font-black tracking-tight leading-tight" x-text="toast.message"></p>
            </div>

            <button @click="dismiss(toast.id)"
                class="p-1 hover:bg-white/10 rounded-lg text-white/40 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </template>
</div>