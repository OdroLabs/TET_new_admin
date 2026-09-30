<div class="h-screen overflow-y-auto bg-[#FDFCF9]">
    <div class="p-8 lg:p-10 max-w-5xl">
        <header class="mb-6">
            <h2 class="font-serif text-3xl font-bold italic text-[#1A365D]">Site Wording</h2>
            <p class="text-slate-400 text-[9px] mt-1 font-bold uppercase tracking-widest">
                Every text, button label, image and search-result text on the website — in English, සිංහල &amp; தமிழ்
            </p>
            <p class="text-xs text-slate-500 mt-3 max-w-2xl">
                Empty Sinhala / Tamil fields show the English text. Lists such as projects, services, events,
                products and news have their own managers; the Home impact cards are edited on the Home Page screen.
            </p>
        </header>

        @if (session()->has('message'))
            <div class="mb-5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                {{ session('message') }}
            </div>
        @endif

        <!-- SEARCH + TABS -->
        <div class="sticky top-0 z-20 bg-[#FDFCF9] pb-4 space-y-3">
            <input type="search" wire:model.live.debounce.300ms="search"
                placeholder="Search all wording (e.g. “Donate”, “hotline”, a key name)…"
                class="w-full bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-[#1A365D]/30">

            @if(trim($search) === '')
                <div class="flex flex-wrap gap-1.5">
                    @foreach(\App\Livewire\ManageSiteWording::GROUPS as $g => $label)
                        <button type="button" wire:click="$set('group', '{{ $g }}')"
                            class="px-3 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-wider cursor-pointer transition-all
                                {{ $group === $g ? 'bg-[#1A365D] text-white shadow' : 'bg-white text-slate-500 border border-slate-200 hover:border-[#1A365D]/40' }}">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            @else
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ count($this->items) }} result(s) across all pages</p>
            @endif
        </div>

        <form wire:submit.prevent="save" class="space-y-3 pb-32">
            @forelse($this->items as $item)
                @php
                    $k = $item['key'];
                    $long = mb_strlen($item['en']) > 90;
                    $changed = ($values[$k] ?? null) != ($original[$k] ?? null);
                @endphp
                <div wire:key="w-{{ $k }}" class="p-4 bg-white rounded-2xl border {{ $changed ? 'border-amber-300 ring-1 ring-amber-200' : 'border-slate-100' }} shadow-sm space-y-2">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-[#1A365D] leading-snug">{{ \Illuminate\Support\Str::limit($item['en'], 110) }}</p>
                            <p class="text-[9px] font-mono text-slate-400 mt-0.5">
                                {{ $k }}
                                @if(trim($search) !== '') · {{ \App\Livewire\ManageSiteWording::GROUPS[$item['group']] ?? $item['group'] }} @endif
                            </p>
                        </div>
                        <span class="shrink-0 text-[8px] font-black uppercase tracking-widest px-2 py-0.5 rounded-full
                            {{ $item['kind'] === 'text' ? 'bg-sky-50 text-sky-700' : ($item['kind'] === 'image' ? 'bg-pink-50 text-pink-700' : 'bg-slate-100 text-slate-500') }}">
                            {{ $item['kind'] === 'text' ? 'Text · 3 languages' : ($item['kind'] === 'image' ? 'Image' : 'Value') }}
                        </span>
                    </div>

                    @if($item['kind'] === 'text')
                        <div class="space-y-2.5 pt-1">
                            @foreach(['en' => ['English', 'EN', 'bg-sky-100 text-sky-800'], 'si' => ['සිංහල', 'SI', 'bg-amber-100 text-amber-800'], 'ta' => ['தமிழ்', 'TA', 'bg-emerald-100 text-emerald-800']] as $lang => [$langName, $code, $badge])
                                <div class="flex items-start gap-3">
                                    <span class="shrink-0 w-20 mt-2 inline-flex items-center gap-1.5">
                                        <span class="text-[9px] font-black px-1.5 py-0.5 rounded {{ $badge }}">{{ $code }}</span>
                                        <span class="text-[11px] font-semibold text-slate-500">{{ $langName }}</span>
                                    </span>
                                    <textarea wire:model="values.{{ $k }}.{{ $lang }}" rows="1"
                                        placeholder="{{ $lang === 'en' ? 'English text' : 'Leave empty to show the English text' }}"
                                        x-data x-init="$el.style.height = ''; $el.style.height = $el.scrollHeight + 'px'"
                                        x-on:input="$el.style.height = ''; $el.style.height = $el.scrollHeight + 'px'"
                                        class="flex-1 min-h-[40px] resize-none overflow-hidden bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm leading-relaxed outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]"></textarea>
                                </div>
                            @endforeach
                        </div>
                    @elseif($item['kind'] === 'image')
                        <div class="flex items-center gap-3">
                            @if(!empty($uploads[$k]))
                                <img src="{{ $uploads[$k]->temporaryUrl() }}" class="w-20 h-14 object-cover rounded-lg border-2 border-pink-300">
                            @elseif(!empty($values[$k]['en']))
                                <img src="{{ \App\Support\Media::url($values[$k]['en']) }}" class="w-20 h-14 object-cover rounded-lg border border-slate-200">
                            @endif
                            <div class="flex-1 space-y-1.5">
                                <input type="text" wire:model="values.{{ $k }}.en" placeholder="Image URL"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-[11px] outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                                <input type="file" wire:model="uploads.{{ $k }}" accept="image/*" class="text-[10px]">
                                <div wire:loading wire:target="uploads.{{ $k }}" class="text-[9px] text-pink-600 font-semibold">Uploading…</div>
                                @error("uploads.{$k}") <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @else
                        <input type="text" wire:model="values.{{ $k }}.en"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                    @endif
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-2xl border border-dashed border-slate-200 text-xs text-slate-400">Nothing matches your search.</div>
            @endforelse

            <div class="sticky bottom-6 z-30">
                <button type="submit" wire:loading.attr="disabled" wire:target="save, uploads"
                    class="w-full bg-[#1A365D] hover:bg-slate-800 disabled:opacity-50 text-white py-4 rounded-full font-bold text-xs uppercase tracking-[0.25em] shadow-xl cursor-pointer">
                    <span wire:loading.remove wire:target="save, uploads">Save Wording</span>
                    <span wire:loading wire:target="save">Saving…</span>
                    <span wire:loading wire:target="uploads">Uploading image…</span>
                </button>
            </div>
        </form>
    </div>
</div>
