<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <!-- LEFT: SCROLLABLE EDITOR -->
    <div class="w-full lg:w-[650px] h-full overflow-y-auto p-8 lg:p-10 border-r border-slate-200 scroll-smooth">
        <header class="mb-8">
            <h2 class="font-serif text-3xl font-bold italic text-[#1A365D]">Services & Protocols</h2>
            <p class="text-slate-400 text-[9px] mt-1 font-bold uppercase tracking-widest">Management of Care Infrastructure & Emergency Services</p>
            
            @if (session()->has('message'))
                <div class="mt-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    {{ session('message') }}
                </div>
            @endif
        </header>

        <form wire:submit.prevent="save" class="space-y-10 pb-28">
            
            <!-- SECTION 1: HERO -->
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
                    <input type="file" wire:model="hero_bg" class="text-[10px] w-full">
                    @if(!empty($existing['hero_bg']))
                        <p class="text-[8px] text-slate-400 mt-1">Current: {{ $existing['hero_bg'] }}</p>
                    @endif
                </div>
            </div>

            <!-- SECTION 2: 6 SERVICE CARDS -->
            <div data-section="services-grid" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                <div class="flex items-center gap-3 mb-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">02. Service Cards (6 Pillars)</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4 border-b border-slate-100">
                    @include('livewire.partials.trilingual-input', ['label' => 'Card Action Button Text', 'key' => 'btn_request'])
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Button Link URL</label>
                        <input type="text" wire:model.live.debounce.300ms="urls.btn_request_url" placeholder="/contact" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-pink-400">
                    </div>
                </div>

                @for($i=1; $i<=6; $i++)
                    <div 
                        data-card="{{ $i }}"
                        class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3 transition-all hover:bg-pink-50/30"
                    >
                        <div class="flex items-center justify-between">
                            <p class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest">Card 0{{$i}}</p>
                            @if(!empty($existing["service_{$i}_img"]))
                                <span class="text-[8px] font-bold text-slate-400">Image uploaded</span>
                            @endif
                        </div>

                        @include('livewire.partials.trilingual-input', ['label' => 'Category Tag', 'key' => "service_{$i}_tag"])
                        @include('livewire.partials.trilingual-input', ['label' => 'Service Title', 'key' => "service_{$i}_title"])
                        @include('livewire.partials.trilingual-input', ['label' => 'Service Description', 'key' => "service_{$i}_desc"])

                        <div>
                            <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Card Photo</label>
                            <input type="file" wire:model="service_images.{{$i}}" class="text-[10px] w-full">
                        </div>
                    </div>
                @endfor
            </div>

            <!-- SECTION 3: SUPPORT PROCESS (3 STEPS) -->
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

            <!-- SECTION 4: EMERGENCY CRISIS CTA -->
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

            <!-- STICKY ACTION BUTTON -->
            <div class="sticky bottom-6 z-30">
                <button type="submit" class="w-full bg-[#1A365D] text-white py-4 rounded-full font-bold text-xs uppercase tracking-[0.25em] shadow-xl hover:shadow-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all">
                    Publish Services Page
                </button>
            </div>
        </form>
    </div>

    <!-- RIGHT: PREVIEW (IFRAME) -->
    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/services'" />
    <!-- DELEGATED LIVE SCROLL SCRIPT -->
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

        // Delegated Focus & Click listeners (survives Livewire DOM morphing)
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

        window.addEventListener('reload-settings', function() {
            const iframe = getIframe();
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.postMessage({ type: 'TET_RELOAD_SETTINGS' }, '*');
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
    })();
    </script>
</div>