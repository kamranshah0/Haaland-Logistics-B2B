@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-white border border-slate-200 rounded-xl px-4 py-3 text-slate-900 focus:border-brand-700 focus:ring-1 focus:ring-brand-700 hover:border-slate-300 outline-none transition-all shadow-sm']) }}>
