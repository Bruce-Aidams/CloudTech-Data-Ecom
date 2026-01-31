@extends('layouts.dashboard')

@section('title', 'Settings')

@section('content')
    <div class="max-w-5xl mx-auto space-y-12 animate-in fade-in slide-in-from-bottom-4 duration-700 pb-20">
        {{-- Header --}}
        <div class="flex items-center gap-4">
            <div
                class="w-12 h-12 rounded-xl bg-rose-500/10 flex items-center justify-center text-rose-500 ring-1 ring-rose-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Account Settings
                </h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Update your password and manage
                    your notification preferences.</p>
            </div>
        </div>

        <div class="grid gap-12">
            <!-- Access Credentials -->
            <div
                class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-10 shadow-sm relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-bl-full pointer-events-none group-hover:bg-primary/10 transition-colors">
                </div>

                <h3 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 dark:text-slate-600 mb-10">
                    Change Password</h3>

                <form action="{{ route('settings.update') }}" method="POST" class="space-y-10">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-8 sm:grid-cols-2">
                        <div class="space-y-3">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pl-1">Current
                                Password</label>
                            <input type="password" name="current_password" required
                                class="w-full h-14 px-6 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                        </div>
                        <div class="space-y-10 sm:space-y-3">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pl-1">New
                                    Password</label>
                                <input type="password" name="new_password" required minlength="8"
                                    class="w-full h-14 px-6 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                            </div>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 pl-1">Confirm
                            Password</label>
                        <input type="password" name="new_password_confirmation" required minlength="8"
                            class="w-full h-14 px-6 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white max-w-md">
                    </div>

                    <button type="submit"
                        class="h-14 px-10 rounded-2xl bg-primary text-white text-[10px] font-black uppercase tracking-[.25em] shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all">
                        Update Password
                    </button>
                </form>
            </div>

            <div class="grid gap-12 md:grid-cols-2">
                <!-- Data Transmission Alerts -->
                <div
                    class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-10 shadow-sm">
                    <h3 class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 dark:text-slate-600 mb-10">
                        Notifications</h3>

                    <form action="{{ route('settings.update') }}" method="POST" id="notifications-form" class="space-y-10">
                        @csrf
                        @method('PUT')
                        @php $user = auth()->user(); @endphp
                        <div class="space-y-8">
                            <div class="flex items-center justify-between group">
                                <div class="space-y-1">
                                    <label
                                        class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-tight">Email
                                        Notifications</label>
                                    <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Orders &
                                        Transactions</p>
                                </div>
                                <input type="checkbox" name="notification_email" id="notification_email" value="1"
                                    class="hidden" {{ $user->notification_email ? 'checked' : '' }}>
                                <button type="button" role="switch"
                                    aria-checked="{{ $user->notification_email ? 'true' : 'false' }}"
                                    @click="document.getElementById('notification_email').checked = !document.getElementById('notification_email').checked; document.getElementById('notifications-form').submit()"
                                    class="{{ $user->notification_email ? 'bg-primary' : 'bg-slate-100 dark:bg-slate-800' }} inline-flex h-7 w-14 items-center rounded-full border-2 border-transparent transition-all">
                                    <span
                                        class="{{ $user->notification_email ? 'translate-x-7' : 'translate-x-0' }} block h-5 w-5 rounded-full bg-white shadow-xl transition-transform"></span>
                                </button>
                            </div>

                            <div class="flex items-center justify-between group">
                                <div class="space-y-1">
                                    <label
                                        class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-tight">SMS
                                        Notifications</label>
                                    <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Important
                                        account alerts</p>
                                </div>
                                <input type="checkbox" name="notification_sms" id="notification_sms" value="1"
                                    class="hidden" {{ $user->notification_sms ? 'checked' : '' }}>
                                <button type="button" role="switch"
                                    aria-checked="{{ $user->notification_sms ? 'true' : 'false' }}"
                                    @click="document.getElementById('notification_sms').checked = !document.getElementById('notification_sms').checked; document.getElementById('notifications-form').submit()"
                                    class="{{ $user->notification_sms ? 'bg-primary' : 'bg-slate-100 dark:bg-slate-800' }} inline-flex h-7 w-14 items-center rounded-full border-2 border-transparent transition-all">
                                    <span
                                        class="{{ $user->notification_sms ? 'translate-x-7' : 'translate-x-0' }} block h-5 w-5 rounded-full bg-white shadow-xl transition-transform"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Account Actions -->
                <div class="grid gap-8">
                    <!-- Environment Styles -->
                    <div
                        class="bg-white dark:bg-slate-900 rounded-[2.5rem] border border-slate-100 dark:border-slate-800 p-10 shadow-sm relative overflow-hidden group">
                        <div
                            class="absolute bottom-0 right-0 w-24 h-24 bg-gradient-to-tl from-primary/5 to-transparent rounded-tl-3xl pointer-events-none">
                        </div>
                        <h3
                            class="text-[10px] font-black uppercase tracking-[.3em] text-slate-400 dark:text-slate-600 mb-10">
                            UI Environment</h3>

                        <div class="space-y-8">
                            <div class="flex items-center justify-between group">
                                <div class="space-y-1">
                                    <label
                                        class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-tight">Dark
                                        Mode Interface</label>
                                    <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400">Toggle dark
                                        theme
                                    </p>
                                </div>

                                <div x-data="{
                                                theme: localStorage.getItem('theme') || 'system',
                                                toggle() {
                                                    this.setTheme(this.theme === 'dark' ? 'light' : 'dark');
                                                },
                                                setTheme(val) {
                                                    this.theme = val;
                                                    localStorage.setItem('theme', val);
                                                    document.documentElement.classList.toggle('dark', val === 'dark' || (val === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches));
                                                    window.dispatchEvent(new CustomEvent('theme-changed', { detail: val }));
                                                }
                                            }" @theme-changed.window="theme = $event.detail">
                                    <button type="button" @click="toggle()"
                                        class="inline-flex h-7 w-14 items-center rounded-full border-2 border-transparent transition-all"
                                        :class="theme === 'dark' ? 'bg-primary' : 'bg-slate-100 dark:bg-slate-800'">
                                        <span class="block h-5 w-5 rounded-full bg-white shadow-xl transition-transform"
                                            :class="theme === 'dark' ? 'translate-x-7' : 'translate-x-0'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terminal Decommissioning -->
                    <div
                        class="bg-rose-50/20 dark:bg-rose-950/10 border border-rose-100 dark:border-rose-900/30 rounded-[2.5rem] p-10 transition-all hover:border-rose-500/20">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-8 py-2">
                            <div class="space-y-2 text-center sm:text-left">
                                <h4 class="text-xs font-black text-rose-600 uppercase tracking-[.2em]">Delete Account</h4>
                                <p
                                    class="text-[10px] font-bold text-rose-500/70 uppercase tracking-widest leading-relaxed max-w-sm">
                                    Warning: This will permanently delete your account.</p>
                            </div>
                            <form
                                onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be reversed.');"
                                action="{{ route('settings.destroy') }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="h-12 px-8 rounded-xl bg-rose-600 text-[10px] font-black uppercase tracking-widest text-white shadow-lg shadow-rose-500/10 hover:bg-rose-700 active:scale-95 transition-all">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection