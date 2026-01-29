<header
    class="h-16 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-100 dark:border-slate-800 sticky top-0 z-40 px-4 md:px-8 flex items-center justify-between transition-all duration-300">
    <div class="flex items-center gap-4 flex-1">
        <button @click="sidebarOpen = true"
            class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                </path>
            </svg>
        </button>

        <button @click="isCollapsed = !isCollapsed"
            class="hidden lg:flex p-2 rounded-xl text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary transition-all group"
            :title="isCollapsed ? 'Expand Sidebar' : 'Collapse Sidebar'">
            <svg x-show="isCollapsed" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
            </svg>
            <svg x-show="!isCollapsed" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>

        <div class="relative w-full max-w-md hidden md:block group">
            <span
                class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" placeholder="Search..."
                class="w-full h-10 pl-11 pr-4 bg-slate-50 dark:bg-slate-800 border-none focus:ring-2 focus:ring-primary/20 transition-all rounded-xl text-sm placeholder:text-slate-400 dark:text-slate-200">
        </div>
    </div>

    <div class="flex items-center gap-3">
        <!-- Live Status -->
        <div
            class="hidden xl:flex items-center gap-2 bg-emerald-50 dark:bg-emerald-900/10 px-3 py-1.5 rounded-full border border-emerald-100 dark:border-emerald-800/50">
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
            <span
                class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 dark:text-emerald-400">Live</span>
        </div>

        <x-theme-toggle />

        @php
            $unreadNotifications = auth()->user()->notifications()->where('is_read', 0)->latest()->take(5)->get();
            $unreadCount = auth()->user()->notifications()->where('is_read', 0)->count();
        @endphp

        <!-- Notifications -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false"
                class="w-10 h-10 flex items-center justify-center text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl relative transition-all group">
                <svg class="w-5 h-5 group-hover:text-primary transition-colors" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                @if($unreadCount > 0)
                    <div
                        class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white dark:border-slate-800">
                    </div>
                @endif
            </button>

            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-900 rounded-2xl p-4 shadow-xl border border-slate-100 dark:border-slate-800 z-50">
                <div class="flex items-center justify-between mb-4 px-2">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">Notifications
                    </h3>
                    @if($unreadCount > 0)
                        <span class="text-[10px] font-bold text-primary">{{ $unreadCount }} New</span>
                    @endif
                </div>

                <div class="space-y-1 max-h-80 overflow-y-auto custom-scrollbar">
                    @forelse($unreadNotifications as $notification)
                        <div
                            class="flex gap-3 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all cursor-pointer group/item">
                            <div
                                class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 
                                    {{ $notification->type === 'success' ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-500' : 'bg-blue-50 dark:bg-blue-900/20 text-blue-500' }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-slate-900 dark:text-slate-100 truncate">
                                    {{ $notification->title }}</p>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 line-clamp-1 mt-0.5">
                                    {{ $notification->message }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-10 text-center">
                            <p class="text-xs text-slate-500">No new notifications</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="h-6 w-px bg-slate-100 dark:bg-slate-800 mx-1"></div>

        <!-- Profile -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false"
                class="flex items-center gap-2 p-1 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                <div
                    class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-bold text-xs overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=696cff&color=fff"
                        class="w-full h-full object-cover">
                </div>
                <div class="text-left hidden lg:block pr-1">
                    <p class="text-xs font-bold text-slate-900 dark:text-slate-100 leading-none">
                        {{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-1">Administrator</p>
                </div>
            </button>

            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 rounded-2xl p-2 shadow-xl border border-slate-100 dark:border-slate-800 z-50">
                <a href="{{ url('/admin/settings') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    </svg>
                    Settings
                </a>
                <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 w-full text-left transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>