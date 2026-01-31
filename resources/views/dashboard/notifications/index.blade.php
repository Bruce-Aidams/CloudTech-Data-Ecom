@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
    <div class="space-y-6 animate-fade-in-up">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500 ring-1 ring-amber-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black tracking-tight text-blue-900 dark:text-white uppercase">Notification Terminal</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Monitoring system alerts and secure broadcasts.</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <form action="{{ route('notifications.user_index') }}" method="GET" class="relative min-w-[120px]">
                    <select name="per_page" onchange="this.form.submit()" class="w-full h-10 px-4 bg-white dark:bg-[#2b2c40] border border-slate-100 dark:border-[#444564] rounded-xl text-[10px] font-black uppercase tracking-[0.2em] outline-none focus:ring-2 focus:ring-primary/20 transition-all dark:text-[#a3a4cc] appearance-none cursor-pointer shadow-sm">
                        @foreach([15, 30, 50, 100] as $val)
                            <option value="{{ $val }}" {{ request('per_page', 15) == $val ? 'selected' : '' }}>{{ $val }} Per Page</option>
                        @endforeach
                    </select>
                </form>
                @if($notifications->where('is_read', false)->count() > 0)
                    <form action="{{ route('notifications.read_all') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all active:scale-95 flex items-center gap-2 border border-primary/20 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            Normalize All Protocols
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="bg-white dark:bg-[#2b2c40] rounded-[2rem] border border-slate-100 dark:border-[#444564] shadow-sm overflow-hidden">
            <div class="divide-y divide-slate-100 dark:divide-[#444564]">
            @forelse($notifications as $notification)
                <div class="p-6 md:p-8 hover:bg-slate-50/50 dark:hover:bg-[#32334a] transition-all duration-300 group relative {{ !$notification->is_read ? 'bg-primary/[0.02] dark:bg-primary/[0.05]' : '' }}">
                    @if(!$notification->is_read)
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                    @endif
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0 shadow-sm
                            {{ $notification->type === 'success' ? 'bg-green-100 text-green-600 dark:bg-green-500/20 dark:text-green-500' : 
                               ($notification->type === 'error' ? 'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-500' : 
                               ($notification->type === 'warning' ? 'bg-yellow-100 text-yellow-600 dark:bg-yellow-500/20 dark:text-yellow-500' : 
                               'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-500')) }}">
                            @if($notification->type === 'success')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @elseif($notification->type === 'error')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @elseif($notification->type === 'warning')
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @endif
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h4 class="text-sm font-bold text-[#566a7f] dark:text-[#d5d6e0] tracking-tight group-hover:text-primary transition-colors">{{ $notification->title }}</h4>
                                <span class="text-xs font-medium text-[#a1acb8] dark:text-[#7071a4] whitespace-nowrap ml-4">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-[#697a8d] dark:text-[#a3a4cc] leading-relaxed">{{ $notification->message }}</p>
                        </div>
                        
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-[#a1acb8] hover:text-red-500 bg-white dark:bg-[#2b2c40] rounded-lg shadow-sm border border-slate-100 dark:border-[#444564] hover:border-red-500/20 transition-all" title="Delete Notification">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-16 text-center flex flex-col items-center">
                    <div class="w-20 h-20 bg-slate-50 dark:bg-[#32334a] rounded-full flex items-center justify-center text-slate-300 dark:text-slate-600 mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-[#566a7f] dark:text-[#d5d6e0]">No Notifications</h3>
                    <p class="text-[#a1acb8] dark:text-[#7071a4] mt-2 max-w-xs mx-auto">You're all caught up! Check back later for new updates.</p>
                </div>
            @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
@endsection
