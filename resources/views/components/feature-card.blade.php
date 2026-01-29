@props(['title', 'description'])

<div
    class="group p-8 rounded-[2rem] bg-white bg-white border border-slate-100 border-slate-100 hover:border-primary/20 hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500">
    <div
        class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-800 flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-primary/5 transition-all">
        {{ $icon }}
    </div>
    <h3 class="text-xl font-bold mb-3 text-slate-900 text-slate-900">{{ $title }}</h3>
    <p class="text-slate-500 text-slate-500 text-sm leading-relaxed">{{ $description }}</p>
</div>
