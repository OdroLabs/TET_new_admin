<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">Projects Page</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Advocacy Initiatives &amp; Detailed Case Studies</p>
            </div>
            
            <button 
                type="submit" 
                form="projects-form"
                wire:loading.attr="disabled"
                wire:target="save, images"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save, images">
                    Publish Projects →
                </span>
                <span wire:loading wire:target="save">
                    Publishing...
                </span>
                <span wire:loading wire:target="images">
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

            <form id="projects-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
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

                <div data-section="projects-grid" class="editor-section p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm flex items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                            <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Project Cards</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Add, edit, reorder or hide any number of projects in the Projects Manager.</p>
                    </div>
                    <a href="/admin/project-list" class="shrink-0 bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest">Open Manager →</a>
                </div>

                <div data-section="projects-cta" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">03. Collaboration CTA Banner</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Banner Headline', 'key' => 'pj_cta_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Banner Description', 'key' => 'pj_cta_desc'])
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/projects'" />

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

            if (cardItem) {
                const cardIdx = parseInt(cardItem.getAttribute('data-card'), 10);
                sendScroll('projects-grid', cardIdx);
                sendModalAction('OPEN', cardIdx);
                return;
            }

            sendModalAction('CLOSE');

            const sectionContainer = e.target.closest('[data-section]');
            if (sectionContainer) {
                sendScroll(sectionContainer.getAttribute('data-section'));
            }
        }

        document.addEventListener('focusin', handleInteraction);
        document.addEventListener('click', handleInteraction);

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