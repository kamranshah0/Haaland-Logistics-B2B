<x-app-layout>
    <x-slot name="header">
        {{ __('User Management') }}
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-up">
            <div class="premium-card">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Total Users</p>
                <p class="text-3xl font-bold font-outfit text-slate-900">{{ $users->total() }}</p>
            </div>
            <div class="premium-card">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Pending Approval</p>
                <p class="text-3xl font-bold font-outfit text-brand-700">{{ $users->where('status', 'pending')->count() }}</p>
            </div>
            <div class="premium-card">
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-1">Active Status</p>
                <div class="w-full bg-slate-100 h-2 rounded-full mt-3 overflow-hidden border border-slate-200">
                    <div class="bg-brand-700 h-full w-[100%]"></div>
                </div>
            </div>
        </div>

        <!-- Users Table Card -->
        <div class="premium-card !p-0 overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s">
            <div class="p-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center bg-slate-50/50 gap-4">
                <h3 class="text-lg font-bold text-slate-900 font-outfit uppercase tracking-widest">Registered Clients</h3>
                <form action="{{ route('admin.users') }}" method="GET" class="flex flex-wrap items-center gap-3">
                    <select name="company" onchange="this.form.submit()" class="input-premium py-2 text-sm !bg-white">
                        <option value="">All Companies</option>
                        @foreach($companies as $company)
                            <option value="{{ $company }}" {{ request('company') == $company ? 'selected' : '' }}>{{ $company }}</option>
                        @endforeach
                    </select>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search accounts..." class="input-premium py-2 text-sm w-64 !bg-white">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-brand-900 text-white text-[10px] uppercase tracking-widest font-bold">
                            <th class="px-6 py-4">
                                <a href="{{ route('admin.users', array_merge(request()->query(), ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1 hover:text-brand-200">
                                    Client Detail
                                    @if(request('sort') == 'name')
                                        <svg class="w-3 h-3 {{ request('direction') == 'asc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4">
                                <a href="{{ route('admin.users', array_merge(request()->query(), ['sort' => 'company_name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1 hover:text-brand-200">
                                    Company
                                    @if(request('sort') == 'company_name')
                                        <svg class="w-3 h-3 {{ request('direction') == 'asc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4">
                                <a href="{{ route('admin.users', array_merge(request()->query(), ['sort' => 'status', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1 hover:text-brand-200">
                                    Status
                                    @if(request('sort') == 'status')
                                        <svg class="w-3 h-3 {{ request('direction') == 'asc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4">
                                <a href="{{ route('admin.users', array_merge(request()->query(), ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1 hover:text-brand-200">
                                    Registered
                                    @if(request('sort', 'created_at') == 'created_at')
                                        <svg class="w-3 h-3 {{ request('direction', 'desc') == 'asc' ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    @endif
                                </a>
                            </th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 italic">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50 transition-colors group">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-brand-700/10 border border-brand-700/20 flex items-center justify-center font-bold text-brand-700 shadow-sm">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900">{{ $user->name }}</p>
                                            <p class="text-xs text-slate-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-sm font-bold text-slate-700">{{ $user->company_name ?? 'N/A' }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase font-medium">{{ $user->phone ?? 'No phone' }}</p>
                                </td>
                                <td class="px-6 py-5">
                                    @if($user->status === 'pending')
                                        <span class="px-2 py-1 rounded bg-amber-50 text-amber-700 text-[10px] font-bold uppercase border border-amber-100">Pending</span>
                                    @elseif($user->status === 'approved')
                                        <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase border border-emerald-100">Approved</span>
                                    @elseif($user->status === 'paused')
                                        <span class="px-2 py-1 rounded bg-slate-50 text-slate-700 text-[10px] font-bold uppercase border border-slate-100">Paused</span>
                                    @else
                                        <span class="px-2 py-1 rounded bg-red-50 text-red-700 text-[10px] font-bold uppercase border border-red-100">{{ $user->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-5">
                                    <p class="text-xs text-slate-500 font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @if($user->status !== 'approved')
                                            <form action="{{ route('admin.users.approve', $user) }}" method="POST" title="Approve">
                                                @csrf
                                                <button class="bg-emerald-600 text-white p-2 rounded hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                        @if($user->status === 'approved')
                                            <form action="{{ route('admin.users.pause', $user) }}" method="POST" title="Pause">
                                                @csrf
                                                <button class="bg-amber-500 text-white p-2 rounded hover:bg-amber-600 transition-all shadow-lg shadow-amber-500/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                        @if($user->status !== 'rejected')
                                            <form action="{{ route('admin.users.reject', $user) }}" method="POST" title="Reject">
                                                @csrf
                                                <button class="bg-red-600 text-white p-2 rounded hover:bg-red-700 transition-all shadow-lg shadow-red-500/20">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
