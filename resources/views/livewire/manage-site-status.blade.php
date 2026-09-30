@php
    $front = $this->frontendUrl;
    $sitePreview = $front . '/?tet_preview=' . $previewKey;
    $csPreview = $front . '/coming-soon?tet_preview=' . $previewKey;
@endphp
<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">

    <!-- LEFT: CONTROLS -->
    <div class="w-full lg:w-[620px] h-full overflow-y-auto p-8 lg:p-10 border-r border-slate-200">
        <header class="mb-6">
            <h2 class="font-serif text-3xl font-bold italic text-[#1A365D]">Site Status</h2>
            <p class="text-slate-400 text-[9px] mt-1 font-bold uppercase tracking-widest">Coming Soon mode &amp; search engine visibility</p>
        </header>

        @if (session()->has('status'))
            <div class="mb-5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">{{ session('status') }}</div>
        @endif

        <!-- SWITCHES -->
        <div class="space-y-3 mb-8">
            <div class="p-5 rounded-3xl border-2 {{ $comingSoon ? 'border-amber-300 bg-amber-50/60' : 'border-slate-100 bg-white' }} shadow-sm flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-[#1A365D]">🚧 Coming Soon mode</h3>
                    <p class="text-xs text-slate-500 mt-1">
                        @if($comingSoon)
                            <b class="text-amber-700">ON</b> — every visitor sees the Coming Soon page. You can still view the real site with your preview link below.
                        @else
                            <b class="text-emerald-700">OFF</b> — the full website is live for everyone.
                        @endif
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" wire:model.live="comingSoon" class="sr-only peer">
                    <div class="w-12 h-7 bg-slate-200 rounded-full peer peer-checked:bg-amber-500 transition-colors after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            <div class="p-5 rounded-3xl border-2 {{ $noindex ? 'border-pink-300 bg-pink-50/60' : 'border-slate-100 bg-white' }} shadow-sm flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-[#1A365D]">🔍 Hide from search engines <span class="font-mono text-[10px] text-slate-400">noindex, nofollow</span></h3>
                    <p class="text-xs text-slate-500 mt-1">
                        @if($noindex)
                            <b class="text-pink-700">ON</b> — Google and others are told not to list any page or follow links (meta robots, X-Robots-Tag header and robots.txt).
                        @else
                            <b class="text-emerald-700">OFF</b> — search engines can index the website normally.
                        @endif
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" wire:model.live="noindex" class="sr-only peer">
                    <div class="w-12 h-7 bg-slate-200 rounded-full peer peer-checked:bg-pink-500 transition-colors after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            <!-- PREVIEW LINKS -->
            <div class="p-5 rounded-3xl border border-slate-100 bg-white shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-[#1A365D]">🔑 Private preview links</h3>
                <p class="text-xs text-slate-500">Share these with your team to see the site while Coming Soon is on. The link remembers the browser for 30 days.</p>
                @foreach(['Real website' => $sitePreview, 'Coming Soon page' => $csPreview] as $label => $link)
                    <div class="flex items-center gap-2" x-data="{ copied: false }">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 w-32 shrink-0">{{ $label }}</span>
                        <input type="text" readonly value="{{ $link }}" class="flex-1 min-w-0 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-[11px] font-mono text-slate-600">
                        <button type="button" x-on:click="navigator.clipboard.writeText(@js($link)); copied = true; setTimeout(() => copied = false, 1500)"
                            class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-[10px] font-bold text-[#1A365D] cursor-pointer" x-text="copied ? 'Copied' : 'Copy'"></button>
                        <a href="{{ $link }}" target="_blank" class="px-3 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-[10px] font-bold text-[#1A365D]">Open ↗</a>
                    </div>
                @endforeach
                <button type="button" wire:click="regenerateKey" wire:confirm="Create a new preview link? Old links will stop working."
                    class="text-[10px] font-bold text-red-500 hover:underline cursor-pointer">Create new link (revoke old ones)</button>
            </div>
        </div>

        <!-- COMING SOON CONTENT -->
        <form wire:submit.prevent="save" class="space-y-5 pb-28">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">Coming Soon page content</h3>
            </div>

            <div class="p-5 bg-white rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Contact email</label>
                            <input type="email" wire:model="contactEmail" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-[#1A365D]">
                            @error('contactEmail') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Contact / hotline number</label>
                            <input type="text" wire:model="contactPhone" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-[#1A365D]">
                        </div>
                </div>
            </div>

            @foreach(\App\Livewire\ManageSiteStatus::TEXT_FIELDS as $key => $meta)
                @php [$label, $isLong] = $meta; @endphp
                <div wire:key="cs-{{ $key }}" class="p-4 bg-white rounded-2xl border border-slate-100 shadow-sm space-y-2">
                    <p class="text-xs font-semibold text-[#1A365D]">{{ $label }}</p>
                    @foreach(['en' => ['English', 'EN', 'bg-sky-100 text-sky-800'], 'si' => ['සිංහල', 'SI', 'bg-amber-100 text-amber-800'], 'ta' => ['தமிழ்', 'TA', 'bg-emerald-100 text-emerald-800']] as $lang => $l)
                        <div class="flex items-start gap-3">
                            <span class="shrink-0 w-20 mt-2 inline-flex items-center gap-1.5">
                                <span class="text-[9px] font-black px-1.5 py-0.5 rounded {{ $l[2] }}">{{ $l[1] }}</span>
                                <span class="text-[11px] font-semibold text-slate-500">{{ $l[0] }}</span>
                            </span>
                            <textarea wire:model="texts.{{ $key }}.{{ $lang }}" rows="{{ $isLong ? 3 : 1 }}"
                                placeholder="{{ $lang === 'en' ? 'English text' : 'Leave empty to show the English text' }}"
                                x-data x-init="$el.style.height = ''; $el.style.height = $el.scrollHeight + 'px'"
                                x-on:input="$el.style.height = ''; $el.style.height = $el.scrollHeight + 'px'"
                                class="flex-1 min-h-[40px] resize-none overflow-hidden bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm leading-relaxed outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]"></textarea>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="sticky bottom-6 z-30">
                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                    class="w-full bg-[#1A365D] hover:bg-slate-800 disabled:opacity-50 text-white py-4 rounded-full font-bold text-xs uppercase tracking-[0.25em] shadow-xl cursor-pointer">
                    <span wire:loading.remove wire:target="save">Save Coming Soon Page</span>
                    <span wire:loading wire:target="save">Saving…</span>
                </button>
            </div>
        </form>
    </div>

    <!-- RIGHT: LIVE PREVIEW OF THE COMING SOON PAGE -->
    <x-preview-panel :url="$csPreview" />
</div>
