<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <!-- LEFT: SCROLLABLE CMS CONTROL PANEL -->
    <div class="w-full lg:w-[650px] h-full overflow-y-auto p-8 lg:p-10 border-r border-slate-200 scroll-smooth">
        <header class="mb-8">
            <h2 class="font-serif text-3xl font-bold italic text-[#1A365D]">Project Portfolio</h2>
            <p class="text-slate-400 text-[9px] mt-1 font-bold uppercase tracking-widest">Advocacy Initiatives & Detailed Case Studies</p>
            
            @if (session()->has('message'))
                <div class="mt-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    {{ session('message') }}
                </div>
            @endif
        </header>

        <form wire:submit.prevent="save" class="space-y-10 pb-28">
            
            <!-- SECTION 1: HERO -->
            <div data-section="projects-hero" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Hero Header</h3>
                </div>

                @include('livewire.partials.trilingual-input', ['label' => 'Top Label', 'key' => 'pj_hero_label'])
                @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 1', 'key' => 'pj_hero_title1'])
                @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 2 (Gradient / Italic)', 'key' => 'pj_hero_title2'])
                @include('livewire.partials.trilingual-input', ['label' => 'Hero Description', 'key' => 'pj_hero_desc'])
            </div>

            <!-- SECTION 2: 4 PROJECTS REPEATER -->
            <div data-section="projects-grid" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Strategic Projects (4 Cards + Detailed Modals)</h3>
                </div>

                @for($p = 1; $p <= 4; $p++)
                    <div 
                        data-card="{{ $p }}" 
                        class="p-5 bg-slate-50 rounded-3xl border border-slate-200/70 space-y-4 transition-all hover:bg-pink-50/30"
                    >
                        <div class="flex items-center justify-between border-b border-slate-200/60 pb-2">
                            <span class="text-[10px] font-black text-[#1A365D] uppercase tracking-widest">
                                Project 0{{ $p }} Card &amp; Case Study
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @include('livewire.partials.trilingual-input', ['label' => 'Category Badge', 'key' => "pj_{$p}_cat"])
                            @include('livewire.partials.trilingual-input', ['label' => 'Phase / Status Badge', 'key' => "pj_{$p}_status"])
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @include('livewire.partials.trilingual-input', ['label' => 'Title Part 1', 'key' => "pj_{$p}_title1"])
                            @include('livewire.partials.trilingual-input', ['label' => 'Title Part 2 (Gradient)', 'key' => "pj_{$p}_title2"])
                        </div>

                        @include('livewire.partials.trilingual-input', ['label' => 'Short Card Summary', 'key' => "pj_{$p}_desc"])

                        <!-- DETAILED MODAL STORY -->
                        <div class="space-y-2 pt-2 border-t border-slate-200/60">
                            <label class="text-[9px] font-black text-pink-600 uppercase tracking-widest block">
                                Comprehensive Case Study (Visible inside Modal)
                            </label>
                            <textarea wire:model.live.debounce.300ms="state.pj_{{ $p }}_long_desc.en" placeholder="Detailed English Project Story & Milestones..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-24 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                            <textarea wire:model.live.debounce.300ms="state.pj_{{ $p }}_long_desc.si" placeholder="සිංහල විස්තරය..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                            <textarea wire:model.live.debounce.300ms="state.pj_{{ $p }}_long_desc.ta" placeholder="தமிழ் விளக்கம்..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                        </div>

                        <!-- 3 GALLERY IMAGES PER PROJECT -->
                        <div class="pt-2 border-t border-slate-200/60">
                            <label class="text-[9px] font-bold text-slate-500 uppercase tracking-wider block mb-2">
                                Photo Gallery (3 Photos for Viewer &amp; Modal)
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                                @for($img = 1; $img <= 3; $img++)
                                    <div class="p-2 bg-white rounded-xl border border-slate-200">
                                        <label class="text-[8px] font-bold text-slate-400 uppercase block mb-1">Image 0{{ $img }}</label>
                                        <input type="file" wire:model="images.pj_{{ $p }}_img{{ $img }}" class="text-[9px] w-full">
                                        @if(!empty($existing["pj_{$p}_img{$img}"]))
                                            <span class="text-[8px] text-emerald-600 font-semibold block mt-1">✓ Saved</span>
                                        @endif
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- SECTION 3: CTA -->
            <div data-section="projects-cta" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">03. Collaboration CTA Banner</h3>
                </div>

                @include('livewire.partials.trilingual-input', ['label' => 'Banner Headline', 'key' => 'pj_cta_title'])
                @include('livewire.partials.trilingual-input', ['label' => 'Banner Description', 'key' => 'pj_cta_desc'])
            </div>

            <!-- STICKY PUBLISH BUTTON -->
            <div class="sticky bottom-6 z-30">
                <button type="submit" class="w-full bg-[#1A365D] text-white py-4 rounded-full font-bold text-xs uppercase tracking-[0.25em] shadow-xl hover:shadow-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all">
                    Publish Projects Portfolio
                </button>
            </div>
        </form>
    </div>

    <!-- RIGHT: PREVIEW (IFRAME) -->
   <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/projects'" />
    <!-- DELEGATED LIVE SCROLL & PREVIEW SCRIPT -->
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

        function sendModalAction(action, cardIndex = null) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;

            if (action === 'OPEN') {
                iframe.contentWindow.postMessage({
                    type: 'TET_OPEN_MODAL',
                    id: cardIndex
                }, '*');
            } else if (action === 'CLOSE') {
                iframe.contentWindow.postMessage({
                    type: 'TET_CLOSE_MODAL'
                }, '*');
            }
        }

        function handleInteraction(e) {
            const cardItem = e.target.closest('[data-card]');

            // 1. If clicked or focused inside a Project Card -> Open its modal
            if (cardItem) {
                const cardIdx = parseInt(cardItem.getAttribute('data-card'), 10);
                sendScroll('projects-grid', cardIdx);
                sendModalAction('OPEN', cardIdx);
                return;
            }

            // 2. Clicked or focused ANYWHERE ELSE -> Close the modal!
            sendModalAction('CLOSE');

            const sectionContainer = e.target.closest('[data-section]');
            if (sectionContainer) {
                sendScroll(sectionContainer.getAttribute('data-section'));
            }
        }

        // Delegated Focus & Click listeners
        document.addEventListener('focusin', handleInteraction);
        document.addEventListener('click', handleInteraction);

        // When Livewire updates values
        window.addEventListener('content-updated', function(event) {
            const iframe = getIframe();
            const detail = event.detail?.[0] || event.detail;

            if (iframe && iframe.contentWindow && detail?.state) {
                iframe.contentWindow.postMessage({
                    type: 'TET_LIVE_PREVIEW',
                    state: detail.state
                }, '*');

                if (detail.cardIndex) {
                    sendModalAction('OPEN', detail.cardIndex);
                }
            }
        });
    })();
    </script>

</div>