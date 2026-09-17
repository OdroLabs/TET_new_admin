<div class="group space-y-2">
    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">
        {{ $label }}
    </label>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
        <div>
            <input 
                type="text" 
                wire:model.live.debounce.300ms="state.{{ $key }}.en" 
                placeholder="English"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D] transition-all"
            >
        </div>
        <div>
            <input 
                type="text" 
                wire:model.live.debounce.300ms="state.{{ $key }}.si" 
                placeholder="සිංහල"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D] transition-all"
            >
        </div>
        <div>
            <input 
                type="text" 
                wire:model.live.debounce.300ms="state.{{ $key }}.ta" 
                placeholder="தமிழ்"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D] transition-all"
            >
        </div>
    </div>
</div>