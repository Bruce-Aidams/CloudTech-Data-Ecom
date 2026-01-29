@props(['title', 'description'])

<div
    class="group p-8 rounded-[2rem] bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 hover:border-primary/20 dark:hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500">
    <div
        class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-primary/5 transition-all">
        {{ $icon }}
    </div>
    <h3 class="text-xl font-bold mb-3 text-slate-900 dark:text-white">{{ $title }}</h3>
    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">{{ $description }}</p>
</div>