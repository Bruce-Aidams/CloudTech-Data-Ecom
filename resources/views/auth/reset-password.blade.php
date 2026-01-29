@php($hideNav = true)
@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#f5f5f9] dark:bg-slate-950 p-4 transition-colors duration-300"
        x-data="{ 
                loading: false,
                submit() {
                    this.loading = true;
                    this.$refs.resetForm.submit();
                }
             }">
        <div class="w-full max-w-[400px] animate-in fade-in zoom-in duration-500">
            <!-- Logo Header -->
            <div class="flex flex-col items-center gap-3 mb-8">
                <div
                    class="w-14 h-14 bg-white dark:bg-slate-900 rounded-2xl shadow-sm flex items-center justify-center border border-slate-100 dark:border-slate-800 transition-transform hover:scale-105 duration-300">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-8 h-8">
                </div>
                <h1 class="text-2xl font-black tracking-tight text-slate-800 dark:text-slate-100 uppercase">
                    {{ config('app.name') }}
                </h1>
            </div>

            <!-- Reset Password Card -->
            <div
                class="bg-white dark:bg-slate-900 rounded-xl shadow-[0_2px_10px_0_rgba(67,89,113,0.1)] dark:shadow-none border-none overflow-hidden">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-700 dark:text-slate-200 mb-1">Reset Password 🔄</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Enter your new password below
                        </p>
                    </div>

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-lg animate-in slide-in-from-top-2">
                            <p class="text-xs font-bold text-rose-600 uppercase tracking-wider">{{ $errors->first() }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}" x-ref="resetForm" @submit.prevent="submit"
                        class="space-y-5">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="space-y-2">
                            <label for="email"
                                class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">Email</label>
                            <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required
                                autofocus
                                class="w-full h-11 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300"
                                placeholder="Enter your email">
                        </div>

                        <div class="space-y-2">
                            <label for="password"
                                class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">New
                                Password</label>
                            <input id="password" type="password" name="password" required
                                class="w-full h-11 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300">
                        </div>

                        <div class="space-y-2">
                            <label for="password_confirmation"
                                class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">Confirm
                                New Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="w-full h-11 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300">
                        </div>

                        <button type="submit" :disabled="loading"
                            class="w-full h-11 bg-primary text-white rounded-lg font-bold text-sm shadow-[0_4px_12px_rgba(105,108,255,0.4)] hover:bg-primary/90 hover:shadow-[0_4px_12px_rgba(105,108,255,0.5)] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                            <template x-if="!loading">
                                <span>Reset Password</span>
                            </template>
                            <template x-if="loading">
                                <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </template>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection