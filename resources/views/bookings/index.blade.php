<x-app-layout>
    <x-slot name="header">
        {{ __('Booking History') }}
    </x-slot>

    <div class="space-y-6">
        <!-- Header Section -->
        <div class="flex justify-between items-center animate-fade-in-up">
            <h3 class="text-xl font-bold text-white font-outfit">My Active Bookings</h3>
        </div>

        <!-- Success Messages -->
        @if(session('success'))
            <div class="glass border border-emerald-500/20 p-4 rounded-2xl text-emerald-400 text-sm animate-fade-in-up">
                {{ session('success') }}
            </div>
        @endif

        <!-- Bookings Grid -->
        <div class="premium-card !p-0 overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-white/2 text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-6 py-4">Booking ID</th>
                            <th class="px-6 py-4">Route Info</th>
                            <th class="px-6 py-4">Volumes</th>
                            <th class="px-6 py-4">Vessel / Departure</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-white/[0.02] transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-white uppercase">{{ $booking->booking_number }}</span>
                                    <p class="text-[10px] text-slate-500 uppercase">{{ $booking->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-bold text-brand-400">{{ $booking->quote->origin->code }}</span>
                                        <svg class="w-3 h-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        <span class="text-xs font-bold text-white">{{ $booking->quote->country->name }}</span>
                                    </div>
                                    <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-tighter">{{ $booking->quote->service_type }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-300 font-medium">{{ number_format($booking->quote->billable_volume_cft, 2) }} CFT</span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($booking->departure)
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-white uppercase tracking-tight">{{ $booking->departure->vessel_name }}</span>
                                            <span class="text-[9px] text-brand-400 font-bold uppercase">ETD: {{ $booking->departure->etd->format('M d, Y') }}</span>
                                        </div>
                                    @else
                                        <span class="text-[10px] text-slate-600 uppercase italic font-bold">Awaiting Planning</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($booking->status === 'pending')
                                        <span class="px-2 py-1 rounded-md bg-amber-500/10 text-amber-500 text-[10px] font-bold uppercase border border-amber-500/20">Pending</span>
                                    @elseif($booking->status === 'confirmed')
                                        <span class="px-2 py-1 rounded-md bg-emerald-500/10 text-emerald-500 text-[10px] font-bold uppercase border border-emerald-500/20">Confirmed</span>
                                    @elseif($booking->status === 'shipped')
                                        <span class="px-2 py-1 rounded-md bg-brand-600/10 text-brand-400 text-[10px] font-bold uppercase border border-brand-500/20">In Transit</span>
                                    @else
                                        <span class="px-2 py-1 rounded-md bg-white/5 text-slate-400 text-[10px] uppercase">{{ $booking->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button class="bg-white/5 hover:bg-white/10 text-slate-400 hover:text-white p-2 rounded-lg transition-all border border-white/5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                    No bookings found. Convert your quotes into bookings to see them here.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($bookings->hasPages())
                <div class="px-6 py-4 border-t border-white/5">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
