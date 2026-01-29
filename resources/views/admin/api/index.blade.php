@extends('layouts.admin')

@section('title', 'API Management')

@section('content')
    <div class="space-y-6 pb-12 animate-in fade-in slide-in-from-bottom-4 duration-700" x-data="{ 
                                                                tab: 'providers',
                                                                modalOpen: false, 
                                                                editMode: false,
                                                                provider: { id: '', name: '', base_url: '', webhook_url: '', api_key: '', secret_key: '', is_active: true },
                                                                resetForm() {
                                                                    this.provider = { id: '', name: '', base_url: '', webhook_url: '', api_key: '', secret_key: '', is_active: true };
                                                                    this.editMode = false;
                                                                },
                                                                openAdd() {
                                                                    this.resetForm();
                                                                    this.modalOpen = true;
                                                                },
                                                                openEdit(p) {
                                                                    this.provider = JSON.parse(JSON.stringify(p));
                                                                    this.editMode = true;
                                                                    this.modalOpen = true;
                                                                }
                                                            }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">API Infrastructure</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage external provider connections and
                    transmission logs.</p>
            </div>

            <button x-show="tab === 'providers'" @click="openAdd()"
                class="h-11 px-6 bg-primary text-white rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Provider
            </button>
        </div>

        <!-- Tab Controls -->
        <div class="flex gap-2 p-1 bg-slate-100 dark:bg-slate-800/50 rounded-xl w-fit overflow-x-auto">
            <button @click="tab = 'providers'"
                :class="tab === 'providers' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap">
                Active Providers
            </button>
            <button @click="tab = 'connectivity'"
                :class="tab === 'connectivity' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap">
                Connectivity (Webhooks)
            </button>
            <button @click="tab = 'logs'"
                :class="tab === 'logs' ? 'bg-white dark:bg-slate-900 text-slate-900 dark:text-white shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all whitespace-nowrap">
                System Logs
            </button>
        </div>

        <!-- Connectivity View -->
        <div x-show="tab === 'connectivity'" class="space-y-6">
            <div
                class="bg-white dark:bg-slate-900 rounded-3xl p-8 border border-slate-100 dark:border-slate-800 shadow-sm relative overflow-hidden">
                <div class="flex items-center gap-4 mb-10">
                    <div
                        class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-2xl flex items-center justify-center text-indigo-600 dark:text-indigo-400 transition-transform hover:scale-105">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-slate-900 dark:text-white">Global Webhooks</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-500 mt-1 uppercase tracking-widest font-bold">
                            External Event Sync</p>
                    </div>
                </div>

                <div class="space-y-8 max-w-3xl">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[.2em]">Webhook
                                Endpoint URL</label>
                            <input type="url" name="webhook_url" id="webhook_url"
                                value="{{ \App\Models\Setting::where('key', 'webhook_url')->first()?->value }}"
                                placeholder="https://external-service.com/api/webhook"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                            <p class="text-[9px] text-slate-400 italic">Target URL for automated outbound POST requests.</p>
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[.2em]">Signing
                                Secret Key</label>
                            <input type="text" name="webhook_secret" id="webhook_secret"
                                value="{{ \App\Models\Setting::where('key', 'webhook_secret')->first()?->value }}"
                                placeholder="WH_SECRET_KEY..."
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 outline-none transition-all dark:text-white">
                        </div>
                    </div>

                    <div
                        class="p-6 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-800">
                        <h5 class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-5">
                            Events to Transmit</h5>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach(['Order Created', 'Order Completed', 'Order Failed', 'Deposit Successful', 'Manual Adjustment'] as $event)
                                <label
                                    class="flex items-center p-3.5 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-xl cursor-pointer hover:border-primary/50 transition-all group">
                                    <input type="checkbox"
                                        class="w-4 h-4 text-primary rounded-md border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 focus:ring-primary/20">
                                    <span
                                        class="ml-3 text-xs font-bold text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">{{ $event }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="button" @click="async () => {
                                                            const url = document.getElementById('webhook_url').value;
                                                            const secret = document.getElementById('webhook_secret').value;
                                                            const response = await fetch('{{ route('admin.settings.update') }}', {
                                                                method: 'PUT',
                                                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                                                body: JSON.stringify({ settings: { webhook_url: url, webhook_secret: secret } })
                                                            });
                                                            if(response.ok) alert('Webhook configuration synchronized!');
                                                            else alert('Failed to save webhook settings.');
                                                        }"
                            class="h-12 px-8 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-bold text-xs uppercase shadow-lg hover:opacity-90 active:scale-[0.98] transition-all flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                </path>
                            </svg>
                            Save Infrastructure Settings
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Providers View -->
        <div x-show="tab === 'providers'" class="space-y-6">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($providers as $p)
                    <div
                        class="bg-white dark:bg-slate-900 rounded-3xl p-6 border border-slate-100 dark:border-slate-800 shadow-sm flex flex-col hover:border-primary/30 transition-all group">
                        <div class="flex items-start justify-between mb-8">
                            <div
                                class="w-12 h-12 bg-slate-50 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-primary transition-transform group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tight {{ $p->is_active ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }}">
                                <span
                                    class="w-1.5 h-1.5 mr-2 rounded-full {{ $p->is_active ? 'bg-emerald-500' : 'bg-slate-500' }}"></span>
                                {{ $p->is_active ? 'Active' : 'Offline' }}
                            </span>
                        </div>

                        <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-1">{{ $p->name }}</h4>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/80 px-3 py-2 rounded-xl border border-slate-100 dark:border-slate-700/50 mb-8 mt-2 overflow-hidden">
                            <code
                                class="text-[10px] text-slate-500 dark:text-slate-400 font-mono block truncate">{{ $p->base_url }}</code>
                        </div>

                        <div class="mt-auto flex items-center gap-3">
                            <button @click="openEdit({{ $p->toJson() }})"
                                class="flex-1 h-11 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-[10px] font-bold uppercase text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                                Configure
                            </button>
                            <form action="{{ route('admin.api.providers.destroy', $p->id) }}" method="POST"
                                onsubmit="return confirm('Terminate this provider connection?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="w-11 h-11 flex items-center justify-center text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-24 text-center">
                        <div
                            class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-700" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Empty Infrastructure</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-500 mt-2 max-w-xs mx-auto">Establish a new API
                            connection to begin processing transaction flows.</p>
                        <button @click="openAdd()"
                            class="mt-8 px-6 py-3 bg-primary text-white rounded-2xl font-bold text-xs uppercase shadow-xl shadow-primary/20 hover:opacity-90 transition-all">Add
                            Provider</button>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Logs View -->
        <div x-show="tab === 'logs'" class="space-y-6">
            <div
                class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
                <div class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Traffic Logs</h3>
                    <p class="text-[10px] text-slate-500 dark:text-slate-500 font-bold uppercase tracking-widest mt-0.5">
                        Real-time Traffic Analysis</p>
                </div>


                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-800">
                            <tr>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Timestamp</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Provider</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Endpoint</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800 font-medium">
                            @forelse($logs as $log)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <span
                                            class="text-sm font-bold text-slate-900 dark:text-white block">{{ $log->created_at->format('M d, H:i') }}</span>
                                        <span
                                            class="text-[10px] text-slate-500 dark:text-slate-500 uppercase tracking-tighter">{{ $log->created_at->format('s.u') }}ms</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2 py-1 rounded-lg text-[10px] font-bold uppercase bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700/50">
                                            {{ $log->provider->name ?? 'SYSTEM' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="px-1.5 py-0.5 rounded text-[8px] font-black bg-slate-900 dark:bg-white text-white dark:text-slate-900 uppercase">
                                                {{ $log->method }}
                                            </span>
                                            <code class="text-[10px] text-slate-500 font-mono truncate max-w-[200px]"
                                                title="{{ $log->endpoint }}">{{ $log->endpoint }}</code>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $hc = $log->status_code >= 400 ? 'bg-rose-50 dark:bg-rose-900/20 text-rose-600' : 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600';
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black {{ $hc }}">
                                            {{ $log->status_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button @click="$dispatch('open-log-modal', {{ $log->toJson() }})"
                                            class="text-[10px] font-bold text-primary uppercase tracking-widest hover:underline">
                                            View
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-24 text-center text-slate-400 dark:text-slate-600 italic">No
                                        logs available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->isNotEmpty())
                    <div
                        class="px-8 py-4 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex items-center justify-between">
                        <div class="text-[10px] font-bold text-slate-500 uppercase tracking-widest italic">Total Records:
                            {{ $logs->total() }}
                        </div>
                        <div>{{ $logs->links() }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Provider Management Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-[100] flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm shadow-2xl" @click="modalOpen = false"></div>

            <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl overflow-hidden shadow-2xl animate-in zoom-in-95 duration-200 border border-slate-100 dark:border-slate-800"
                @click.stop>
                <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white"
                            x-text="editMode ? 'Edit Provider' : 'Add Provider'"></h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Configure API connection details</p>
                    </div>
                    <button @click="modalOpen = false"
                        class="p-2 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form
                    :action="editMode ? '{{ url('admin/api-management/providers') }}/' + provider.id : '{{ route('admin.api.providers.store') }}'"
                    method="POST" class="p-8 space-y-6">
                    @csrf
                    <template x-if="editMode"><input type="hidden" name="_method" value="PUT"></template>

                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Name</label>
                        <input type="text" name="name" x-model="provider.name" required placeholder="e.g. Paystack"
                            class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-bold focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                    </div>

                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Base
                            URL</label>
                        <input type="url" name="base_url" x-model="provider.base_url" required
                            placeholder="https://api.example.com"
                            class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                    </div>

                    <div class="space-y-1.5">
                        <label
                            class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Webhook
                            URL (Optional)</label>
                        <input type="url" name="webhook_url" x-model="provider.webhook_url" placeholder="https://..."
                            class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">API
                                Key</label>
                            <input type="password" name="api_key" x-model="provider.api_key" placeholder="••••••••"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                        </div>
                        <div class="space-y-1.5">
                            <label
                                class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Secret
                                Key</label>
                            <input type="password" name="secret_key" x-model="provider.secret_key" placeholder="••••••••"
                                class="w-full h-11 px-4 bg-slate-50 dark:bg-slate-800 border-none rounded-xl text-sm font-mono focus:ring-2 focus:ring-primary/20 transition-all dark:text-white">
                        </div>
                    </div>

                    <div class="pt-2">
                        <label class="flex items-center group cursor-pointer">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="is_active" value="1" x-model="provider.is_active"
                                    class="sr-only peer">
                                <div
                                    class="w-10 h-6 bg-slate-200 dark:bg-slate-700 rounded-full peer peer-checked:bg-primary transition-all">
                                </div>
                                <div
                                    class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full transition-transform peer-checked:translate-x-4">
                                </div>
                            </div>
                            <div class="ml-4">
                                <span
                                    class="text-xs font-bold text-slate-700 dark:text-slate-200 block uppercase tracking-tight">Active</span>
                                <span
                                    class="text-[9px] text-slate-500 dark:text-slate-500 font-bold uppercase tracking-tighter">Enable
                                    provider</span>
                            </div>
                        </label>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button" @click="modalOpen = false"
                            class="flex-1 h-12 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-[10px] font-bold uppercase text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">Cancel</button>
                        <button type="submit"
                            class="flex-[2] h-12 bg-primary text-white rounded-2xl font-bold text-[10px] uppercase shadow-xl shadow-primary/20 hover:opacity-90 transition-all"
                            x-text="editMode ? 'Update Provider' : 'Save Provider'"></button>
                    </div>
                </form>
            </div>
        </div>

        <!-- API Log Details Modal -->
        <div x-data="{ open: false, log: {} }" x-show="open" @open-log-modal.window="log = $event.detail; open = true"
            class="fixed inset-0 z-[110] flex items-center justify-center p-4" x-cloak>
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="open = false"></div>

            <div
                class="relative w-full max-w-3xl bg-white dark:bg-slate-900 rounded-3xl shadow-2xl overflow-hidden flex flex-col max-h-[85vh] border border-slate-100 dark:border-slate-800 animate-in zoom-in-95 duration-200">
                <div
                    class="px-8 py-6 border-b border-slate-50 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/20">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">Transaction Details</h3>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 font-bold font-mono tracking-widest mt-0.5"
                            x-text="'ID: ' + log.id"></p>
                    </div>
                    <button @click="open = false"
                        class="p-2 text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl transition-all">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-8 overflow-y-auto space-y-8 custom-scrollbar">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[.2em] mb-2">Code</p>
                            <p class="text-2xl font-black"
                                :class="log.status_code >= 400 ? 'text-rose-600' : 'text-emerald-600'"
                                x-text="log.status_code"></p>
                        </div>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[.2em] mb-2">Method</p>
                            <p class="text-lg font-black text-slate-900 dark:text-white uppercase" x-text="log.method"></p>
                        </div>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[.2em] mb-2">Provider</p>
                            <p class="text-sm font-black text-slate-900 dark:text-white truncate uppercase"
                                x-text="log.provider ? log.provider.name : 'SYSTEM'"></p>
                        </div>
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                            <p class="text-[8px] font-black text-slate-400 uppercase tracking-[.2em] mb-2">Time</p>
                            <p class="text-sm font-black text-slate-900 dark:text-white"
                                x-text="new Date(log.created_at).toLocaleTimeString()"></p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[.2em]">Endpoint</label>
                            <div class="bg-slate-900 rounded-xl p-4 border border-slate-800 shadow-inner">
                                <code class="text-emerald-400 text-[11px] font-mono break-all" x-text="log.endpoint"></code>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label
                                class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[.2em]">Response</label>
                            <div
                                class="bg-slate-900 rounded-2xl p-6 border border-slate-800 shadow-inner max-h-[400px] overflow-auto custom-scrollbar">
                                <pre class="text-slate-300 text-[10px] font-mono leading-relaxed"
                                    x-text="JSON.stringify(log.response ? (typeof log.response === 'string' ? JSON.parse(log.response) : log.response) : (log.error_message || 'NO_DATA'), null, 2)"></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="px-8 py-5 border-t border-slate-50 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/20 flex justify-end">
                    <button @click="open = false"
                        class="px-6 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-[10px] font-bold uppercase text-slate-700 dark:text-slate-300">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection