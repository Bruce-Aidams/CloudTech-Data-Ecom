<header
    class="fixed top-0 w-full z-50 transition-all duration-500 backdrop-blur-md bg-white/70 dark:bg-slate-950/80 border-b border-white/10 dark:border-slate-800/50"
    x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 10)">
    <div class="container mx-auto px-4 sm:px-8 h-20 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-4 group">
            <div
                class="p-2.5 bg-white dark:bg-slate-900 rounded-2xl shadow-lg shadow-primary/20 group-hover:rotate-12 transition-all duration-500 border border-slate-50 dark:border-slate-800 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent"></div>
                <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-8 h-8 relative z-10">
            </div>
            <span
                class="hidden md:block font-black text-xl tracking-tighter bg-clip-text text-transparent bg-gradient-to-r from-slate-900 via-primary to-slate-900 dark:from-white dark:via-primary dark:to-white uppercase">
                CloudTech
            </span>
        </a>

        <nav
            class="hidden lg:flex items-center gap-10 text-[11px] font-bold text-slate-800 dark:text-slate-200 capitalize tracking-[0.2em]">
            <a href="{{ url('/') }}#features"
                class="hover:text-primary transition-all hover:-translate-y-0.5">Features</a>
            <a href="{{ url('/') }}#networks"
                class="hover:text-primary transition-all hover:-translate-y-0.5">Networks</a>
            <a href="{{ url('/') }}#pricing"
                class="hover:text-primary transition-all hover:-translate-y-0.5">Pricing</a>
        </nav>

        <div class="flex items-center gap-4" x-data="{ mobileMenuOpen: false }">
            <x-theme-toggle />

            {{-- Mobile Menu Toggle --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen"
                class="lg:hidden p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Mobile Menu Panel -->
            <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                class="absolute top-20 left-0 w-full bg-white dark:bg-slate-950 border-b border-slate-100 dark:border-slate-800 p-6 flex flex-col gap-4 lg:hidden shadow-xl z-50">
                <a href="{{ url('/') }}#features" @click="mobileMenuOpen = false"
                    class="text-sm font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest">Features</a>
                <a href="{{ url('/') }}#networks" @click="mobileMenuOpen = false"
                    class="text-sm font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest">Networks</a>
                <a href="{{ url('/') }}#pricing" @click="mobileMenuOpen = false"
                    class="text-sm font-bold text-slate-600 dark:text-slate-300 uppercase tracking-widest">Pricing</a>
                <div class="h-px bg-slate-100 dark:bg-slate-800 my-2"></div>
                @guest
                    <a href="{{ url('/login') }}"
                        class="h-12 bg-primary text-white rounded-xl flex items-center justify-center font-bold uppercase tracking-widest text-xs">Login</a>
                    <a href="{{ url('/register') }}"
                        class="h-12 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 rounded-xl flex items-center justify-center font-bold uppercase tracking-widest text-xs">Register</a>
                @endguest
            </div>

            @auth
                {{-- ... existing auth dropdown ... --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false"
                        class="flex items-center gap-3 p-1 pr-4 bg-slate-50/50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-2xl transition-all group outline-none">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=696cff&color=fff"
                            class="w-9 h-9 rounded-xl shadow-sm border-2 border-transparent group-hover:border-primary/20 transition-all"
                            alt="Avatar">
                        <div class="text-left hidden md:block">
                            <p class="text-xs font-black text-slate-800 dark:text-white leading-tight">
                                {{ explode(' ', auth()->user()->name)[0] }}
                            </p>
                            <p class="text-[8px] font-bold text-slate-400 capitalize tracking-widest">Active Member</p>
                        </div>
                        <svg class="w-3 h-3 text-slate-400 group-hover:text-primary transition-all"
                            :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                        class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 rounded-[2rem] p-3 shadow-2xl dark:shadow-black/50 border border-slate-50 dark:border-slate-800 z-[60]">
                        <div class="p-4 items-center gap-3 mb-2 flex">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=696cff&color=fff"
                                class="w-10 h-10 rounded-xl" alt="Avatar">
                            <div class="overflow-hidden">
                                <p class="font-black text-[11px] text-slate-900 dark:text-white truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-[9px] font-bold text-slate-400 truncate tracking-tight capitalize">
                                    {{ auth()->user()->email }}
                                </p>
                            </div>
                        </div>
                        <div class="h-[1px] bg-slate-100 dark:bg-slate-800 my-2 mx-2"></div>
                        <a href="{{ url('/dashboard') }}"
                            class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors group/item">
                            <div
                                class="w-8 h-8 rounded-lg bg-primary/5 text-primary flex items-center justify-center group-hover/item:bg-primary group-hover/item:text-white transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <span
                                class="text-[11px] font-black capitalize tracking-wider text-blue-600 group-hover/item:text-blue-900">Dashboard</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-3 p-3 rounded-xl hover:bg-rose-50 transition-colors group/item">
                                <div
                                    class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center group-hover/item:bg-rose-500 group-hover/item:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                </div>
                                <span class="text-[11px] font-black capitalize tracking-wider text-rose-500">Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ url('/login') }}"
                    class="h-10 px-6 rounded-2xl text-[11px] font-black capitalize tracking-[0.2em] text-white bg-primary shadow-xl shadow-blue-900/10 hover:bg-blue-600 hover:shadow-primary/30 transition-all hover:scale-105 active:scale-95 flex items-center justify-center">
                    Login
                </a>
            @endauth
        </div>
    </div>
</header>