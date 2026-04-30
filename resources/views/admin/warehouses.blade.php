<x-app-layout>
    <x-slot name="header">
        {{ __('Warehouse Management') }}
    </x-slot>

    <div class="space-y-6" x-data="{ editingWarehouse: { id: '', name: '', code: '', address: '', type: 'origin' } }">
        <!-- Actions Row -->
        <div class="flex justify-between items-center animate-fade-in-up">
            <div class="bg-white px-6 py-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-6">
                <div class="flex flex-col border-r border-slate-100 pr-6">
                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Total Locations</span>
                    <span class="text-xl font-bold text-slate-900 font-outfit">{{ $warehouses->total() }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Network Status</span>
                    <span class="text-xl font-bold text-brand-700 font-outfit uppercase tracking-tighter">Global Hubs</span>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button x-on:click.prevent="$dispatch('open-modal', 'poe-mapping-modal')" class="bg-slate-900 text-white px-6 py-2.5 rounded-xl font-semibold shadow-lg hover:bg-slate-800 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Manage POE Mappings
                </button>
                <button x-on:click.prevent="$dispatch('open-modal', 'add-warehouse-modal')" class="btn-primary flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Add New Warehouse
                </button>
            </div>
        </div>

        <!-- Warehouses Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
            @forelse($warehouses as $wh)
                <div class="premium-card group hover:border-brand-700/30 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-brand-700/10 group-hover:text-brand-700 transition-colors shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <div class="flex gap-2">
                                <button 
                                    @click="editingWarehouse = {{ $wh->toJson() }}; $dispatch('open-modal', 'edit-warehouse-modal')"
                                    class="p-2 text-slate-400 hover:text-brand-700 hover:bg-brand-700/5 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <form action="{{ route('admin.warehouses.destroy', $wh) }}" method="POST" onsubmit="return confirm('Are you sure? Removing this warehouse will affect linked rates.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                            <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-widest {{ $wh->type == 'origin' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                {{ $wh->type }}
                            </span>
                        </div>
                    </div>
                    
                    <h4 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-brand-700 transition-colors uppercase tracking-tight">{{ $wh->name }}</h4>
                    <p class="text-[10px] font-bold text-brand-700 tracking-widest uppercase mb-4">{{ $wh->code }}</p>
                    
                    <div class="space-y-3 pt-4 border-t border-slate-50 italic">
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-slate-300 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="text-xs text-slate-500 leading-relaxed">{{ $wh->address }}</p>
                        </div>
                        @if($wh->type == 'origin')
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            <p class="text-xs font-bold text-slate-700 uppercase tracking-tighter">{{ $wh->rates_count }} Active Routes</p>
                        </div>
                        @else
                        <div class="flex items-start gap-2">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div class="flex flex-wrap gap-1">
                                @forelse($wh->countries as $country)
                                    <span class="text-[9px] bg-slate-100 px-1.5 py-0.5 rounded text-slate-600">{{ $country->name }}</span>
                                @empty
                                    <p class="text-xs text-slate-400">No countries mapped</p>
                                @endforelse
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <p class="font-bold uppercase tracking-widest text-[10px]">No warehouses registered.</p>
                </div>
            @endforelse
        </div>

        @if($warehouses->hasPages())
            <div class="mt-8">
                {{ $warehouses->links() }}
            </div>
        @endif

        <!-- POE Mapping Modal -->
        <x-modal name="poe-mapping-modal" focusable>
            <div class="p-8">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 font-outfit uppercase tracking-tight">POE Mapping</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <form action="{{ route('admin.warehouses.poe-mapping.store') }}" method="POST" class="bg-slate-50 p-6 rounded-2xl border border-slate-100 mb-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                        <div>
                            <x-input-label for="mapping_warehouse" value="POE Warehouse (Destination)" />
                            <select name="warehouse_id" id="mapping_warehouse" class="input-premium w-full mt-1 !bg-white" required>
                                <option value="">Select Destination POE</option>
                                @foreach($warehouses->where('type', 'destination') as $dwh)
                                    <option value="{{ $dwh->id }}">{{ $dwh->name }} ({{ $dwh->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="mapping_country" value="Map to Country" />
                            <select name="country_id" id="mapping_country" class="input-premium w-full mt-1 !bg-white" required>
                                <option value="">Select Country</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end">
                        <x-primary-button>Create Mapping</x-primary-button>
                    </div>
                </form>

                <div class="overflow-hidden border border-slate-100 rounded-xl">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 text-[10px] uppercase font-bold text-slate-400 tracking-widest">
                            <tr>
                                <th class="px-4 py-3">POE Warehouse</th>
                                <th class="px-4 py-3">Mapped Country</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($warehouses->where('type', 'destination') as $dwh)
                                @foreach($dwh->countryMappings as $mapping)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3 text-sm font-bold text-slate-900">{{ $dwh->name }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ $mapping->country->name }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <form action="{{ route('admin.warehouses.poe-mapping.destroy', $mapping) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </x-modal>

        <!-- Add Warehouse Modal -->
        <x-modal name="add-warehouse-modal" :show="$errors->any()" focusable>
            <form action="{{ route('admin.warehouses.store') }}" method="POST" class="p-8">
                @csrf
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 font-outfit uppercase tracking-tight">Register New Warehouse</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" value="Warehouse Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required placeholder="e.g. Dubai Main Hub" />
                        </div>
                        <div>
                            <x-input-label for="code" value="Warehouse Code" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full uppercase" required placeholder="e.g. DXB-01" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="type" value="Warehouse Type" />
                        <select name="type" id="type" class="input-premium w-full mt-1 !bg-white" required>
                            <option value="origin">Origin (US Export Center)</option>
                            <option value="destination">Destination (Global POE)</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="address" value="Full Address" />
                        <textarea id="address" name="address" rows="3" class="w-full mt-1 bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:border-brand-700 focus:ring-1 focus:ring-brand-700 outline-none transition-all shadow-sm" required placeholder="Enter full physical address..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button class="shadow-xl shadow-brand-700/20">Register Warehouse</x-primary-button>
                    </div>
                </div>
            </form>
        </x-modal>

        <!-- Edit Warehouse Modal -->
        <x-modal name="edit-warehouse-modal" focusable>
            <form :action="editingWarehouse ? '/admin/warehouses/' + editingWarehouse.id : '#'" method="POST" class="p-8">
                @csrf
                @method('PATCH')
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 font-outfit uppercase tracking-tight">Edit Warehouse</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="edit_name" value="Warehouse Name" />
                            <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" required x-model="editingWarehouse.name" />
                        </div>
                        <div>
                            <x-input-label for="edit_code" value="Warehouse Code" />
                            <x-text-input id="edit_code" name="code" type="text" class="mt-1 block w-full uppercase" required x-model="editingWarehouse.code" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="edit_type" value="Warehouse Type" />
                        <select name="type" id="edit_type" class="input-premium w-full mt-1 !bg-white" required x-model="editingWarehouse.type">
                            <option value="origin">Origin (US Export Center)</option>
                            <option value="destination">Destination (Global POE)</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="edit_address" value="Full Address" />
                        <textarea id="edit_address" name="address" rows="3" class="w-full mt-1 bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:border-brand-700 focus:ring-1 focus:ring-brand-700 outline-none transition-all shadow-sm" required x-model="editingWarehouse.address"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button class="shadow-xl shadow-brand-700/20">Update Warehouse</x-primary-button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
