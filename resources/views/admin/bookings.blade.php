<x-app-layout>
    <x-slot name="header">
        {{ __('All Regular Bookings') }}
    </x-slot>

    <div class="animate-fade-in-up">
        <div class="premium-card !p-0 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-900 font-outfit uppercase tracking-widest">Platform Bookings</h3>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-brand-900 text-white text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-6 py-4">Booking Ref</th>
                            <th class="px-6 py-4">Client</th>
                            <th class="px-6 py-4">Route Info</th>
                            <th class="px-6 py-4">Volume & Cargo</th>
                            <th class="px-6 py-4 text-right">Status & Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-900 not-italic uppercase tracking-tight">{{ $booking->booking_number }}</span>
                                        <span class="text-[10px] text-emerald-600 uppercase font-bold">Paid: ${{ number_format($booking->quote->total_price ?? 0, 2) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-800 not-italic">{{ $booking->user->name ?? 'N/A' }}</span>
                                        <span class="text-[10px] text-slate-500">{{ $booking->user->email ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-800 not-italic uppercase">{{ $booking->quote->origin->name ?? 'N/A' }} → {{ $booking->quote->country->name ?? 'N/A' }}</span>
                                        <span class="text-[10px] text-slate-500">{{ $booking->quote->service ?? 'N/A' }} ({{ $booking->quote->service_type ?? 'N/A' }})</span>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <span class="text-sm font-bold text-slate-800 not-italic">{{ number_format($booking->quote->volume_cft ?? 0, 2) }} CFT</span>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-4 not-italic">
                                        <div class="flex flex-col items-end">
                                            <span class="px-3 py-1 rounded inline-block text-[10px] uppercase font-bold border 
                                                {{ $booking->status == 'pending' ? 'bg-amber-50 text-amber-600 border-amber-200' : 'bg-emerald-50 text-emerald-600 border-emerald-200' }}">
                                                {{ $booking->status }}
                                            </span>
                                            <p class="text-[10px] text-slate-400 mt-1 font-bold">{{ \Carbon\Carbon::parse($booking->drop_off_date)->format('M d, Y') }} at {{ $booking->drop_off_time }}</p>
                                        </div>
                                        <form action="{{ route('admin.bookings.toggle-status', $booking) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 rounded {{ $booking->status == 'pending' ? 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/20' : 'bg-slate-200 hover:bg-slate-300' }} text-white shadow-lg transition-all" title="Toggle Status">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium not-italic">
                                    No regular platform bookings found yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
