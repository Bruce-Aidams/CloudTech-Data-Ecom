@extends('layouts.admin')

@section('title', 'Product Management')

@section('content')
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{
                                                    modalOpen: false,
                                                    editMode: false,
                                                    searchTerm: '',
                                                    previewUrl: null,
                                                    productsUrl: '{{ route('admin.bundles.store') }}',
                                                    baseUrl: '{{ url('admin/bundles') }}',
                                                    bundle: { id: '', network: '', name: '', price: '', cost_price: '', data_amount: '', is_active: 1, role_prices: { dealer: '', super_agent: '' } },
                                                    resetForm() {
                                                        this.bundle = { id: '', network: '', name: '', price: '', cost_price: '', data_amount: '', is_active: 1, role_prices: { dealer: '', super_agent: '' } };
                                                        this.editMode = false;
                                                        this.previewUrl = null;
                                                    },
                                                    openAdd() {
                                                        this.resetForm();
                                                        this.modalOpen = true;
                                                    },
                                                    openEdit(b) {
                                                        this.bundle = JSON.parse(JSON.stringify(b));
                                                        if(!this.bundle.role_prices) this.bundle.role_prices = { dealer: '', super_agent: '' };
                                                        this.previewUrl = b.image_url;
                                                        this.editMode = true;
                                                        this.modalOpen = true;
                                                    },
                                                    updatePreview(event) {
                                                        const file = event.target.files[0];
                                                        if (file) {
                                                            this.previewUrl = URL.createObjectURL(file);
                                                        }
                                                    },
                                                    filteredBundles() {
                                                        const bundles = {{ Js::from($bundles->items()) }};
                                                        if (!this.searchTerm) return bundles;
                                                        const search = this.searchTerm.toLowerCase();
                                                        return bundles.filter(b => {
                                                            const name = String(b.name || '').toLowerCase();
                                                            const network = String(b.network || '').toLowerCase();
                                                            const dataAmount = String(b.data_amount || '').toLowerCase();
                                                            return name.includes(search) || network.includes(search) || dataAmount.includes(search);
                                                        });
                                                    }
                                                }">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-500 ring-1 ring-purple-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-blue-900 dark:text-white">Product Management</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure data bundles, pricing, and
                        availability.</p>
                </div>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                {{-- Search --}}
                <div class="relative flex-1 md:w-64 group">
                    <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400 group-focus-within:text-primary transition-colors"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" x-model="searchTerm" placeholder="Search products..."
                        class="w-full h-11 pl-10 pr-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-medium outline-none focus:ring-4 focus:ring-primary/10 transition-all">
                </div>

                <div class="relative min-w-[120px]">
                    <form action="{{ route('admin.bundles') }}" method="GET" id="perPageForm">
                        @if(request('network'))
                            <input type="hidden" name="network" value="{{ request('network') }}">
                        @endif
                        <select name="per_page" onchange="this.form.submit()"
                            class="h-11 w-full px-4 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold uppercase tracking-widest outline-none focus:ring-4 focus:ring-primary/10 transition-all dark:text-slate-400 appearance-none cursor-pointer">
                            @foreach([10, 20, 50, 100, 200] as $val)
                                <option value="{{ $val }}" {{ request('per_page', 10) == $val ? 'selected' : '' }}>{{ $val }} Per
                                    Page</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <button @click="openAdd()"
                    class="h-11 px-6 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all flex items-center gap-2 whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Bundle
                </button>
            </div>
        </div>

        {{-- Network Filter --}}
        <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit">
            <a href="{{ route('admin.bundles') }}"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ !request('network') ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                All
            </a>
            @foreach($networks as $net)
                <a href="{{ route('admin.bundles', ['network' => $net]) }}"
                    class="px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('network') === $net ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300' }}">
                    {{ $net }}
                </a>
            @endforeach
        </div>

        {{-- Product Grid --}}
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <template x-for="b in filteredBundles()" :key="b.id">
                <div
                    class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                    {{-- Image --}}
                    <div
                        class="aspect-[4/3] bg-slate-50 dark:bg-slate-800/50 relative flex items-center justify-center overflow-hidden">
                        <template x-if="b.image_url">
                            <img :src="b.image_url"
                                class="w-full h-full object-cover transition-transform group-hover:scale-110 duration-700">
                        </template>
                        <template x-if="!b.image_url">
                            <div
                                class="flex flex-col items-center gap-2 opacity-20 group-hover:opacity-40 transition-opacity text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-[10px] font-black uppercase tracking-tighter">No Preview</span>
                            </div>
                        </template>

                        {{-- Badges --}}
                        <div class="absolute top-4 left-4 right-4 flex justify-between items-start pointer-events-none">
                            <span
                                class="px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-wider shadow-sm backdrop-blur-md"
                                :class="{
                                                'bg-yellow-400/90 text-yellow-950': b.network === 'MTN',
                                                'bg-red-500/90 text-white': b.network === 'TELECEL',
                                                'bg-blue-600/90 text-white': b.network !== 'MTN' && b.network !== 'TELECEL'
                                            }" x-text="b.network"></span>

                            <template x-if="!b.is_active">
                                <span
                                    class="px-2.5 py-1 bg-slate-900/80 text-white rounded-lg text-[9px] font-black uppercase tracking-wider backdrop-blur-md">Inactive</span>
                            </template>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6">
                        <div class="flex justify-between items-start gap-2">
                            <h3 class="font-bold text-slate-900 dark:text-white leading-tight" x-text="b.name"></h3>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-4">
                            <div class="space-y-0.5">
                                <p
                                    class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Retail</p>
                                <p class="text-sm font-black text-primary" x-text="'GHS ' + Number(b.price).toFixed(2)"></p>
                            </div>
                            <div class="space-y-0.5 text-right">
                                <p
                                    class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Amount</p>
                                <p class="text-sm font-black text-slate-900 dark:text-slate-100" x-text="b.data_amount"></p>
                            </div>
                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-50 dark:border-slate-800/50 flex items-center gap-2">
                            <button @click="openEdit(b)"
                                class="flex-1 h-10 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-xl hover:bg-primary hover:text-white dark:hover:bg-primary dark:hover:text-white transition-all active:scale-95">Manage</button>

                            <form :action="baseUrl + '/' + b.id" method="POST" class="shrink-0"
                                onsubmit="return confirm('Archive this product?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-10 h-10 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 font-bold rounded-xl hover:bg-rose-600 hover:text-white transition-all active:scale-95 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $bundles->withQueryString()->links() }}
        </div>

        {{-- Modal --}}
        <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="modalOpen = false"></div>
            <div
                class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200">
                <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white"
                            x-text="editMode ? 'Edit Bundle' : 'New Bundle'"></h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Define product details and target
                            pricing</p>
                    </div>
                    <button @click="modalOpen = false"
                        class="p-2 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form :action="editMode ? baseUrl + '/' + bundle.id : productsUrl" method="POST"
                    enctype="multipart/form-data" class="p-6 space-y-6 max-h-[80vh] overflow-y-auto custom-scrollbar">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Network</label>
                            <select name="network" x-model="bundle.network" required
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                                <option value="">Select</option>
                                <option value="MTN">MTN</option>
                                <option value="TELECEL">Telecel</option>
                                <option value="AT">AT</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Status</label>
                            <select name="is_active" x-model="bundle.is_active"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                                <option :value="1">Active</option>
                                <option :value="0">Disabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Bundle
                            Name</label>
                        <input type="text" name="name" x-model="bundle.name" required placeholder="e.g. 1GB Super Saver"
                            class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Amount</label>
                            <input type="text" name="data_amount" x-model="bundle.data_amount" required placeholder="1 GB"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Cost
                                (GHS)</label>
                            <input type="number" step="0.01" name="cost_price" x-model="bundle.cost_price" required
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">User
                                Price</label>
                            <input type="number" step="0.01" name="price" x-model="bundle.price" required
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Dealer</label>
                            <input type="number" step="0.01" name="role_prices[dealer]" x-model="bundle.role_prices.dealer"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Super
                                Agent</label>
                            <input type="number" step="0.01" name="role_prices[super_agent]"
                                x-model="bundle.role_prices.super_agent"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm focus:ring-2 focus:ring-primary/20 dark:text-white">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Product
                            Visual Identity</label>

                        <div
                            class="flex items-center gap-6 p-4 bg-slate-50 dark:bg-slate-800/30 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-800 hover:border-primary/30 transition-all group relative overflow-hidden">
                            {{-- Preview Area --}}
                            <div
                                class="w-24 h-24 rounded-xl bg-white dark:bg-slate-900 flex items-center justify-center overflow-hidden shrink-0 border border-slate-100 dark:border-slate-800 shadow-sm relative z-10">
                                <template x-if="previewUrl">
                                    <img :src="previewUrl" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!previewUrl">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </template>
                            </div>

                            <div class="space-y-2 relative z-10">
                                <p class="text-[10px] font-bold text-slate-500 uppercase">Recommended: 800x600px</p>
                                <div class="relative">
                                    <button type="button"
                                        class="px-4 py-2 bg-primary/10 text-primary rounded-lg text-xs font-black uppercase tracking-tight hover:bg-primary hover:text-white transition-all">Select
                                        Image</button>
                                    <input type="file" name="image" @change="updatePreview"
                                        class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>
                            </div>

                            {{-- Decorative Background --}}
                            <div class="absolute right-0 bottom-0 opacity-[0.03] dark:opacity-[0.05] pointer-events-none">
                                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full h-12 bg-primary text-white rounded-2xl font-bold hover:opacity-90 active:scale-95 transition-all shadow-lg shadow-primary/20"
                        x-text="editMode ? 'Update Product' : 'Create Product'"></button>
                </form>
            </div>
        </div>
    </div>
@endsection