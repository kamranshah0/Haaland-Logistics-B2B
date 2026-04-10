<x-app-layout>
    <x-slot name="header">
        {{ __('Service Types (Scopes)') }}
    </x-slot>

    <div class="space-y-6" x-data="{ editingType: { id: '', name: '', description: '' } }">
        <!-- Actions Row -->
        <div class="flex justify-between items-center animate-fade-in-up">
            <div class="bg-white px-6 py-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-6">
                <div class="flex flex-col border-r border-slate-100 pr-6">
                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Scope Types</span>
                    <span class="text-xl font-bold text-slate-900 font-outfit">{{ $serviceTypes->total() }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Operational Reach</span>
                    <span class="text-xl font-bold text-brand-700 font-outfit uppercase tracking-tighter">Global Scopes</span>
                </div>
            </div>
            
            <button x-on:click.prevent="$dispatch('open-modal', 'add-type-modal')" class="btn-primary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Register Scope
            </button>
        </div>

        <!-- Types Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
            @forelse($serviceTypes as $t)
                <div class="premium-card group hover:border-brand-700/30 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-brand-700/10 group-hover:text-brand-700 transition-colors shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="flex gap-2">
                            <button 
                                @click="editingType = {{ $t->toJson() }}; $dispatch('open-modal', 'edit-type-modal')"
                                class="p-2 text-slate-400 hover:text-brand-700 hover:bg-brand-700/5 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('admin.service-types.destroy', $t) }}" method="POST" onsubmit="return confirm('Are you sure? All associated routes will be affected.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <h4 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-brand-700 transition-colors uppercase tracking-tight">{{ $t->name }}</h4>
                    <p class="text-xs text-slate-500 line-clamp-2 mb-4 italic leading-relaxed">{{ $t->description ?: 'No description provided.' }}</p>
                    
                    <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                        <span class="px-2 py-0.5 rounded bg-brand-700/10 text-brand-700 text-[10px] font-bold border border-brand-700/20 uppercase">
                            {{ $t->getRawOriginal('rates_count') }} Rates
                        </span>
                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-500 text-[10px] font-bold border border-slate-200 uppercase">
                            {{ $t->getRawOriginal('quotes_count') }} Quotes
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    <p class="font-bold uppercase tracking-widest text-[10px]">No service types registered.</p>
                </div>
            @endforelse
        </div>

        @if($serviceTypes->hasPages())
            <div class="mt-8">
                {{ $serviceTypes->links() }}
            </div>
        @endif

        <!-- Add Type Modal -->
        <x-modal name="add-type-modal" :show="$errors->any()" focusable>
            <form action="{{ route('admin.service-types.store') }}" method="POST" class="p-8">
                @csrf
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 font-outfit uppercase tracking-tight">New Service Scope</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div>
                        <x-input-label for="name" value="Scope Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required placeholder="e.g. Warehouse to Port" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Scope Description" />
                        <textarea id="description" name="description" rows="3" class="input-premium w-full mt-1" placeholder="Describe the operational boundaries..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button class="shadow-xl shadow-brand-700/20">Register Scope</x-primary-button>
                    </div>
                </div>
            </form>
        </x-modal>

        <!-- Edit Type Modal -->
        <x-modal name="edit-type-modal" focusable>
            <form :action="editingType ? '/admin/service-types/' + editingType.id : '#'" method="POST" class="p-8">
                @csrf
                @method('PATCH')
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 font-outfit uppercase tracking-tight">Edit Scope</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div>
                        <x-input-label for="edit_type_name" value="Scope Name" />
                        <x-text-input id="edit_type_name" name="name" type="text" class="mt-1 block w-full" required x-model="editingType.name" />
                    </div>

                    <div>
                        <x-input-label for="edit_type_description" value="Scope Description" />
                        <textarea id="edit_type_description" name="description" rows="3" class="input-premium w-full mt-1" x-model="editingType.description"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button class="shadow-xl shadow-brand-700/20">Update Scope</x-primary-button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
