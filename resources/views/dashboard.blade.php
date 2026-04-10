<x-app-layout>
    <x-slot name="header">
        {{ Auth::user()->role === 'admin' ? 'Administrative Command Center' : 'GRP Platform for Household Goods' }}
    </x-slot>

    <div class="space-y-10">
        @if(Auth::user()->role === 'admin')
            <!-- ADMIN DASHBOARD: HIGH DENSITY LIGHT THEME -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in-up">
                <div class="premium-card group hover:border-brand-500 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-brand-700/5 rounded-2xl flex items-center justify-center text-brand-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-500/10 px-2 py-1 rounded-lg">+12%</span>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Total Clients</p>
                    <p class="text-4xl font-bold text-slate-900 font-outfit">{{ \App\Models\User::where('role', 'client')->count() }}</p>
                </div>

                <div class="premium-card group hover:border-brand-500 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-brand-700/5 rounded-2xl flex items-center justify-center text-brand-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-500/10 px-2 py-1 rounded-lg">Live</span>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Active Bookings</p>
                    <p class="text-4xl font-bold text-slate-900 font-outfit">{{ \App\Models\Booking::count() }}</p>
                </div>

                <div class="premium-card group hover:border-brand-500 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-brand-700/5 rounded-2xl flex items-center justify-center text-brand-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-amber-600 bg-amber-500/10 px-2 py-1 rounded-lg">Alert</span>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Pending Approval</p>
                    <p class="text-4xl font-bold text-slate-900 font-outfit">{{ \App\Models\User::where('status', 'pending')->count() }}</p>
                </div>

                <div class="premium-card group hover:border-brand-500 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-brand-700/5 rounded-2xl flex items-center justify-center text-brand-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-[10px] font-bold text-brand-600 bg-brand-500/10 px-2 py-1 rounded-lg">Global</span>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Origins Served</p>
                    <p class="text-4xl font-bold text-slate-900 font-outfit">{{ \App\Models\Warehouse::count() }}</p>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 animate-fade-in-up" style="animation-delay: 0.1s">
                <!-- Recent Activity Feed -->
                <div class="lg:col-span-2 premium-card !p-0 overflow-hidden bg-white border-slate-200">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="text-xl font-bold text-slate-900 font-outfit">Recent Queries</h3>
                        <button class="text-xs text-brand-700 hover:text-brand-900 transition-colors uppercase font-bold tracking-widest">View All</button>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach(\App\Models\Quote::latest()->take(5)->get() as $activity)
                            <div class="p-6 flex items-center justify-between hover:bg-slate-50 transition-colors cursor-pointer">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold border border-slate-200 text-slate-600">
                                        {{ substr($activity->user->name ?? 'G', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900">{{ $activity->user->name ?? 'Guest User' }}</p>
                                        <p class="text-[10px] text-slate-500 uppercase tracking-tight">Quote for {{ $activity->country->name }} ({{ number_format($activity->volume_cft, 0) }} CFT)</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold text-brand-700">${{ number_format($activity->total_price, 2) }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Vessel Utilization -->
                <div class="premium-card flex flex-col bg-white border-slate-200">
                    <h3 class="text-xl font-bold text-slate-900 mb-8 font-outfit">Vessel Utilization</h3>
                    <div class="space-y-8 flex-1">
                        @foreach(\App\Models\Departure::latest()->take(3)->get() as $dep)
                            <div class="space-y-2">
                                <div class="flex justify-between text-[10px] font-bold uppercase tracking-widest px-1">
                                    <span class="text-slate-500">{{ $dep->vessel_name ?? 'VOYAGE #' . $dep->voyage_number }}</span>
                                    <span class="text-brand-700">65%</span>
                                </div>
                                <div class="h-2.5 bg-slate-100 rounded-full overflow-hidden border border-slate-200">
                                    <div class="h-full bg-brand-700 rounded-full w-[65%] shadow-sm shadow-brand-500/20"></div>
                                </div>
                                <div class="flex justify-between items-center text-[9px] text-slate-400 px-1">
                                    <span>Cutoff: {{ $dep->cutoff_date->format('M d') }}</span>
                                    <span>{{ $dep->origin_code }} → {{ $dep->destination_name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <a href="{{ route('admin.departures') }}" class="btn-primary w-full text-center py-3 text-xs uppercase tracking-widest no-underline inline-block">Manage Departures</a>
                    </div>
                </div>
            </div>

        @else
            <!-- CLIENT DASHBOARD: GRP SPLIT SCREEN LIGHT -->
            <div class="space-y-10" x-data="quoteEngine()">
                <div class="grid lg:grid-cols-2 gap-8 animate-fade-in-up">
                    <!-- Left: Shipment Details -->
                    <div class="premium-card bg-white border-slate-200 shadow-sm">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-8 pb-3 border-b border-slate-50">Shipment Details</h3>
                        
                        <div class="space-y-6">
                            <!-- Volume Section -->
                            <div class="flex items-center justify-between mb-2">
                                <label class="text-sm text-slate-700 font-semibold">Volume</label>
                                <div class="flex items-center gap-4">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" value="CFT" x-model="unit" class="w-4 h-4 text-brand-700 focus:ring-brand-700 bg-white">
                                        <span class="text-xs font-bold text-slate-500">CFT</span>
                                    </label>
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" value="CBM" x-model="unit" class="w-4 h-4 text-brand-700 focus:ring-brand-700 bg-white">
                                        <span class="text-xs font-bold text-slate-500">CBM</span>
                                    </label>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="number" x-model="volume" @input="calculate()" class="input-premium w-full text-lg py-4 !border-slate-200 !bg-slate-50/50" placeholder="200">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold" x-text="unit"></span>
                            </div>

                            <!-- Warehouse Section -->
                            <div class="space-y-3">
                                <label class="text-sm text-slate-700 font-semibold">Drop-off Warehouse</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <template x-for="w in warehouses" :key="w.id">
                                        <label class="relative cursor-pointer group">
                                            <input type="radio" name="origin_id" :value="w.id" x-model="originId" @change="calculate()" class="peer sr-only">
                                            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl peer-checked:border-brand-700 peer-checked:bg-brand-700/5 transition-all text-center">
                                                <span class="block text-xs font-bold text-slate-500 group-hover:text-brand-700 uppercase tracking-tight" x-text="w.name"></span>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>

                            <!-- Country & Region -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Destination</label>
                                    <select x-model="countryId" @change="updateRegions()" class="input-premium w-full !bg-slate-50/50 !border-slate-200">
                                        <option value="">Select Country</option>
                                        @foreach(\App\Models\Country::all() as $c)
                                            <option value="{{ $c->id }}" data-regions="{{ $c->regions->toJson() }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Region</label>
                                    <select x-model="regionId" @change="calculate()" class="input-premium w-full !bg-slate-50/50 !border-slate-200">
                                        <option value="">Select Region</option>
                                        <template x-for="r in regions" :key="r.id">
                                            <option :value="r.id" x-text="r.name"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-4 pt-4">
                                <button @click="calculate()" class="btn-primary flex-1 py-4 text-sm uppercase tracking-widest">
                                    Calculate Quote
                                </button>
                                <button class="px-6 py-4 bg-slate-100 border border-slate-200 rounded-xl font-bold text-slate-600 hover:bg-slate-200 transition-all">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Price Breakdown -->
                    <div class="space-y-8">
                        <div class="premium-card bg-white border-slate-200">
                            <h3 class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-8 pb-3 border-b border-slate-50">Estimated Price <span class="text-slate-300 font-normal lowercase">(USD)</span></h3>
                            
                            <div class="space-y-6" x-show="quoteData">
                                <div class="flex justify-between items-center text-sm border-b border-slate-50 pb-4">
                                    <span class="text-slate-500">Origin Handling</span>
                                    <span class="text-slate-900 font-bold" x-text="'$' + quoteData.origin_handling"></span>
                                </div>
                                <div class="flex justify-between items-center text-sm border-b border-slate-50 pb-4">
                                    <span class="text-slate-500">Ocean Freight <span class="text-[10px] text-slate-400 italic" x-text="'(' + quoteData.billable_cft + ' CFT × $' + quoteData.rate_per_cft + ')'"></span></span>
                                    <span class="text-slate-900 font-bold" x-text="'$' + quoteData.ocean_freight"></span>
                                </div>
                                <div class="flex justify-between items-center text-sm border-b border-slate-50 pb-4">
                                    <span class="text-slate-500">Destination Charges</span>
                                    <span class="text-slate-900 font-bold">$0.00</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-500">Documentation</span>
                                    <span class="text-slate-900 font-bold">$105.00</span>
                                </div>
                                
                                <div class="pt-8 border-t-2 border-slate-100 flex justify-between items-center">
                                    <span class="text-2xl font-bold text-slate-500">Total</span>
                                    <span class="text-4xl font-bold font-outfit text-brand-700" x-text="'$' + (quoteData.total_price + 105).toFixed(2)"></span>
                                </div>
                            </div>

                            <div x-show="!quoteData" class="py-16 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="text-slate-400 italic text-sm">Enter shipment details to get an instant quote.</p>
                            </div>
                        </div>

                        <!-- Status Bar -->
                        <div class="premium-card bg-brand-700 shadow-xl shadow-brand-700/20 text-white border-none">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-brand-300">Available Vessel Space</span>
                                <span class="text-xl font-bold">1,240 CFT</span>
                            </div>
                            <div class="h-2 bg-white/10 rounded-full overflow-hidden mb-2">
                                <div class="h-full bg-white rounded-full w-[45%]"></div>
                            </div>
                            <p class="text-[10px] text-brand-200 uppercase tracking-tight">Voyage: #742 • Next Cutoff: April 15</p>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Containers Table -->
                <div class="premium-card !p-0 overflow-hidden bg-white shadow-none border-slate-200">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-xl font-bold text-slate-900 font-outfit uppercase tracking-widest">Upcoming Containers</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left order-collapse">
                            <thead>
                                <tr class="bg-brand-900 text-white text-[10px] uppercase tracking-widest font-bold">
                                    <th class="px-8 py-4">Lane</th>
                                    <th class="px-6 py-4">Departure</th>
                                    <th class="px-6 py-4">Cutoff</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Confirmed</th>
                                    <th class="px-8 py-4 text-right">Available</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse(\App\Models\Departure::all() as $dep)
                                    <tr class="hover:bg-slate-50 transition-colors group italic">
                                        <td class="px-8 py-5">
                                            <span class="text-sm font-bold text-slate-800">{{ $dep->origin_code }} → {{ $dep->destination_name }}</span>
                                        </td>
                                        <td class="px-6 py-5 text-sm text-slate-600">{{ $dep->departure_date->format('M d') }}</td>
                                        <td class="px-6 py-5 text-sm text-slate-400">{{ $dep->cutoff_date->format('M d') }}</td>
                                        <td class="px-6 py-5">
                                            <span class="px-2 py-1 bg-emerald-50 text-emerald-700 text-[10px] uppercase font-bold rounded border border-emerald-100">Filling</span>
                                        </td>
                                        <td class="px-6 py-5 text-sm font-bold text-slate-700">1,350 CFT</td>
                                        <td class="px-8 py-5 text-right font-bold text-brand-700">850 CFT</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="p-12 text-center text-slate-400 px-8 py-10">No upcoming schedules found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <script>
                function quoteEngine() {
                    return {
                        volume: null,
                        unit: 'CFT',
                        originId: '',
                        countryId: '',
                        regionId: '',
                        serviceType: 'Standard',
                        warehouses: @json(\App\Models\Warehouse::all()),
                        regions: [],
                        quoteData: null,
                        
                        updateRegions() {
                            const select = event.target;
                            const option = select.options[select.selectedIndex];
                            this.regions = option.dataset.regions ? JSON.parse(option.dataset.regions) : [];
                            this.regionId = '';
                            this.calculate();
                        },

                        async calculate() {
                            if (!this.volume || !this.originId || !this.countryId) return;
                            let cft = this.unit === 'CBM' ? this.volume * 35.3147 : this.volume;
                            try {
                                const response = await fetch(`/api/calculate-quote?origin_id=${this.originId}&country_id=${this.countryId}&region_id=${this.regionId}&cft=${cft}&service_type=${this.serviceType}`);
                                const res = await response.json();
                                if (res.success) { this.quoteData = res; } else { this.quoteData = null; }
                            } catch (e) { console.error(e); }
                        }
                    }
                }
            </script>
        @endif
    </div>
</x-app-layout>
