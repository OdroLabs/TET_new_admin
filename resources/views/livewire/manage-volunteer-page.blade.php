<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <!-- LEFT: SCROLLABLE CMS CONTROL PANEL -->
    <div class="w-full lg:w-[650px] h-full overflow-y-auto p-8 lg:p-10 border-r border-slate-200 scroll-smooth">
        <header class="mb-8">
            <h2 class="font-serif text-3xl text-sky-950 font-bold italic">Volunteer &amp; Youth Services</h2>
            <p class="text-sky-600 text-[9px] mt-1 font-bold uppercase tracking-widest">Community Enrollment & Advocacy Protocols</p>
            
            @if (session()->has('message'))
                <div class="mt-4 p-3 bg-sky-50 border border-sky-200 text-sky-800 text-xs rounded-xl font-semibold">
                    {{ session('message') }}
                </div>
            @endif
        </header>

        <form wire:submit.prevent="save" class="space-y-10 pb-28">
            
            <!-- SECTION 1: HERO -->
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

            <!-- SECTION 2: YOUTH SERVICES -->
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

            <!-- SECTION 3: FORM & CONSENT TEXT -->
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

            <!-- SECTION 4: INSTITUTIONAL QUOTE -->
            <div data-section="volunteer-quote" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-amber-400">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-amber-900 tracking-wider">04. Institutional Quote</h3>
                </div>
                @include('livewire.partials.trilingual-input', ['label' => 'Footer Quote', 'key' => 'v_footer_quote'])
                @include('livewire.partials.trilingual-input', ['label' => 'Citation', 'key' => 'v_footer_cite'])
            </div>

            <!-- STICKY ACTION BUTTON -->
            <div class="sticky bottom-6 z-30">
                <button 
                    type="submit" 
                    class="w-full bg-[#1A365D] text-white py-4 rounded-full font-bold text-xs uppercase tracking-[0.25em] shadow-xl hover:shadow-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all"
                >
                    Publish Volunteer Page
                </button>
            </div>
        </form>
    </div>

    <!-- RIGHT: PREVIEW (IFRAME) -->
     <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/volunteer'" />
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

        // Delegated Focus & Click listeners
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