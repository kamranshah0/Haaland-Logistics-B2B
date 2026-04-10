<nav x-data="{ open: false }" class="glass border-b border-white/5 sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-brand-600 rounded flex items-center justify-center font-bold text-white shadow-lg shadow-brand-600/20">H</div>
                        <span class="text-white font-outfit font-bold tracking-tight">HAALAND</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-slate-300 hover:text-white transition-colors">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')
                        <!-- Admin Specific Links -->
                        <x-nav-link :href="route('admin.users')" :active="request()->routeIs('admin.users')" class="text-slate-300 hover:text-white transition-colors">
                            {{ __('Clients') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.rates')" :active="request()->routeIs('admin.rates')" class="text-slate-300 hover:text-white transition-colors">
                            {{ __('Rates') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.departures')" :active="request()->routeIs('admin.departures')" class="text-slate-300 hover:text-white transition-colors">
                            {{ __('Departures') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.external-shipments')" :active="request()->routeIs('admin.external-shipments')" class="text-slate-300 hover:text-white transition-colors">
                            {{ __('Ops Tool') }}
                        </x-nav-link>
                    @else
                        <!-- Client Specific Links -->
                        <x-nav-link :href="route('quotes.index')" :active="request()->routeIs('quotes.index')" class="text-slate-300 hover:text-white transition-colors">
                            {{ __('My Quotes') }}
                        </x-nav-link>
                        <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.index')" class="text-slate-300 hover:text-white transition-colors">
                            {{ __('My Bookings') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-white/10 text-sm leading-4 font-medium rounded-xl text-slate-300 bg-white/5 hover:text-white hover:bg-white/10 focus:outline-none transition ease-in-out duration-150 backdrop-blur-md">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <span class="px-1.5 py-0.5 rounded-md bg-brand-600/20 text-[10px] text-brand-400 font-bold uppercase ml-2 border border-brand-500/20">
                                    {{ Auth::user()->role }}
                                </span>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-brand-600/10">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="hover:bg-red-500/10 text-red-400">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Modified for glass theme) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 focus:outline-none transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
