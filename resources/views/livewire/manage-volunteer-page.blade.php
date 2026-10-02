<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">Volunteer &amp; Youth Services</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Community Enrollment &amp; Advocacy Protocols</p>
            </div>
            
            <button 
                type="submit" 
                form="volunteer-form"
                wire:loading.attr="disabled"
                wire:target="save, images"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save, images">
                    Publish Volunteer Page →
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

            <form id="volunteer-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
                <div data-section="volunteer-hero" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-sky-900 tracking-wider">01. Hero Section</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Badge / Category Label', 'key' => 'v_hero_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 1 (Regular)', 'key' => 'v_hero_title1'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 2 (Gradient / Italic)', 'key' => 'v_hero_title2'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Hero Description', 'key' => 'v_hero_desc'])
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @include('livewire.partials.trilingual-input', ['label' => 'Primary Button (Registry)', 'key' => 'v_hero_btn1'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Secondary Button (Youth Services)', 'key' => 'v_hero_btn2'])
                    </div>
                    
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="block text-xs font-bold text-slate-600 mb-1">Hero Cover Image</label>
                        <input type="file" wire:model="images.v_hero_img" class="text-xs text-slate-500 w-full">
                        @if(!empty($existing['v_hero_img']))
                            <p class="text-[8px] text-slate-400 mt-1">Current: {{ $existing['v_hero_img'] }}</p>
                        @endif
                    </div>
                </div>

                <div data-section="volunteer-youth" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-pink-900 tracking-wider">02. Youth Services Showcase</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Small Tag', 'key' => 'v_youth_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Section Headline', 'key' => 'v_youth_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Section Intro Description', 'key' => 'v_youth_desc'])
                    
                    @for($i = 1; $i <= 4; $i++)
                        <div 
                            data-card="{{ $i }}" 
                            class="p-4 bg-sky-50/50 rounded-2xl border border-sky-100 space-y-3 transition-all hover:bg-pink-50/40"
                        >
                            <p class="text-[9px] font-black text-sky-800 uppercase tracking-wider">Youth Service Card 0{{ $i }}</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @include('livewire.partials.trilingual-input', ['label' => 'Icon (Emoji)', 'key' => "v_youth_{$i}_icon"])
                                @include('livewire.partials.trilingual-input', ['label' => 'Badge Tag', 'key' => "v_youth_{$i}_tag"])
                            </div>
                            @include('livewire.partials.trilingual-input', ['label' => 'Service Title', 'key' => "v_youth_{$i}_title"])
                            @include('livewire.partials.trilingual-input', ['label' => 'Service Description', 'key' => "v_youth_{$i}_desc"])
                        </div>
                    @endfor
                </div>

                <div data-section="volunteer-form" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-purple-900 tracking-wider">03. Application Form Texts</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Form Header Tag', 'key' => 'v_form_tag'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Form Headline', 'key' => 'v_form_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Form Sub-description', 'key' => 'v_form_desc'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Anti-Stigma Consent Declaration Text', 'key' => 'v_form_consent_text'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Submit Button Label', 'key' => 'v_form_btn'])
                </div>

                <div data-section="volunteer-quote" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-amber-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-amber-900 tracking-wider">04. Institutional Quote</h3>
                    </div>
                    @include('livewire.partials.trilingual-input', ['label' => 'Footer Quote', 'key' => 'v_footer_quote'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Citation', 'key' => 'v_footer_cite'])
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/volunteer'" />

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
    })();
    </script>
</div>