<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">Contact Desk Content</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Inquiry Desk &amp; Crisis Response Protocols</p>
            </div>
            
            <button 
                type="submit" 
                form="contact-form"
                wire:loading.attr="disabled"
                wire:target="save, form_image"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save, form_image">
                    Publish Contact Desk →
                </span>
                <span wire:loading wire:target="save">
                    Publishing...
                </span>
                <span wire:loading wire:target="form_image">
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

            <form id="contact-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
                <div data-section="contact-hero" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Hero Header</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Top Category Badge', 'key' => 'ct_hero_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Page Title', 'key' => 'ct_hero_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Introduction Description', 'key' => 'ct_hero_desc'])
                </div>

                <div data-section="contact-crisis" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-red-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Crisis &amp; Emergency Banner</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Urgency Badge', 'key' => 'ct_crisis_badge'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Crisis Title', 'key' => 'ct_crisis_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Crisis Description', 'key' => 'ct_crisis_desc'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Emergency Hotline Number', 'key' => 'ct_crisis_phone'])
                </div>

                <div data-section="contact-cards" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">03. Contact Info Cards (3 Cards)</h3>
                    </div>

                    @for($i=1; $i<=3; $i++)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                            <p class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest">Card 0{{$i}}</p>
                            @include('livewire.partials.trilingual-input', ['label' => 'Card Label', 'key' => "ct_g{$i}_label"])
                            @include('livewire.partials.trilingual-input', ['label' => 'Value (Email / Address)', 'key' => "ct_g{$i}_val"])
                            @include('livewire.partials.trilingual-input', ['label' => 'Subtext', 'key' => "ct_g{$i}_sub"])
                        </div>
                    @endfor
                </div>

                <div data-section="contact-form" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">04. Message Form &amp; Cover</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Form Headline', 'key' => 'ct_form_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Submit Button Text', 'key' => 'ct_form_btn'])

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Form Side Cover Image</label>
                        <input type="file" wire:model="form_image" class="text-xs w-full">
                        @if(!empty($existing['ct_form_img']))
                            <p class="text-[8px] text-slate-400 mt-1">Current: {{ $existing['ct_form_img'] }}</p>
                        @endif
                    </div>
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app').'/contact'" />

    <script>
    (function() {
        const getIframe = () => document.getElementById('preview-iframe');

        function sendScroll(sectionId) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;
            iframe.contentWindow.postMessage({
                type: 'TET_SCROLL_TO_SECTION',
                sectionId: sectionId
            }, '*');
        }

        document.addEventListener('focusin', function(e) {
            const container = e.target.closest('[data-section]');
            if (container) sendScroll(container.getAttribute('data-section'));
        });

        document.addEventListener('click', function(e) {
            const container = e.target.closest('[data-section]');
            if (container) sendScroll(container.getAttribute('data-section'));
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
                    sendScroll(detail.targetSection);
                }
            }
        });
    })();
    </script>
</div>