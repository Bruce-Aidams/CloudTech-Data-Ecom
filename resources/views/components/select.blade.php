@props(['label' => null, 'error' => null])

<div class="space-y-2 group">
    @if($label)
        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">{{ $label }}</label>
    @endif

    <div class="relative">
        <select {{ $attributes->merge(['class' => 'premium-select' . ($error ? ' border-rose-500 focus:ring-rose-500/5 focus:border-rose-500' : '')]) }}>
            {{ $slot }}
        </select>
    </div>

    @if($error)
        <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest ml-1">{{ $error }}</p>
    @endif
</div>