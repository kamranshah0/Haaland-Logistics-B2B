@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-4 px-4 py-3.5 bg-brand-800 text-white font-bold border-l-4 border-accent-500 rounded-r-2xl transition-all shadow-lg no-underline'
            : 'flex items-center gap-4 px-4 py-3.5 text-slate-300 hover:text-white hover:bg-white/5 font-medium border-l-4 border-transparent hover:border-white/10 transition-all rounded-r-2xl no-underline';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
        </svg>
    @endif
    <span class="text-sm tracking-tight">{{ $slot }}</span>
</a>
