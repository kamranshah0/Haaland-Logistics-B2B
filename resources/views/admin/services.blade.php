<x-app-layout>
    <x-slot name="header">
        {{ __('Shipping Services') }}
    </x-slot>

    <div class="space-y-6" x-data="{ editingService: { id: '', name: '', description: '' } }">
        <!-- Actions Row -->
        <div class="flex justify-between items-center animate-fade-in-up">
            <div class="bg-white px-6 py-4 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-6">
                <div class="flex flex-col border-r border-slate-100 pr-6">
                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Offerings</span>
                    <span class="text-xl font-bold text-slate-900 font-outfit">{{ $services->total() }}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] uppercase tracking-widest text-slate-400 font-bold">Category Scope</span>
                    <span class="text-xl font-bold text-brand-700 font-outfit uppercase tracking-tighter">Freight Ops</span>
                </div>
            </div>
            
            <button x-on:click.prevent="$dispatch('open-modal', 'add-service-modal')" class="btn-primary flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Create Category
            </button>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-fade-in-up" style="animation-delay: 0.1s">
            @forelse($services as $s)
                <div class="premium-card group hover:border-brand-700/30 transition-all">
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-brand-700/10 group-hover:text-brand-700 transition-colors shadow-inner">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        </div>
                        <div class="flex gap-2">
                            <button 
                                @click="editingService = {{ $s->toJson() }}; $dispatch('open-modal', 'edit-service-modal')"
                                class="p-2 text-slate-400 hover:text-brand-700 hover:bg-brand-700/5 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form action="{{ route('admin.services.destroy', $s) }}" method="POST" onsubmit="return confirm('Are you sure? This category will be removed.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all opacity-0 group-hover:opacity-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <h4 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-brand-700 transition-colors uppercase tracking-tight">{{ $s->name }}</h4>
                    <p class="text-xs text-slate-500 line-clamp-2 mb-4 italic leading-relaxed">{{ $s->description ?: 'No description provided.' }}</p>
                    
                    <div class="flex items-center gap-2 pt-4 border-t border-slate-50">
                        <span class="px-2 py-0.5 rounded bg-brand-700/10 text-brand-700 text-[10px] font-bold border border-brand-700/20 uppercase">
                            {{ $s->rates_count }} active routes
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white rounded-3xl border-2 border-dashed border-slate-200 text-slate-400">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    <p class="font-bold uppercase tracking-widest text-[10px]">No service categories found.</p>
                </div>
            @endforelse
        </div>

        @if($services->hasPages())
            <div class="mt-8">
                {{ $services->links() }}
            </div>
        @endif

        <!-- Add Service Modal -->
        <x-modal name="add-service-modal" :show="$errors->any()" focusable>
            <form action="{{ route('admin.services.store') }}" method="POST" class="p-8">
                @csrf
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 font-outfit uppercase tracking-tight">New Service Category</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div>
                        <x-input-label for="name" value="Service Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required placeholder="e.g. Express Ocean Freight" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Service Description" />
                        <textarea id="description" name="description" rows="3" class="input-premium w-full mt-1" placeholder="Describe the service benefits..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button class="shadow-xl shadow-brand-700/20">Create Category</x-primary-button>
                    </div>
                </div>
            </form>
        </x-modal>

        <!-- Edit Service Modal -->
        <x-modal name="edit-service-modal" focusable>
            <form :action="editingService ? '/admin/services/' + editingService.id : '#'" method="POST" class="p-8">
                @csrf
                @method('PATCH')
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 font-outfit uppercase tracking-tight">Edit Category</h2>
                    <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-6">
                    <div>
                        <x-input-label for="edit_name" value="Service Name" />
                        <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" required x-model="editingService.name" />
                    </div>

                    <div>
                        <x-input-label for="edit_description" value="Service Description" />
                        <textarea id="edit_description" name="description" rows="3" class="input-premium w-full mt-1" x-model="editingService.description"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-slate-100">
                        <x-secondary-button type="button" x-on:click="$dispatch('close')">Cancel</x-secondary-button>
                        <x-primary-button class="shadow-xl shadow-brand-700/20">Update Category</x-primary-button>
                    </div>
                </div>
            </form>
        </x-modal>
    </div>
</x-app-layout>
