<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Global Operations Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-toast />
            
            <div x-data="{ tab: 'pricing' }" class="space-y-6">
                <!-- Navigation Tabs -->
                <div class="flex gap-4 border-b border-slate-200 mb-2">
                    <button @click="tab = 'pricing'" :class="tab === 'pricing' ? 'border-brand-500 text-brand-700' : 'border-transparent text-slate-500 hover:text-slate-700'" class="pb-4 px-2 border-b-2 font-bold text-sm uppercase tracking-widest transition-all">
                        Pricing Logic
                    </button>
                    <button @click="tab = 'email'" :class="tab === 'email' ? 'border-brand-500 text-brand-700' : 'border-transparent text-slate-500 hover:text-slate-700'" class="pb-4 px-2 border-b-2 font-bold text-sm uppercase tracking-widest transition-all">
                        Email Platform
                    </button>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                    <div class="p-6 md:p-8">
                        
                        <!-- PRICING TAB -->
                        <div x-show="tab === 'pricing'" x-transition>
                            <div class="mb-8 border-b border-slate-100 pb-5">
                                <h3 class="text-lg font-bold text-slate-900 font-outfit">Core Pricing Variables</h3>
                                <p class="text-sm text-slate-500 mt-1">Configure the global baselines that impact all system-generated quotes.</p>
                            </div>

                            <form action="{{ route('admin.settings.update') }}" method="POST" class="max-w-xl">
                                @csrf
                                <div class="space-y-6">
                                    <div class="p-5 bg-brand-50/50 border border-brand-100 rounded-xl relative overflow-hidden">
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-500"></div>
                                        <label for="origin_service_fee" class="block text-sm font-bold text-brand-900 mb-2 font-outfit flex items-center gap-2">
                                            <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Origin Service Fee
                                        </label>
                                        <p class="text-xs text-slate-500 mb-3 ml-6 leading-relaxed">Added as "Origin Handling" to every new shipping quote. (Default: $3.00)</p>
                                        <div class="flex items-center gap-3 ml-6">
                                            <span class="text-slate-400 font-bold">$</span>
                                            <input type="number" step="0.01" name="origin_service_fee" id="origin_service_fee" 
                                                value="{{ old('origin_service_fee', $settings['origin_service_fee']->value ?? '3.00') }}" 
                                                class="input-premium w-32 font-mono text-lg text-slate-900" required>
                                            <span class="text-sm text-slate-500 font-bold">per CFT</span>
                                        </div>
                                    </div>

                                    <div class="p-5 bg-slate-50 border border-slate-200 rounded-xl">
                                        <label for="minimum_volume" class="block text-sm font-semibold text-slate-700 mb-2 font-outfit">Global Minimum Required Volume</label>
                                        <p class="text-xs text-slate-500 mb-3 leading-relaxed">The baseline volume for billing small shipments. (Default: 100 CFT)</p>
                                        <div class="flex items-center gap-3">
                                            <input type="number" step="0.01" name="minimum_volume" id="minimum_volume" 
                                                value="{{ old('minimum_volume', $settings['minimum_volume']->value ?? '100.00') }}" 
                                                class="input-premium w-32 font-mono text-slate-900" required>
                                            <span class="text-sm text-slate-500 font-bold">CFT</span>
                                        </div>
                                    </div>

                                    <div class="pt-4 flex justify-end" x-data="{ loading: false }">
                                        <button type="submit" @click="loading = true" :disabled="loading" class="btn-primary shadow-lg shadow-brand-500/30 flex items-center gap-2 btn-loading-wrapper">
                                            <div class="btn-spinner" :class="{ 'loading': loading }">
                                                <div class="spinner-mini"></div>
                                            </div>
                                            <div class="flex items-center gap-2 btn-loading-text" :class="{ 'loading': loading }">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                Save Pricing Settings
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- EMAIL TAB -->
                        <div x-show="tab === 'email'" x-transition style="display: none;">
                            <div class="mb-8 border-b border-slate-100 pb-5 flex justify-between items-end">
                                <div>
                                    <h3 class="text-lg font-bold text-slate-900 font-outfit">SMTP Configuration</h3>
                                    <p class="text-sm text-slate-500 mt-1">Configure your outgoing email server for notifications and quote alerts.</p>
                                </div>
                                <form action="{{ route('admin.settings.test-email') }}" method="POST" x-data="{ loading: false }">
                                    @csrf
                                    <button type="submit" @click="loading = true" :disabled="loading" class="text-[10px] font-bold uppercase tracking-widest px-4 py-2 rounded-lg border border-brand-500 text-brand-700 hover:bg-brand-50 transition-all btn-loading-wrapper min-w-[140px]">
                                        <div class="btn-spinner" :class="{ 'loading': loading }">
                                            <div class="spinner-mini !border-brand-500 !border-b-transparent"></div>
                                        </div>
                                        <div class="btn-loading-text" :class="{ 'loading': loading }">
                                            Send Test Email
                                        </div>
                                    </button>
                                </form>
                            </div>

                            <form action="{{ route('admin.settings.update') }}" method="POST">
                                @csrf
                                <div class="grid md:grid-cols-2 gap-8">
                                    <!-- Connection Details -->
                                    <div class="space-y-6">
                                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-2">Server Connection</h4>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">SMTP Host</label>
                                            <input type="text" name="mail_host" value="{{ $settings['mail_host']->value ?? '' }}" placeholder="smtp.mailtrap.io" class="input-premium w-full text-sm">
                                        </div>
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">SMTP Port</label>
                                                <input type="number" name="mail_port" value="{{ $settings['mail_port']->value ?? '587' }}" class="input-premium w-full text-sm">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Encryption</label>
                                                <select name="mail_encryption" class="input-premium w-full text-sm">
                                                    <option value="tls" {{ ($settings['mail_encryption']->value ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                                                    <option value="ssl" {{ ($settings['mail_encryption']->value ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                                                    <option value="null" {{ ($settings['mail_encryption']->value ?? '') === 'null' ? 'selected' : '' }}>None</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Authentication Username</label>
                                            <input type="text" name="mail_username" value="{{ $settings['mail_username']->value ?? '' }}" class="input-premium w-full text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Authentication Password</label>
                                            <input type="password" name="mail_password" value="{{ $settings['mail_password']->value ?? '' }}" class="input-premium w-full text-sm">
                                        </div>
                                    </div>

                                    <!-- Sender Details -->
                                    <div class="space-y-6">
                                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-2">Sender Identity</h4>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">From Email Address</label>
                                            <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address']->value ?? '' }}" placeholder="no-reply@haalandlogistics.com" class="input-premium w-full text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">From Display Name</label>
                                            <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name']->value ?? '' }}" placeholder="Haaland Logistics" class="input-premium w-full text-sm">
                                        </div>

                                        <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl mt-4">
                                            <p class="text-[10px] text-amber-700 font-bold leading-relaxed uppercase tracking-tight">
                                                <svg class="w-4 h-4 inline mr-1 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                                Important Note
                                            </p>
                                            <p class="text-[10px] text-amber-600 mt-1">These settings override the system .env configuration. Incorrect values will stop all email notifications immediately.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-10 flex justify-end" x-data="{ loading: false }">
                                    <button type="submit" @click="loading = true" :disabled="loading" class="btn-primary shadow-lg shadow-brand-500/30 flex items-center gap-2 btn-loading-wrapper">
                                        <div class="btn-spinner" :class="{ 'loading': loading }">
                                            <div class="spinner-mini"></div>
                                        </div>
                                        <div class="flex items-center gap-2 btn-loading-text" :class="{ 'loading': loading }">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Save Email Settings
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>
