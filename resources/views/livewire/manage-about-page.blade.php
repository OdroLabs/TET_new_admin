<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">About Page Management</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Institutional Identity & Community Leadership</p>
            </div>
            
            <button 
                type="submit" 
                form="about-form"
                wire:loading.attr="disabled"
                wire:target="save, about_hero_image, about_leader_image, about_team_group_image"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save, about_hero_image, about_leader_image, about_team_group_image">
                    Publish About Page →
                </span>
                <span wire:loading wire:target="save">
                    Publishing...
                </span>
                <span wire:loading wire:target="about_hero_image, about_leader_image, about_team_group_image">
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

            <form id="about-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
                <div data-section="about-hero" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">01. Hero Header</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Top Label', 'key' => 'about_hero_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Headline', 'key' => 'about_hero_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Description', 'key' => 'about_hero_description'])
                    
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Hero Main Image</label>
                        
                        @if ($about_hero_image)
                            <div class="mb-2">
                                <span class="text-[8px] text-blue-600 font-bold uppercase block mb-1">New Image Preview:</span>
                                <img src="{{ $about_hero_image->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-xl border border-blue-300">
                            </div>
                        @elseif(!empty($existing['about_hero_image']))
                            <div class="mb-2">
                                <span class="text-[8px] text-emerald-600 font-bold block mb-1">✓ Saved Image:</span>
                                <img src="{{ \App\Support\Media::url($existing['about_hero_image']) }}" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif

                        <input type="file" wire:model="about_hero_image" class="text-[10px] w-full">
                        
                        <div wire:loading wire:target="about_hero_image" class="text-[10px] text-blue-600 font-semibold mt-1">
                            Uploading image, please wait...
                        </div>
                        @error('about_hero_image') 
                            <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <div data-section="about-vision" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">02. Vision & Mission</h3>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">
                        <p class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest">Vision Block</p>
                        @include('livewire.partials.trilingual-input', ['label' => 'Vision Title', 'key' => 'about_vision_title'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Vision Text', 'key' => 'about_vision_text'])
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-4">
                        <p class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest">Mission Block</p>
                        @include('livewire.partials.trilingual-input', ['label' => 'Mission Title', 'key' => 'about_mission_title'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Mission Text', 'key' => 'about_mission_text'])
                    </div>
                </div>

                <div data-section="about-values" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">03. Core Values</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Main Title', 'key' => 'about_values_main_title'])
                    
                    @for($i=1; $i<=4; $i++)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                            <p class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest">Value Card 0{{$i}}</p>
                            @include('livewire.partials.trilingual-input', ['label' => 'Card Title', 'key' => "about_value_{$i}_title"])
                            @include('livewire.partials.trilingual-input', ['label' => 'Card Description', 'key' => "about_value_{$i}_text"])
                        </div>
                    @endfor
                </div>

                <div data-section="about-leader" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-amber-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">04. Leadership Spotlight</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Label', 'key' => 'about_leader_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Director Name', 'key' => 'about_leader_name'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Director Role', 'key' => 'about_leader_role'])
                    
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Director Biography</label>
                        <textarea wire:model.live.debounce.300ms="state.about_leader_bio.en" placeholder="English Bio" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:bg-white focus:ring-1 focus:ring-amber-400"></textarea>
                        <textarea wire:model.live.debounce.300ms="state.about_leader_bio.si" placeholder="සිංහල ජීව දත්ත" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:bg-white focus:ring-1 focus:ring-amber-400"></textarea>
                        <textarea wire:model.live.debounce.300ms="state.about_leader_bio.ta" placeholder="தமிழ் சுயவிவரம்" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:bg-white focus:ring-1 focus:ring-amber-400"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                            @include('livewire.partials.trilingual-input', ['label' => 'Stat 1 Value', 'key' => 'about_leader_stat1_val'])
                            @include('livewire.partials.trilingual-input', ['label' => 'Stat 1 Label', 'key' => 'about_leader_stat1_label'])
                        </div>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                            @include('livewire.partials.trilingual-input', ['label' => 'Stat 2 Value', 'key' => 'about_leader_stat2_val'])
                            @include('livewire.partials.trilingual-input', ['label' => 'Stat 2 Label', 'key' => 'about_leader_stat2_label'])
                        </div>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Leader Portrait Photo</label>
                        
                        @if ($about_leader_image)
                            <div class="mb-2">
                                <span class="text-[8px] text-amber-600 font-bold uppercase block mb-1">New Image Preview:</span>
                                <img src="{{ $about_leader_image->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-xl border border-amber-300">
                            </div>
                        @elseif(!empty($existing['about_leader_image']))
                            <div class="mb-2">
                                <span class="text-[8px] text-emerald-600 font-bold block mb-1">✓ Saved Image:</span>
                                <img src="{{ \App\Support\Media::url($existing['about_leader_image']) }}" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif

                        <input type="file" wire:model="about_leader_image" class="text-[10px] w-full">
                        
                        <div wire:loading wire:target="about_leader_image" class="text-[10px] text-amber-600 font-semibold mt-1">
                            Uploading image, please wait...
                        </div>
                        @error('about_leader_image') 
                            <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

                <div data-section="about-team" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-emerald-400">
                    <div class="flex items-center gap-3 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h3 class="text-[10px] font-black uppercase tracking-widest text-[#1A365D]">05. Our Team Members</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Section Label', 'key' => 'about_team_label'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Main Title', 'key' => 'about_team_title'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Description Paragraph', 'key' => 'about_team_desc'])

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <label class="text-[9px] font-bold uppercase text-slate-500 mb-1 block">Team Showcase Group Photo</label>
                        
                        @if ($about_team_group_image)
                            <div class="mb-2">
                                <span class="text-[8px] text-emerald-600 font-bold uppercase block mb-1">New Image Preview:</span>
                                <img src="{{ $about_team_group_image->temporaryUrl() }}" class="w-24 h-24 object-cover rounded-xl border border-emerald-300">
                            </div>
                        @elseif(!empty($existing['about_team_group_image']))
                            <div class="mb-2">
                                <span class="text-[8px] text-emerald-600 font-bold block mb-1">✓ Saved Image:</span>
                                <img src="{{ \App\Support\Media::url($existing['about_team_group_image']) }}" class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                            </div>
                        @endif

                        <input type="file" wire:model="about_team_group_image" class="text-[10px] w-full">
                        
                        <div wire:loading wire:target="about_team_group_image" class="text-[10px] text-emerald-600 font-semibold mt-1">
                            Uploading image, please wait...
                        </div>
                        @error('about_team_group_image') 
                            <span class="text-[10px] text-red-500 font-bold block mt-1">{{ $message }}</span> 
                        @enderror
                    </div>
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/about'" />
    
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

    window.addEventListener('load', function() {
        const iframe = getIframe();
        if (iframe) {
            iframe.addEventListener('load', function() {
                @this.call('syncIframe');
            });
        }
    });
})();
</script>
</div>