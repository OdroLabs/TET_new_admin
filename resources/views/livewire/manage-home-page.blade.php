<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">Home Management</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Section &amp; Carousel Synced Editor</p>
            </div>
            
            <button 
                type="submit" 
                form="home-form"
                wire:loading.attr="disabled"
                wire:target="save, hero_image_main, hero_image_sub, story_image, impact_card_images"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save, hero_image_main, hero_image_sub, story_image, impact_card_images">
                    Publish Homepage →
                </span>
                <span wire:loading wire:target="save">
                    Publishing...
                </span>
                <span wire:loading wire:target="hero_image_main, hero_image_sub, story_image, impact_card_images">
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

            <form id="home-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
                <div data-section="section-hero" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">01. Hero Section</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Top Label', 'key' => 'hero_top_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Main Headline', 'key' => 'hero_title_1'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Accent Headline', 'key' => 'hero_title_2'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Description', 'key' => 'hero_description'])
                    
                    <div class="pt-2 border-t border-slate-100 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @include('livewire.partials.trilingual-input', ['label' => 'Button 1 Text', 'key' => 'btn_support'])
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Button 1 Link URL</label>
                                <input type="text" wire:model.live.debounce.300ms="urls.btn_support_url" placeholder="/donate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-blue-400">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @include('livewire.partials.trilingual-input', ['label' => 'Button 2 Text', 'key' => 'btn_mission'])
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Button 2 Link URL</label>
                                <input type="text" wire:model.live.debounce.300ms="urls.btn_mission_url" placeholder="/about" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-blue-400">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div>
                            <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Main Hero Image</label>
                            <input type="file" wire:model="hero_image_main" class="text-[10px] w-full">
                        </div>
                        <div>
                            <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Circle Sub Image</label>
                            <input type="file" wire:model="hero_image_sub" class="text-[10px] w-full">
                        </div>
                    </div>
                </div>

                <div data-section="section-impact" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">02. Real-World Impact (8 Carousel Cards)</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Impact Main Title', 'key' => 'impact_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Impact Sub-Label', 'key' => 'impact_label'])
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        @include('livewire.partials.trilingual-input', ['label' => 'Journal Button Text', 'key' => 'view_journal'])
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Journal Button URL</label>
                            <input type="text" wire:model.live.debounce.300ms="urls.view_journal_url" placeholder="/news" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-pink-400">
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <label class="text-[10px] font-black text-pink-600 uppercase tracking-widest block">
                            Carousel Slides (Clicking or editing a card focuses it in preview)
                        </label>

                        @foreach($impact_cards as $idx => $card)
                            <div 
                                data-slide="{{ $loop->index }}" 
                                class="p-4 bg-pink-50/40 rounded-2xl border border-pink-100/70 space-y-3 transition-all hover:bg-pink-50"
                            >
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-black uppercase text-[#1A365D] tracking-widest">
                                        Card 0{{ $loop->iteration }}
                                    </span>
                                    @if(!empty($card['image']))
                                        <span class="text-[8px] font-bold text-slate-400">Image attached</span>
                                    @endif
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block">Category Tag</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <input type="text" wire:model.live.debounce.300ms="impact_cards.{{ $idx }}.cat.en" placeholder="En" class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-[11px] outline-none">
                                        <input type="text" wire:model.live.debounce.300ms="impact_cards.{{ $idx }}.cat.si" placeholder="සිං" class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-[11px] outline-none">
                                        <input type="text" wire:model.live.debounce.300ms="impact_cards.{{ $idx }}.cat.ta" placeholder="தமி" class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-[11px] outline-none">
                                    </div>
                                </div>

                                <div class="space-y-1">
                                    <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block">Card Title</label>
                                    <div class="grid grid-cols-3 gap-2">
                                        <input type="text" wire:model.live.debounce.300ms="impact_cards.{{ $idx }}.title.en" placeholder="En Title" class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-[11px] outline-none">
                                        <input type="text" wire:model.live.debounce.300ms="impact_cards.{{ $idx }}.title.si" placeholder="සිංහල" class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-[11px] outline-none">
                                        <input type="text" wire:model.live.debounce.300ms="impact_cards.{{ $idx }}.title.ta" placeholder="தமிழ்" class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-[11px] outline-none">
                                    </div>
                                </div>

                                <div>
                                    <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Upload Card Photo</label>
                                    <input type="file" wire:model="impact_card_images.{{ $idx }}" class="text-[10px] w-full">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div data-section="section-stats" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">03. Statistics (3 Cards)</h3>
                    </div>

                    @for($i=1; $i<=3; $i++)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                            <p class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest">Stat 0{{$i}}</p>
                            @include('livewire.partials.trilingual-input', ['label' => 'Stat Value', 'key' => "stat_{$i}_val"])
                            @include('livewire.partials.trilingual-input', ['label' => 'Stat Label', 'key' => "stat_{$i}_label"])
                            @include('livewire.partials.trilingual-input', ['label' => 'Stat Description', 'key' => "stat_{$i}_desc"])
                        </div>
                    @endfor
                </div>

                <div data-section="section-story" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-emerald-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">04. Storytelling Section</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Label', 'key' => 'story_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Main Headline', 'key' => 'story_title'])

                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Long Story Description</label>
                        <textarea wire:model.live.debounce.300ms="state.story_description.en" placeholder="English Description" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:bg-white focus:ring-1 focus:ring-emerald-400"></textarea>
                        <textarea wire:model.live.debounce.300ms="state.story_description.si" placeholder="සිංහල විස්තරය" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:bg-white focus:ring-1 focus:ring-emerald-400"></textarea>
                        <textarea wire:model.live.debounce.300ms="state.story_description.ta" placeholder="தமிழ் விளக்கம்" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:bg-white focus:ring-1 focus:ring-emerald-400"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div>
                            <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Video Thumbnail</label>
                            <input type="file" wire:model="story_image" class="text-[10px] w-full">
                        </div>
                        <div>
                            <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">YouTube Video URL</label>
                            <input type="text" wire:model.live.debounce.300ms="urls.story_video_url" placeholder="https://youtube.com/..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-emerald-400">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @include('livewire.partials.trilingual-input', ['label' => 'Story Stat Value', 'key' => 'story_stat_val'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Story Stat Label', 'key' => 'story_stat_label'])
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        @include('livewire.partials.trilingual-input', ['label' => 'Services Button Text', 'key' => 'explore_services'])
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-2">Services Button URL</label>
                            <input type="text" wire:model.live.debounce.300ms="urls.explore_services_url" placeholder="/services" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-emerald-400">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app')" />

    <script>
(function() {
    const getIframe = () => document.getElementById('preview-iframe');

    function sendScroll(sectionId, slideIndex = null) {
        const iframe = getIframe();
        if (!iframe || !iframe.contentWindow) return;

        iframe.contentWindow.postMessage({
            type: 'TET_SCROLL_TO_SECTION',
            sectionId: sectionId,
            slideIndex: slideIndex
        }, '*');
    }

    document.addEventListener('focusin', function(e) {
        const container = e.target.closest('[data-section]');
        if (container) {
            const sectionId = container.getAttribute('data-section');
            const slideItem = e.target.closest('[data-slide]');
            const slideIdx = slideItem ? parseInt(slideItem.getAttribute('data-slide'), 10) : null;
            sendScroll(sectionId, slideIdx);
        }
    });

    document.addEventListener('click', function(e) {
        const container = e.target.closest('[data-section]');
        if (container) {
            const sectionId = container.getAttribute('data-section');
            const slideItem = e.target.closest('[data-slide]');
            const slideIdx = slideItem ? parseInt(slideItem.getAttribute('data-slide'), 10) : null;
            sendScroll(sectionId, slideIdx);
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
                sendScroll(detail.targetSection, detail.slideIndex);
            }
        }
    });
})();
</script>
</div>