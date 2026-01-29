@extends('layouts.dashboard')

@section('title', 'API Access')

@section('content')
<div class="max-w-7xl mx-auto space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700"
    x-data="{ formOpen: false }">
    @section('content')
        <div class="max-w-7xl mx-auto space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700"
            x-data="{ formOpen: false }">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2
                        class="text-3xl font-black tracking-tight text-foreground bg-clip-text text-transparent bg-gradient-to-r from-primary to-indigo-500">
                        API Keys</h2>
                    <p class="text-muted-foreground font-medium">Manage your API keys to integrate CloudTech with your own
                        applications.</p>
                </div>
                <button @click="formOpen = !formOpen"
                    class="group relative inline-flex items-center justify-center rounded-[1.5rem] bg-card/50 backdrop-blur-xl border border-border/10 text-[10px] font-black uppercase tracking-widest text-foreground h-14 px-10 shadow-2xl shadow-slate-200/20 dark:shadow-none hover:scale-[1.02] active:scale-95 transition-all">
                    <svg :class="formOpen ? 'rotate-45' : ''"
                        class="w-4 h-4 mr-3 text-primary transition-transform duration-300 group-hover:rotate-12"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span x-text="formOpen ? 'Cancel' : 'Generate New Key'"></span>
                </button>
            </div>

            <!-- Alert: New Key Created -->
            @if(session('new_key'))
                <div
                    class="rounded-[3rem] border border-emerald-200/50 bg-emerald-50/50 backdrop-blur-xl dark:bg-emerald-900/10 dark:border-emerald-900/20 p-10 shadow-2xl shadow-emerald-200/10 dark:shadow-none animate-in zoom-in-95 duration-500">
                    <div class="flex flex-col space-y-4 pb-6 border-b border-emerald-100/50 dark:border-emerald-800/50">
                        <h3 class="text-xl font-black tracking-tighter flex items-center gap-3 text-emerald-600">
                            <div
                                class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/20 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            API Key Generated
                        </h3>
                        <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600/70">
                            Please store this key safely. You won't be able to see it again.
                        </p>
                    </div>
                    <div class="pt-8 space-y-8">
                        <div
                            class="flex items-center gap-4 bg-white/50 dark:bg-slate-900/50 p-4 rounded-2xl border border-emerald-100/50 dark:border-emerald-800/50">
                            <input type="text" value="{{ session('new_key') }}" readonly id="newKeyInput"
                                class="flex h-12 w-full bg-transparent border-none text-sm font-black tracking-tight text-foreground focus:ring-0 font-mono">
                            <button onclick="copyToClipboard('newKeyInput')"
                                class="inline-flex items-center justify-center rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 h-12 w-12 shrink-0 shadow-lg shadow-emerald-200/50 dark:shadow-none transition-all active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <button onclick="this.closest('.rounded-[3rem]').remove()"
                            class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600 hover:text-emerald-700 transition-colors">
                            I have saved it
                        </button>
                    </div>
                </div>
            @endif

            @if(session('success') && !session('new_key'))
                <div
                    class="rounded-2xl border border-border/10 bg-card/50 backdrop-blur-xl p-4 flex items-center gap-4 animate-in slide-in-from-top-4 duration-300">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-xl shadow-emerald-500/50 animate-pulse"></div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-foreground">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Create Form -->
            <div x-show="formOpen" x-collapse x-cloak>
                <div
                    class="rounded-[3rem] border border-border/50 bg-card/50 backdrop-blur-xl p-10 shadow-2xl shadow-slate-200/20 dark:shadow-none transition-all">
                    <div class="mb-10">
                        <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400">Generate New Key</h3>
                    </div>
                    <div class="pt-0">
                        <form action="{{ route('api-keys.store') }}" method="POST" class="space-y-8">
                            @csrf
                            <div class="grid gap-8 sm:grid-cols-2">
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">Key
                                        Name</label>
                                    <input type="text" name="name" required placeholder="e.g., Production Feed"
                                        class="w-full h-14 px-6 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white dark:focus:bg-slate-900 focus:bg-white placeholder:text-slate-300">
                                </div>
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black uppercase tracking-[0.2em] pl-1 text-slate-400">TTL
                                        (Days)</label>
                                    <input type="number" name="expires_in_days" value="365" min="1" max="365" required
                                        class="w-full h-14 px-6 bg-slate-100/50 dark:bg-slate-800/50 border-none rounded-2xl text-sm font-black tracking-tight focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white dark:focus:bg-slate-900 focus:bg-white font-black">
                                </div>
                            </div>
                            <div class="flex gap-4 pt-4">
                                <button type="submit"
                                    class="h-14 px-10 rounded-2xl bg-primary text-[10px] font-black uppercase tracking-widest text-primary-foreground shadow-2xl shadow-primary/40 hover:scale-[1.02] active:scale-95 transition-all">
                                    Generate Key
                                </button>
                                <button type="button" @click="formOpen = false"
                                    class="h-14 px-10 rounded-2xl bg-slate-200 dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest text-foreground hover:bg-slate-300 dark:hover:bg-slate-700 transition-all">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- API Keys List -->
            <div
                class="rounded-[3rem] border border-border/50 bg-card/50 backdrop-blur-xl shadow-2xl shadow-slate-200/20 dark:shadow-none overflow-hidden transition-all hover:scale-[1.005]">
                <div class="p-8 border-b border-border/10">
                    <h3 class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                                </path>
                            </svg>
                        </div>
                        My API Keys
                    </h3>
                </div>

                <div class="p-0">
                    @if($apiKeys->isEmpty())
                        <div class="text-center py-24">
                            <svg class="w-16 h-16 text-slate-200 dark:text-slate-800 mx-auto mb-6" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">No API keys found.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left min-w-[800px]">
                                <thead>
                                    <tr class="border-b border-border/10">
                                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            Name</th>
                                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            Key Preview</th>
                                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400">
                                            Activity</th>
                                        <th
                                            class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border/10">
                                    @foreach($apiKeys as $key)
                                        <tr
                                            class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-all border-b border-border/10 md:border-none">
                                            <td class="px-8 py-6">
                                                <div class="flex items-center gap-4">
                                                    <div
                                                        class="w-10 h-10 rounded-2xl bg-primary/10 text-primary flex items-center justify-center transition-transform group-hover:rotate-6">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <span
                                                            class="font-black text-foreground tracking-tight block">{{ $key->name }}</span>
                                                        @if($key->expires_at && $key->expires_at->isPast())
                                                            <span
                                                                class="text-[8px] font-black uppercase tracking-widest text-rose-500">Expired</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-6">
                                                <code
                                                    class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-900 border border-border/10 text-[10px] font-black text-slate-500 font-mono tracking-tighter">
                                                                        {{ $key->key_preview }}
                                                                    </code>
                                            </td>
                                            <td class="px-8 py-6">
                                                <div
                                                    class="text-[9px] font-black uppercase tracking-widest text-slate-400 space-y-1">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-1.5 h-1.5 rounded-full bg-slate-400"></div>
                                                        Created: {{ $key->created_at->format('M d, Y') }}
                                                    </div>
                                                    @if($key->last_used_at)
                                                        <div class="flex items-center gap-2 text-indigo-500">
                                                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div>
                                                            Used: {{ $key->last_used_at->format('M d, Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-8 py-6 text-right">
                                                <div class="flex items-center justify-end gap-3">
                                                    <form action="{{ route('api-keys.regenerate', $key->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            onclick="return confirm('Note: Regenerating this key will invalidate the old one. Continue?')"
                                                            class="w-10 h-10 rounded-xl border border-border/10 flex items-center justify-center text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-primary transition-all active:scale-95">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('api-keys.destroy', $key->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Are you sure you want to delete this key?')"
                                                            class="w-10 h-10 rounded-xl border border-border/10 flex items-center justify-center text-slate-400 hover:bg-rose-50 dark:hover:bg-rose-950/20 hover:text-rose-500 transition-all active:scale-95">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2.5"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Detailed Developer Documentation -->
            <div class="space-y-8 animate-in fade-in slide-in-from-bottom-4 duration-700 delay-200">
                <div class="flex items-center gap-4">
                    <h2
                        class="text-2xl font-black tracking-tight text-foreground bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-indigo-500">
                        Developer Documentation</h2>
                    <div class="h-px flex-1 bg-gradient-to-r from-border/50 to-transparent"></div>
                </div>

                <div class="grid lg:grid-cols-2 gap-8">
                    <!-- Authentication & Base URL -->
                    <div class="space-y-8">
                        <div
                            class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl p-8 shadow-2xl shadow-slate-200/20 dark:shadow-none h-full">
                            <h3
                                class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-3">
                                <span
                                    class="w-8 h-8 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </span>
                                Authentication
                            </h3>
                            <div class="space-y-6">
                                <p class="text-sm font-medium text-muted-foreground leading-relaxed">
                                    Authenticate your requests by including your API key in the <code
                                        class="text-primary font-black">Authorization</code> header.
                                </p>
                                <div
                                    class="bg-slate-950 rounded-2xl p-5 border border-slate-800/50 shadow-inner group relative">
                                    <div
                                        class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button
                                            onclick="navigator.clipboard.writeText('Authorization: Bearer YOUR_API_KEY')"
                                            class="text-xs font-bold text-slate-500 hover:text-white bg-slate-800/50 px-2 py-1 rounded-lg transition-colors">Copy</button>
                                    </div>
                                    <code
                                        class="text-xs font-mono text-blue-400">Authorization: <span class="text-white">Bearer</span> <span class="text-emerald-400">YOUR_API_KEY</span></code>
                                </div>
                            </div>

                            <div class="mt-8 pt-8 border-t border-border/10">
                                <h3
                                    class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-3">
                                    <span
                                        class="w-8 h-8 rounded-xl bg-indigo-500/10 flex items-center justify-center text-indigo-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                            </path>
                                        </svg>
                                    </span>
                                    Base URL
                                </h3>
                                <div
                                    class="bg-slate-950 rounded-2xl p-5 border border-slate-800/50 shadow-inner group relative">
                                    <div
                                        class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="navigator.clipboard.writeText('{{ config('app.url') }}/api')"
                                            class="text-xs font-bold text-slate-500 hover:text-white bg-slate-800/50 px-2 py-1 rounded-lg transition-colors">Copy</button>
                                    </div>
                                    <code class="text-xs font-mono text-indigo-400">{{ config('app.url') }}/api</code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Endpoints -->
                    <div class="space-y-6">
                        <!-- Place Order -->
                        <div
                            class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl p-8 shadow-2xl shadow-slate-200/20 dark:shadow-none">
                            <h3
                                class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-3">
                                <span
                                    class="w-8 h-8 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </span>
                                Place Order
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-2 text-xs font-mono">
                                    <span
                                        class="bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 px-2 py-1 rounded-lg font-black border border-emerald-500/20">POST</span>
                                    <span class="text-muted-foreground">/orders</span>
                                </div>

                                <!-- Parameters Table -->
                                <div class="overflow-hidden rounded-xl border border-border/10">
                                    <table class="w-full text-left text-xs">
                                        <thead class="bg-slate-50 dark:bg-slate-900/50">
                                            <tr>
                                                <th class="px-4 py-3 font-black text-slate-500 uppercase tracking-wider">
                                                    Parameter</th>
                                                <th class="px-4 py-3 font-black text-slate-500 uppercase tracking-wider">
                                                    Type</th>
                                                <th class="px-4 py-3 font-black text-slate-500 uppercase tracking-wider">
                                                    Required</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-border/10 bg-white/50 dark:bg-slate-900/20">
                                            <tr>
                                                <td class="px-4 py-3 font-mono text-primary">bundle_id</td>
                                                <td class="px-4 py-3 text-muted-foreground">Integer</td>
                                                <td class="px-4 py-3 text-rose-500 font-bold">Yes</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3 font-mono text-primary">recipient_phone</td>
                                                <td class="px-4 py-3 text-muted-foreground">String</td>
                                                <td class="px-4 py-3 text-rose-500 font-bold">Yes</td>
                                            </tr>
                                            <tr>
                                                <td class="px-4 py-3 font-mono text-primary">payment_method</td>
                                                <td class="px-4 py-3 text-muted-foreground">String</td>
                                                <td class="px-4 py-3 text-rose-500 font-bold">Yes ('wallet')</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Code Example -->
                                <div
                                    class="bg-slate-950 rounded-2xl p-5 border border-slate-800/50 shadow-inner mt-4 group relative overflow-hidden">
                                    <div
                                        class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                        <button onclick="copyCode(this)"
                                            class="text-xs font-bold text-slate-500 hover:text-white bg-slate-800/50 px-2 py-1 rounded-lg transition-colors">Copy</button>
                                    </div>
                                    <pre class="text-[10px] font-mono leading-relaxed overflow-x-auto text-slate-300">
            <span class="text-purple-400">curl</span> -X POST {{ config('app.url') }}/api/orders \
            -H <span class="text-green-400">"Authorization: Bearer YOUR_API_KEY"</span> \
            -H <span class="text-green-400">"Content-Type: application/json"</span> \
            -d <span class="text-yellow-300">'{
                "bundle_id": 5,
                "recipient_phone": "0244123456",
                "payment_method": "wallet"
            }'</span></pre>
                                </div>
                            </div>
                        </div>

                        <!-- Check Balance -->
                        <div
                            class="rounded-[2.5rem] border border-border/50 bg-card/50 backdrop-blur-xl p-8 shadow-2xl shadow-slate-200/20 dark:shadow-none">
                            <h3
                                class="text-sm font-black uppercase tracking-[0.2em] text-slate-400 mb-6 flex items-center gap-3">
                                <span
                                    class="w-8 h-8 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                </span>
                                Get User Details
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-2 text-xs font-mono">
                                    <span
                                        class="bg-blue-500/10 text-blue-600 dark:text-blue-400 px-2 py-1 rounded-lg font-black border border-blue-500/20">GET</span>
                                    <span class="text-muted-foreground">/user/me</span>
                                </div>
                                <p class="text-xs text-muted-foreground">Retrieve your current wallet balance and account
                                    details.</p>
                                <div
                                    class="bg-slate-950 rounded-2xl p-5 border border-slate-800/50 shadow-inner group relative">
                                    <div
                                        class="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="copyCode(this)"
                                            class="text-xs font-bold text-slate-500 hover:text-white bg-slate-800/50 px-2 py-1 rounded-lg transition-colors">Copy</button>
                                    </div>
                                    <pre class="text-[10px] font-mono leading-relaxed overflow-x-auto text-slate-300">
            <span class="text-purple-400">curl</span> {{ config('app.url') }}/api/user/me \
            -H <span class="text-green-400">"Authorization: Bearer YOUR_API_KEY"</span></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function copyToClipboard(elementId) {
                const input = document.getElementById(elementId);
                input.select();
                input.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(input.value).then(() => {
                    const btn = event.currentTarget;
                    const originalHtml = btn.innerHTML;
                    btn.innerHTML = '<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>';
                    setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
                });
            }
        </script>
    @endsection