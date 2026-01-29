<footer
    class="bg-white dark:bg-slate-950 border-t border-slate-100 dark:border-slate-800 py-20 relative overflow-hidden">
    <!-- Abstract Footer Blurs -->
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-[100px] -z-10 animate-pulse"></div>
    <div class="absolute top-0 left-0 w-64 h-64 bg-indigo-500/5 rounded-full blur-[80px] -z-10"></div>

    <div class="container mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-12 mb-16">
            <div class="col-span-2 lg:col-span-2 space-y-4">
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <div
                        class="p-2 bg-white dark:bg-slate-900 rounded-xl shadow-sm group-hover:rotate-12 transition-all duration-500 border border-slate-50 dark:border-slate-800 relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent"></div>
                        <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-6 h-6 relative z-10">
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900 dark:text-white">CloudTech</span>
                </a>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed max-w-xs font-medium">
                    Simplifying digital access for everyone in Ghana. Trusted platform for affordable data
                    bundles and instant delivery.
                </p>
            </div>

            <div class="space-y-4">
                <h4 class="font-bold text-[10px] uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Services</h4>
                <nav class="flex flex-col gap-3 text-sm font-semibold text-slate-600 dark:text-slate-400">
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 group-hover/link:bg-primary transition-colors"></span>
                        MTN Offers
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover/link:bg-primary transition-colors"></span>
                        Telecel Bundles
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover/link:bg-primary transition-colors"></span>
                        AT Packages
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover/link:bg-primary transition-colors"></span>
                        Bulk SMS
                    </a>
                </nav>
            </div>

            <div class="space-y-4">
                <h4 class="font-bold text-[10px] uppercase tracking-wider text-slate-400 dark:text-slate-500">Company
                </h4>
                <nav class="flex flex-col gap-3 text-sm font-semibold text-slate-600 dark:text-slate-400">
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 group-hover/link:bg-primary transition-colors"></span>
                        About CloudTech
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 group-hover/link:bg-primary transition-colors"></span>
                        Contact Sales
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 group-hover/link:bg-primary transition-colors"></span>
                        Join as Agent
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 group-hover/link:bg-primary transition-colors"></span>
                        Developer API
                    </a>
                </nav>
            </div>

            <div class="space-y-4">
                <h4 class="font-bold text-[10px] uppercase tracking-wider text-slate-400 dark:text-slate-500">Support
                </h4>
                <nav class="flex flex-col gap-3 text-sm font-semibold text-slate-600 dark:text-slate-400">
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover/link:bg-primary transition-colors"></span>
                        Help Center
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover/link:bg-primary transition-colors"></span>
                        Terms of Service
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 group-hover/link:bg-primary transition-colors"></span>
                        Privacy Policy
                    </a>
                    <a href="#" class="hover:text-primary transition-colors flex items-center gap-2 group/link">
                        <span
                            class="w-1.5 h-1.5 rounded-full bg-slate-200 dark:bg-slate-700 group-hover/link:bg-primary transition-colors"></span>
                        System Status
                    </a>
                </nav>
            </div>
        </div>

        <div
            class="pt-10 border-t border-slate-100 dark:border-slate-800 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex flex-col items-center md:items-start gap-2">
                <p class="text-xs font-semibold text-slate-400 dark:text-slate-500">
                    © {{ date('Y') }} CloudTech Global. Built with precision in Ghana.
                </p>
                <div
                    class="flex gap-4 text-[10px] font-bold uppercase tracking-widest text-slate-300 dark:text-slate-600">
                    <span>Powering Digital Freedom</span>
                    <span class="text-primary">•</span>
                    <span>Ultra-Cheap Deals</span>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <a href="https://wa.me/233000000000" target="_blank"
                    class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-emerald-500 hover:bg-emerald-500/5 hover:scale-110 transition-all duration-300 shadow-sm">
                    <span class="sr-only">WhatsApp</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z">
                        </path>
                    </svg>
                </a>
                <a href="https://t.me/cloudtech" target="_blank"
                    class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center text-slate-400 dark:text-slate-500 hover:text-indigo-500 hover:bg-indigo-500/5 hover:scale-110 transition-all duration-300 shadow-sm">
                    <span class="sr-only">Telegram</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 10l-4 4 6 6 4-16-18 7 4 2 2 6 3-4"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>