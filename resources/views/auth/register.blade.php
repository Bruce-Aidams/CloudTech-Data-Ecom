@php($hideNav = true)
@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-[#f5f5f9] dark:bg-slate-950 p-4 transition-colors duration-300"
        x-data="{ 
            loading: false,
            submit() {
                this.loading = true;
                this.$refs.registerForm.submit();
            }
         }">
        <div class="w-full max-w-[450px] animate-in fade-in zoom-in duration-500">
            <!-- Logo Header -->
            <div class="flex flex-col items-center gap-3 mb-8">
                <div
                    class="w-14 h-14 bg-white dark:bg-slate-900 rounded-2xl shadow-sm flex items-center justify-center border border-slate-100 dark:border-slate-800 transition-transform hover:scale-105 duration-300">
                    <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-8 h-8">
                </div>
                <h1 class="text-2xl font-black tracking-tight text-slate-800 dark:text-slate-100 uppercase">
                    {{ config('app.name') }}</h1>
            </div>

            <!-- Register Card -->
            <div
                class="bg-white dark:bg-slate-900 rounded-xl shadow-[0_2px_10px_0_rgba(67,89,113,0.1)] dark:shadow-none border-none overflow-hidden">
                <div class="p-8">
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-slate-700 dark:text-slate-200 mb-1">Adventure starts here 🚀</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">Make your data bundle
                            management easy and fun!</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-lg animate-in slide-in-from-top-2">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-[10px] font-bold text-rose-600 uppercase tracking-wider">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" x-ref="registerForm" @submit.prevent="submit"
                        class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="name"
                                    class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">Full
                                    Name</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                    class="w-full h-11 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300"
                                    placeholder="John Doe">
                            </div>
                            <div class="space-y-2">
                                <label for="email"
                                    class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full h-11 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300"
                                    placeholder="john@example.com">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="phone"
                                class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">Phone
                                Number</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required
                                class="w-full h-11 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300"
                                placeholder="054XXXXXXX">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label for="password"
                                    class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">Password</label>
                                <div class="relative" x-data="{ show: false }">
                                    <input id="password" :type="show ? 'text' : 'password'" name="password" required
                                        class="w-full h-11 pl-4 pr-11 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300"
                                        placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                                    <button type="button" @click="show = !show"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.04m4.066-1.426A10.05 10.05 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-4.223-4.223l-2.408-2.408m0 0L9.966 9.966m0 0L5 5" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label for="password_confirmation"
                                    class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">Confirm</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="w-full h-11 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300"
                                    placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="referral_code"
                                class="text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 ml-1">Referral
                                Code (Optional)</label>
                            <input id="referral_code" type="text" name="referral_code" value="{{ old('referral_code') }}"
                                class="w-full h-11 px-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg outline-none focus:border-primary focus:ring-[3px] focus:ring-primary/10 transition-all text-sm text-slate-700 dark:text-slate-200 placeholder:text-slate-300"
                                placeholder="Enter referral code">
                        </div>

                        <div class="flex items-center ml-1 py-2">
                            <input type="checkbox" name="terms" id="terms" required
                                class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary/20">
                            <label for="terms" class="ml-2 text-sm text-slate-500 dark:text-slate-400 cursor-pointer">
                                I agree to <a href="#" class="text-primary font-bold hover:underline">privacy policy &
                                    terms</a>
                            </label>
                        </div>

                        <button type="submit" :disabled="loading"
                            class="w-full h-11 bg-primary text-white rounded-lg font-bold text-sm shadow-[0_4px_12px_rgba(105,108,255,0.4)] hover:bg-primary/90 hover:shadow-[0_4px_12px_rgba(105,108,255,0.5)] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                            <template x-if="!loading">
                                <span>Sign up</span>
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

                        <div class="pt-2 text-center">
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                Already have an account?
                                <a href="{{ route('login') }}" class="text-primary font-bold hover:underline ml-1">Sign in
                                    instead</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection