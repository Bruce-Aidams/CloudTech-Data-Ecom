@extends('layouts.dashboard')

@section('title', 'API Access')

@section('content')
    <div class="max-w-7xl mx-auto space-y-10 animate-in fade-in slide-in-from-bottom-4 duration-700"
        x-data="{ formOpen: false }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-cyan-500/10 flex items-center justify-center text-cyan-500 ring-1 ring-cyan-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">API Keys</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Manage your API keys to
                        integrate CloudTech with your own applications.</p>
                </div>
            </div>
            <button @click="formOpen = !formOpen"
                class="group relative inline-flex items-center justify-center rounded-[1.5rem] bg-card/50 backdrop-blur-xl border border-border/10 text-[10px] font-black uppercase tracking-widest text-foreground h-14 px-10 shadow-2xl shadow-slate-200/20 dark:shadow-none hover:scale-[1.02] active:scale-95 transition-all">
                <svg :class="formOpen ? 'rotate-45' : ''"
                    class="w-4 h-4 mr-3 text-primary transition-transform duration-300 group-hover:rotate-12" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
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
                        <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-900/20 flex items-center justify-center">
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
                        <svg class="w-16 h-16 text-slate-200 dark:text-slate-800 mx-auto mb-6" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
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
                                            <div class="text-[9px] font-black uppercase tracking-widest text-slate-400 space-y-1">
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
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
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
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
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


        <!-- CloudTech API Documentation View -->
        <div
            class="space-y-8 pt-10 border-t border-slate-100 dark:border-slate-800 animate-in fade-in slide-in-from-bottom-4 duration-1000">
            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] p-8 md:p-12 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden">

                <!-- Documentation Header -->
                <div class="flex items-center gap-6 mb-12">
                    <div
                        class="w-14 h-14 bg-cyan-500/10 rounded-2xl flex items-center justify-center text-cyan-600 dark:text-cyan-400 ring-1 ring-cyan-500/20">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                            CloudTech API Documentation</h4>
                        <p class="text-[10px] text-slate-500 dark:text-slate-500 mt-1 uppercase tracking-widest font-black">
                            Technical Integration & Developer Guide</p>
                    </div>
                </div>

                <div class="space-y-16">
                    <!-- Getting Started -->
                    <div class="space-y-4">
                        <h5 class="text-xs font-black uppercase tracking-[.2em] text-cyan-600">Developer
                            Quickstart</h5>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400 leading-relaxed max-w-3xl">
                            Integrate CloudTech into your platform to automate data bundle purchases, check
                            order statuses, and synchronize network availability. Use your private API keys
                            for authenticated requests.
                        </p>
                    </div>

                    <!-- Connectivity Details -->
                    <div class="grid lg:grid-cols-2 gap-8">
                        <!-- Base URL -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black">01</span>
                                <h4 class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400">
                                    Endpoint Access</h4>
                            </div>
                            <div
                                class="bg-slate-950 rounded-2xl p-6 font-mono text-xs text-emerald-400 border border-slate-800 flex items-center justify-between group">
                                <span>{{ url('/api') }}</span>
                                <button onclick="navigator.clipboard.writeText('{{ url('/api') }}')"
                                    class="opacity-0 group-hover:opacity-100 transition-opacity text-slate-500 hover:text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Auth -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span
                                    class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[10px] font-black">02</span>
                                <h4 class="text-[10px] font-black uppercase tracking-[.2em] text-slate-400">
                                    Authentication</h4>
                            </div>
                            <div
                                class="bg-slate-950 rounded-2xl p-6 font-mono text-xs text-slate-300 border border-slate-800">
                                <div class="text-purple-400 mb-1">headers: <span class="text-white">{</span>
                                </div>
                                <div class="pl-4"><span class="text-sky-400">"Authorization"</span>: <span
                                        class="text-emerald-400">"Bearer YOUR_KEY"</span></div>
                                <div class="text-white mt-1">}</div>
                            </div>
                        </div>
                    </div>

                    <!-- API Routes -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span
                                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black">03</span>
                            <h4 class="text-sm font-black uppercase tracking-[.2em] text-slate-400">Core API
                                Routes</h4>
                        </div>

                        <div class="space-y-6">
                            <h5
                                class="text-[10px] font-black uppercase tracking-[.3em] text-indigo-500 border-b border-indigo-500/10 pb-2">
                                Agent & Reseller API Endpoints</h5>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                                    <span
                                        class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                    <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/networks</code>
                                    <span
                                        class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Public
                                        networks</span>
                                </div>
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                                    <span
                                        class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                    <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/products</code>
                                    <span
                                        class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Active
                                        Bundles</span>
                                </div>
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl bg-emerald-500/10 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30">
                                    <span
                                        class="px-2 py-0.5 bg-emerald-500/20 text-emerald-600 text-[9px] font-black uppercase rounded">POST</span>
                                    <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/orders</code>
                                    <span
                                        class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Place
                                        Order</span>
                                </div>
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl bg-emerald-500/10 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30">
                                    <span
                                        class="px-2 py-0.5 bg-emerald-500/20 text-emerald-600 text-[9px] font-black uppercase rounded">POST</span>
                                    <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/orders/bulk</code>
                                    <span class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Bulk
                                        Upload</span>
                                </div>
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                                    <span
                                        class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                    <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/orders/{id}</code>
                                    <span
                                        class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Order
                                        Status</span>
                                </div>
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                                    <span
                                        class="px-2 py-0.5 bg-sky-500/10 text-sky-500 text-[9px] font-black uppercase rounded">GET</span>
                                    <code class="text-xs font-bold text-slate-700 dark:text-slate-200">/user/me</code>
                                    <span
                                        class="text-[10px] text-slate-400 ml-auto uppercase font-bold tracking-tight">Account
                                        Check</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Webhooks -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span
                                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black">04</span>
                            <h4 class="text-sm font-black uppercase tracking-[.2em] text-slate-400">Webhook
                                Integration</h4>
                        </div>
                        <div class="grid lg:grid-cols-2 gap-8">
                            <div
                                class="p-8 rounded-3xl bg-indigo-50/30 dark:bg-indigo-950/10 border border-indigo-100/50 dark:border-indigo-900/30 space-y-4">
                                <h5 class="text-[10px] font-black uppercase text-indigo-600 tracking-widest">
                                    Outgoing Events</h5>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed">Receive
                                    real-time notifications for order fulfillments and status transitions
                                    direct to your server.</p>
                                <div
                                    class="bg-slate-950 rounded-2xl p-6 font-mono text-[10px] text-slate-300 border border-slate-800">
                                    <span class="text-purple-400">{</span><br>
                                    <span class="pl-4">"event": <span
                                            class="text-emerald-400">"order.completed"</span>,</span><br>
                                    <span class="pl-4">"data": { "status": "success" }</span><br>
                                    <span class="text-purple-400">}</span>
                                </div>
                            </div>

                            <div
                                class="p-8 rounded-3xl bg-emerald-50/30 dark:bg-emerald-950/10 border border-emerald-100/50 dark:border-emerald-900/30 space-y-4">
                                <h5 class="text-[10px] font-black uppercase text-emerald-600 tracking-widest">
                                    Incoming Support</h5>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed">External
                                    systems can sync status updates to your account via provider hooks where
                                    applicable.</p>
                                <div class="pt-2">
                                    <span
                                        class="inline-flex px-3 py-1 bg-emerald-500 text-white rounded-lg text-[9px] font-black uppercase">Standard
                                        Webhooks</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Codes -->
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span
                                class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-black">05</span>
                            <h4 class="text-sm font-black uppercase tracking-[.2em] text-slate-400">Response
                                Status Codes</h4>
                        </div>
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-center">
                                <p class="text-[9px] font-black text-indigo-500 mb-1">200</p>
                                <p
                                    class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    Success</p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-center">
                                <p class="text-[9px] font-black text-rose-500 mb-1">401</p>
                                <p
                                    class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    Unauthorized</p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-center">
                                <p class="text-[9px] font-black text-amber-500 mb-1">422</p>
                                <p
                                    class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    Validation</p>
                            </div>
                            <div
                                class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 text-center">
                                <p class="text-[9px] font-black text-slate-400 mb-1">500</p>
                                <p
                                    class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-tighter">
                                    Server Error</p>
                            </div>
                        </div>
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