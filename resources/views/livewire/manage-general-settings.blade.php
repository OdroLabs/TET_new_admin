<div class="flex h-full flex-col lg:flex-row overflow-hidden bg-[#FDFCF9]">
    
    <!-- LEFT: THE FORM -->
    <div class="w-full lg:w-[480px] overflow-y-auto p-10 border-r border-slate-200">
        <header class="mb-12">
            <h2 class="font-serif text-4xl text-[#1A365D] font-bold italic">Identity</h2>
            <p class="text-slate-400 text-xs mt-2 font-medium tracking-wide uppercase">Manage the trilingual voice of the Trust</p>
        </header>

        <form wire:submit.prevent="save" class="space-y-12">
            
            <div class="space-y-8">
                <div class="flex items-center gap-3">
                    <span class="w-2 h-2 rounded-full bg-pink-400"></span>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.2em] text-[#1A365D]">Main Hero Headline</h3>
                </div>

                <div class="space-y-5">
                    <div class="group">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-1 block">English (Primary)</label>
                        <input wire:model.live.debounce.500ms="title_en" type="text" 
                               class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#1A365D] focus:border-transparent outline-none transition-all shadow-sm group-hover:border-slate-300 text-sm font-medium">
                    </div>

                    <div class="group">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-1 block text-blue-500">Sinhala (සිංහල)</label>
                        <input wire:model.live.debounce.500ms="title_si" type="text" 
                               class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#1A365D] focus:border-transparent outline-none transition-all shadow-sm group-hover:border-slate-300 text-sm font-medium">
                    </div>

                    <div class="group">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-4 mb-1 block text-pink-500">Tamil (தமிழ்)</label>
                        <input wire:model.live.debounce.500ms="title_ta" type="text" 
                               class="w-full bg-white border border-slate-200 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#1A365D] focus:border-transparent outline-none transition-all shadow-sm group-hover:border-slate-300 text-sm font-medium">
                    </div>
                </div>
            </div>

            <div class="pt-6">
                <button type="submit" class="w-full bg-[#1A365D] text-white py-5 rounded-full font-bold text-[10px] uppercase tracking-widest shadow-xl hover:shadow-[#1A365D]/40 hover:-translate-y-1 transition-all duration-300 active:scale-95">
                    Publish Changes
                </button>
            </div>

            <!-- SUCCESS MESSAGE: Fixed with Alpine.js -->
            @if (session()->has('message'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition.opacity
                     class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl text-[10px] font-black tracking-widest text-center border border-emerald-100 uppercase">
                    {{ session('message') }}
                </div>
            @endif
        </form>
    </div>

    <!-- RIGHT: PREVIEW -->
    <!-- RIGHT: PREVIEW -->
<div class="flex-1 bg-slate-50 p-12 flex flex-col items-center relative overflow-hidden">
    <div class="w-full max-w-5xl aspect-video bg-white rounded-[3rem] shadow-2xl border-[12px] border-slate-900 overflow-hidden relative z-10">
        <!-- We pass the current Livewire state (title_en) to the Next.js preview page -->
        <iframe src="{{ env('FRONTEND_URL', 'https://tet-frontend.vercel.app') }}/?preview_title={{ urlencode($title_en) }}" class="w-full h-full border-none"></iframe>
    </div>
    <p class="mt-8 text-[10px] font-bold text-slate-400 uppercase tracking-widest italic z-10">
        Live Previewing: {{ $title_en }}
    </p>
</div>
</div>