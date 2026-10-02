<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">Services Page</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Management of Care Infrastructure &amp; Emergency Services</p>
            </div>
            
            <button 
                type="submit" 
                form="services-form"
                wire:loading.attr="disabled"
                wire:target="save, hero_bg"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save, hero_bg">
                    Publish Services →
                </span>
                <span wire:loading wire:target="save">
                    Publishing...
                </span>
                <span wire:loading wire:target="hero_bg">
                    Uploading...
                </span>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-6 lg:p-8 scroll-smooth">
            @if (session()->has('message'))
                <div class="mb-6 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    {{ session('message') }}
                </div>
            @endif

            <form id="services-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
                <div data-section="services-hero" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">01. Hero Header</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Hero Label', 'key' => 's_hero_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Hero Title', 'key' => 's_hero_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Hero Description', 'key' => 's_hero_desc'])

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Hero Background Image</label>
                        
                        @if ($hero_bg)
                            <div class="mb-2">
                                <span class="text-[8px] text-blue-600 font-bold block mb-1">New Image Preview:</span>
                                <img src="{{ $hero_bg->temporaryUrl() }}" class="w-24 h-16 object-cover rounded-xl border border-blue-300">
                            </div>
                        @elseif(!empty($existing['hero_bg']))
                            <div class="mb-2">
                                <span class="text-[8px] text-emerald-600 font-bold block mb-1">✓ Saved Image:</span>
                                <img src="{{ \App\Support\Media::url($existing['hero_bg']) }}" class="w-24 h-16 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif

                        <input type="file" wire:model="hero_bg" class="text-[10px] w-full">
                        
                        <div wire:loading wire:target="hero_bg" class="text-[9px] text-blue-600 font-semibold mt-1">
                            Uploading image, please wait...
                        </div>
                        @error('hero_bg') 
                            <span class="text-[9px] text-red-500 font-bold block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <div data-section="services-grid" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">02. Service Cards</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 border-b border-slate-100">
                        @include('livewire.partials.trilingual-input', ['label' => 'Card Action Button Text', 'key' => 'btn_request'])
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Button Link URL</label>
                            <input type="text" wire:model.live.debounce.300ms="urls.btn_request_url" placeholder="/contact" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-pink-400">
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-4 p-4 bg-pink-50/50 rounded-2xl border border-pink-100">
                        <p class="text-xs text-slate-600">Add, edit, reorder or hide service cards in the Services Manager.</p>
                        <a href="/admin/service-list" class="shrink-0 bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest">Open Manager →</a>
                    </div>
                </div>

                <div data-section="services-process" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">03. Support Process (3 Steps)</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Label', 'key' => 's_process_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Section Title', 'key' => 's_process_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Section Description', 'key' => 's_process_desc'])

                    @for($i=1; $i<=3; $i++)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                            <p class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest">Process Step 0{{$i}}</p>
                            @include('livewire.partials.trilingual-input', ['label' => "Step Title", 'key' => "s_proc_{$i}_title"])
                            @include('livewire.partials.trilingual-input', ['label' => "Step Instructions", 'key' => "s_proc_{$i}_text"])
                        </div>
                    @endfor
                </div>

                <div data-section="services-emergency" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-red-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">04. Emergency Crisis Intervention</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Urgency Badge', 'key' => 's_emergency_badge'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Emergency Title', 'key' => 's_emergency_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Emergency Description', 'key' => 's_emergency_desc'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Hotline / Phone Number', 'key' => 's_emergency_phone'])
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/services'" />

    <script>
    (function() {
        const getIframe = () => document.getElementById('preview-iframe');

        function sendScroll(sectionId, cardIndex = null) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;

            iframe.contentWindow.postMessage({
                type: 'TET_SCROLL_TO_SECTION',
                sectionId: sectionId,
                cardIndex: cardIndex
            }, '*');
        }

        document.addEventListener('focusin', function(e) {
            const container = e.target.closest('[data-section]');
            if (container) {
                const sectionId = container.getAttribute('data-section');
                const cardItem = e.target.closest('[data-card]');
                const cardIdx = cardItem ? parseInt(cardItem.getAttribute('data-card'), 10) : null;
                sendScroll(sectionId, cardIdx);
            }
        });

        document.addEventListener('click', function(e) {
            const container = e.target.closest('[data-section]');
            if (container) {
                const sectionId = container.getAttribute('data-section');
                const cardItem = e.target.closest('[data-card]');
                const cardIdx = cardItem ? parseInt(cardItem.getAttribute('data-card'), 10) : null;
                sendScroll(sectionId, cardIdx);
            }
        });

        window.addEventListener('content-updated', function(event) {
            const iframe = getIframe();
            const detail = event.detail?.[0] || event.detail;

            if (iframe && iframe.contentWindow && detail?.state) {
                iframe.contentWindow.postMessage({
                    type: 'TET_LIVE_PREVIEW',
                    state: detail.state
                }, '*');

                if (detail.targetSection) {
                    sendScroll(detail.targetSection, detail.cardIndex);
                }
            }
        });

        window.addEventListener('settings-published', function(event) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;

            iframe.contentWindow.postMessage({ type: 'TET_RELOAD_SETTINGS' }, '*');

            const detail = event.detail?.[0] || event.detail;
            if (detail?.state) {
                iframe.contentWindow.postMessage({
                    type: 'TET_LIVE_PREVIEW',
                    state: detail.state
                }, '*');
            }
        });
    })();
    </script>
</div>