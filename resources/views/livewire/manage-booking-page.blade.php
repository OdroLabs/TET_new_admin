<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">TET Spaces &amp; Enterprises</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Social Enterprise &amp; Commercial Venues Manager</p>
            </div>
            
            <button 
                type="submit" 
                form="spaces-form"
                wire:loading.attr="disabled"
                wire:target="save, hall_image"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save, hall_image">
                    Publish Spaces &amp; Enterprises →
                </span>
                <span wire:loading wire:target="save">
                    Publishing...
                </span>
                <span wire:loading wire:target="hall_image">
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

            <form id="spaces-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
                <div data-section="se-hero" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Hero Header</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Top Badge', 'key' => 'se_hero_badge'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 1', 'key' => 'se_hero_title1'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 2 (Gradient / Italic)', 'key' => 'se_hero_title2'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Mission Description', 'key' => 'se_hero_desc'])
                </div>

                <div data-section="hall-booking" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Hall &amp; Venue Booking</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Category Tag', 'key' => 'se_hall_tag'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Hall Headline Part 1', 'key' => 'se_hall_title1'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Hall Headline Part 2 (Gradient)', 'key' => 'se_hall_title2'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Description', 'key' => 'se_hall_desc'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Capacity Badge (e.g. 📍 Capacity: 50 – 200 Guests)', 'key' => 'se_hall_capacity'])

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        @include('livewire.partials.trilingual-input', ['label' => 'Button Text', 'key' => 'se_hall_btn'])
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Button Link URL</label>
                            <input type="text" wire:model.live.debounce.300ms="urls.se_hall_btn_url" placeholder="/contact?subject=HallBooking" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-pink-400">
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Hall Showcase Image</label>
                        <input type="file" wire:model="hall_image" class="text-xs w-full">
                        @if(!empty($existing['se_hall_img']))
                            <p class="text-[8px] text-slate-400 mt-1">Current: {{ $existing['se_hall_img'] }}</p>
                        @endif
                    </div>
                </div>

                <div data-section="daily-care" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">03. Daily Care Center</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Category Tag', 'key' => 'se_care_tag'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Title Part 1', 'key' => 'se_care_title1'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Title Part 2 (Gradient)', 'key' => 'se_care_title2'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Care Description', 'key' => 'se_care_desc'])
                </div>

                <div data-section="condom-business" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-emerald-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">04. Condom &amp; Wellness Enterprise</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Category Tag', 'key' => 'se_prod_tag'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Title Part 1', 'key' => 'se_prod_title1'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Title Part 2 (Gradient)', 'key' => 'se_prod_title2'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Product Description', 'key' => 'se_prod_desc'])

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        @include('livewire.partials.trilingual-input', ['label' => 'Bulk Order Button Text', 'key' => 'se_prod_btn'])
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Button Link URL</label>
                            <input type="text" wire:model.live.debounce.300ms="urls.se_prod_btn_url" placeholder="/contact?subject=BulkCondomOrders" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-emerald-400">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app'). '/booking'" />

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
            if (container) {
                sendScroll(container.getAttribute('data-section'));
            }
        });

        document.addEventListener('click', function(e) {
            const container = e.target.closest('[data-section]');
            if (container) {
                sendScroll(container.getAttribute('data-section'));
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
                    sendScroll(detail.targetSection);
                }
            }
        });
    })();
    </script>
</div>