<x-app-layout>
    <x-slot name="header">
        {{ __('New Shipment Quote') }}
    </x-slot>

    <div class="max-w-4xl mx-auto py-8">
        <form action="{{ route('quotes.store') }}" method="POST" x-data="quoteCalculator()">
            @csrf
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Form Inputs -->
                <div class="md:col-span-2 space-y-6">
                    <div class="premium-card">
                        <h3 class="text-xl font-bold text-white mb-6 font-outfit">Route Details</h3>
                        
                        <div class="space-y-4">
                            <!-- Origin -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Origin Warehouse</label>
                                <select name="origin_id" x-model="originId" class="input-premium w-full">
                                    <option value="">Select Origin</option>
                                    @foreach($warehouses as $w)
                                        <option value="{{ $w->id }}">{{ $w->name }} ({{ $w->code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Destination -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Destination Country</label>
                                <select name="country_id" x-model="countryId" @change="updateRegions()" class="input-premium w-full">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $c)
                                        <option value="{{ $c->id }}" data-regions="{{ $c->regions->toJson() }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Region -->
                            <div x-show="regions.length > 0">
                                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Region</label>
                                <select name="region_id" x-model="regionId" class="input-premium w-full">
                                    <option value="">Select Region</option>
                                    <template x-for="r in regions" :key="r.id">
                                        <option :value="r.id" x-text="r.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="premium-card">
                        <h3 class="text-xl font-bold text-white mb-6 font-outfit">Cargo Specs</h3>
                        
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Volume</label>
                                <input type="number" step="0.01" name="volume" x-model="volume" @input="calculate()" class="input-premium w-full" placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Unit</label>
                                <select name="volume_unit" x-model="unit" @change="calculate()" class="input-premium w-full">
                                    <option value="CBM">CBM</option>
                                    <option value="CFT">CFT</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-xs font-bold uppercase tracking-widest text-slate-500 mb-2">Service Type</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="service_type" value="Express" class="peer sr-only" checked>
                                    <div class="p-4 bg-white/5 border border-white/5 rounded-2xl peer-checked:border-brand-500 peer-checked:bg-brand-500/10 transition-all text-center">
                                        <span class="block text-sm font-bold text-white uppercase tracking-widest">Express</span>
                                        <span class="text-[10px] text-slate-500">Fastest Delivery</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="service_type" value="Standard" class="peer sr-only">
                                    <div class="p-4 bg-white/5 border border-white/5 rounded-2xl peer-checked:border-brand-500 peer-checked:bg-brand-500/10 transition-all text-center">
                                        <span class="block text-sm font-bold text-white uppercase tracking-widest">Standard</span>
                                        <span class="text-[10px] text-slate-500">Cost Effective</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Live Preview Sidebar -->
                <div class="space-y-6">
                    <div class="premium-card sticky top-24 border-brand-500/20 shadow-xl shadow-brand-500/5">
                        <h4 class="text-xs font-bold uppercase tracking-widest text-brand-500 mb-4 italic">Quote Summary</h4>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between border-b border-white/5 pb-2">
                                <span class="text-xs text-slate-500">Taxable Vol.</span>
                                <span class="text-sm font-bold text-white"><span x-text="taxableCft">0.00</span> CFT</span>
                            </div>
                            <div class="flex justify-between border-b border-white/5 pb-2">
                                <span class="text-xs text-slate-500">Min. Applied</span>
                                <span class="text-xs font-bold text-brand-400" x-text="taxableCft <= 100 ? 'YES' : 'NO'"></span>
                            </div>
                        </div>

                        <div class="p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-center mb-6">
                            <p class="text-[10px] uppercase tracking-widest text-emerald-500 font-bold mb-1">Estimated Total</p>
                            <p class="text-3xl font-bold text-white font-outfit">$---</p>
                            <p class="text-[10px] text-slate-500 mt-2 italic">Calculated at booking time</p>
                        </div>

                        <button type="submit" class="btn-primary w-full py-4 flex justify-center items-center gap-2">
                            Generate Official Quote
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function quoteCalculator() {
            return {
                originId: '',
                countryId: '',
                regionId: '',
                regions: [],
                volume: 0,
                unit: 'CBM',
                taxableCft: 0,
                
                updateRegions() {
                    const select = event.target;
                    const option = select.options[select.selectedIndex];
                    if (option.dataset.regions) {
                        this.regions = JSON.parse(option.dataset.regions);
                    } else {
                        this.regions = [];
                    }
                    this.regionId = '';
                },
                
                calculate() {
                    let cft = this.unit === 'CBM' ? this.volume * 35.3147 : this.volume;
                    this.taxableCft = Math.max(cft, 100).toFixed(2);
                }
            }
        }
    </script>
</x-app-layout>
