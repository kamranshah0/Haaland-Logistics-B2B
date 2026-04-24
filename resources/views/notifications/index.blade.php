<x-app-layout>
    <x-slot name="header">
        Notification History
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="premium-card bg-white overflow-hidden shadow-sm border border-slate-200">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-xl font-bold text-slate-900 font-outfit uppercase tracking-tight">Your Activity Stream</h3>
                <div class="flex gap-4">
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-[10px] font-bold text-brand-700 uppercase tracking-widest hover:text-brand-800">Mark all as read</button>
                    </form>
                    <form action="{{ route('notifications.clear-all') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear all notifications?')">
                        @csrf
                        <button type="submit" class="text-[10px] font-bold text-red-500 uppercase tracking-widest hover:text-red-600">Clear all</button>
                    </form>
                </div>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($notifications as $notification)
                    <div class="p-6 flex items-start justify-between hover:bg-slate-50 transition-all {{ $notification->read_at ? 'opacity-60' : 'bg-brand-50/20' }}">
                        <div class="flex gap-6">
                            <div class="shrink-0 w-12 h-12 rounded-2xl flex items-center justify-center {{ $notification->read_at ? 'bg-slate-100 text-slate-400' : 'bg-brand-700/10 text-brand-700' }} border border-white/20 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @php
                                        $icon = $notification->data['icon'] ?? 'bell';
                                    @endphp
                                    @if($icon === 'user-group')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 1 1 0 5.292M15 21H3v-1a6 6 0 0 1 12 0v1zm0 0h6v-1a6 6 0 0 0-9-5.197M13 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0z" />
                                    @elseif($icon === 'check-circle')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                    @endif
                                </svg>
                            </div>
                            <div>
                                <p class="text-base font-bold text-slate-900 font-outfit">{{ $notification->data['title'] ?? 'New Notification' }}</p>
                                <p class="text-sm text-slate-500 mt-1 leading-relaxed">{{ $notification->data['message'] ?? '' }}</p>
                                <div class="flex items-center gap-4 mt-4">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $notification->created_at->diffForHumans() }}</span>
                                    @if($notification->data['link'] !== '#')
                                        <a href="{{ $notification->data['link'] }}" class="text-[10px] font-bold text-brand-700 uppercase tracking-widest hover:underline">View Details &rarr;</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if(!$notification->read_at)
                            <form action="{{ route('notifications.mark-as-read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-3 h-3 rounded-full bg-brand-500 shadow-lg shadow-brand-500/50" title="Mark as read"></button>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="p-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-200">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <p class="text-slate-400 font-bold uppercase tracking-[0.2em] text-xs">No notifications found</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->hasPages())
                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
