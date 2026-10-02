<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">Gallery &amp; Events</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Community Happenings &amp; Event Archive Manager</p>
            </div>
            
            <button 
                type="button" 
                wire:click="saveHeaders"
                wire:loading.attr="disabled"
                wire:target="saveHeaders"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="saveHeaders">
                    Save Headers →
                </span>
                <span wire:loading wire:target="saveHeaders">
                    Saving...
                </span>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-6 lg:p-8 scroll-smooth space-y-8 pb-16">
            @if (session()->has('message'))
                <div class="mb-6 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    {{ session('message') }}
                </div>
            @endif

            <div data-section="gallery-hero" class="space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Header Content</h3>
                </div>
                @include('livewire.partials.trilingual-input', ['label' => 'Top Category Badge', 'key' => 'gl_events_tag'])
                @include('livewire.partials.trilingual-input', ['label' => 'Gallery Headline', 'key' => 'gl_gallery_title'])
                @include('livewire.partials.trilingual-input', ['label' => 'Intro Description', 'key' => 'gl_gallery_desc'])
            </div>

            <div data-section="gallery-events" class="space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Events Collection ({{ count($this->events) }})</h3>
                        <p class="text-[9px] text-slate-400 font-semibold">Manage Community Archives</p>
                    </div>
                    <button 
                        type="button" 
                        wire:click="newEvent" 
                        class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-md hover:scale-105 transition-all cursor-pointer"
                    >
                        + Add New Event
                    </button>
                </div>

                @if($editingId)
                    <div class="p-6 bg-pink-50/50 rounded-3xl border border-pink-200 space-y-4">
                        <div class="flex items-center justify-between border-b border-pink-200/60 pb-3">
                            <span class="text-xs font-black text-pink-950 uppercase tracking-widest">
                                {{ $editingId === 'new' ? 'Create New Event' : 'Edit Event #' . $editingId }}
                            </span>
                            <button type="button" wire:click="$set('editingId', null)" class="text-xs text-slate-400 hover:text-slate-600 font-bold cursor-pointer">✕ Cancel</button>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest block">Event Title</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                <input type="text" wire:model="eventState.title.en" placeholder="English Title" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                                <input type="text" wire:model="eventState.title.si" placeholder="සිංහල මාතෘකාව" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                                <input type="text" wire:model="eventState.title.ta" placeholder="தமிழ் தலைப்பு" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Category</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                <input type="text" wire:model="eventState.cat.en" placeholder="English Category" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                                <input type="text" wire:model="eventState.cat.si" placeholder="සිංහල වර්ගය" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                                <input type="text" wire:model="eventState.cat.ta" placeholder="தமிழ் வகை" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Display Date</label>
                            <input type="text" wire:model="eventState.date" placeholder="e.g. OCT 14, 2026" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400 mb-3">
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Location</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                <input type="text" wire:model="eventState.location.en" placeholder="English Location" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                                <input type="text" wire:model="eventState.location.si" placeholder="සිංහල ස්ථානය" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                                <input type="text" wire:model="eventState.location.ta" placeholder="தமிழ் இடம்" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest block">Card Summary (Excerpt)</label>
                            <div class="space-y-2">
                                <textarea wire:model="eventState.excerpt.en" placeholder="English short summary..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-16 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                                <textarea wire:model="eventState.excerpt.si" placeholder="සිංහල කෙටි විස්තරය..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-14 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                                <textarea wire:model="eventState.excerpt.ta" placeholder="தமிழ் சுருக்கம்..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-14 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                            </div>
                        </div>

                        <div class="space-y-2 pt-2 border-t border-pink-200/60">
                            <label class="text-[9px] font-black text-pink-600 uppercase tracking-widest block">Full Story (Visible in Modal)</label>
                            <div class="space-y-2">
                                <textarea wire:model="eventState.full_story.en" placeholder="Comprehensive English story..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                                <textarea wire:model="eventState.full_story.si" placeholder="සම්පූර්ණ සිංහල විස්තරය..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-16 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                                <textarea wire:model="eventState.full_story.ta" placeholder="முழு தமிழ் அறிக்கை..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-16 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-pink-200/60 space-y-3">
                            <div>
                                <label class="text-[9px] font-bold uppercase text-slate-500 block mb-1">Main Cover Photo</label>
                                <input type="file" wire:model="coverImage" class="text-xs w-full">
                                @if($existingCoverImage && !$coverImage)
                                    <span class="text-[8px] text-emerald-600 font-bold block mt-1">✓ Cover Photo Saved</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="text-[8px] font-bold uppercase text-slate-400 block mb-1">Sub-Photo 1 (Modal)</label>
                                    <input type="file" wire:model="galleryImage1" class="text-[9px] w-full">
                                </div>
                                <div>
                                    <label class="text-[8px] font-bold uppercase text-slate-400 block mb-1">Sub-Photo 2 (Modal)</label>
                                    <input type="file" wire:model="galleryImage2" class="text-[9px] w-full">
                                </div>
                            </div>
                        </div>

                        <button 
                            type="button" 
                            wire:click="saveEvent" 
                            class="w-full bg-[#1A365D] hover:bg-slate-800 text-white py-3 rounded-full text-xs font-bold uppercase tracking-widest shadow-md transition-all cursor-pointer mt-4"
                        >
                            {{ $editingId === 'new' ? 'Publish New Event' : 'Save Changes' }}
                        </button>
                    </div>
                @endif

                <div class="space-y-3">
                    @foreach($this->events as $ev)
                        <div 
                            data-event-id="{{ $ev->id }}" 
                            class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between hover:bg-slate-100 transition-all"
                        >
                            <div class="flex items-center gap-3">
                                <span class="w-7 h-7 rounded-full bg-pink-100 text-pink-800 text-xs font-bold flex items-center justify-center">
                                    {{ $ev->order }}
                                </span>
                                <div>
                                    <h4 class="text-xs font-bold text-[#1A365D] line-clamp-1">
                                        {{ $ev->getTranslation('title', 'en') ?: 'Untitled Event #' . $ev->id }}
                                    </h4>
                                    <span class="text-[9px] text-slate-400 font-semibold uppercase tracking-wider">{{ $ev->date }} • {{ $ev->getTranslation('cat', 'en') }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button 
                                    type="button" 
                                    wire:click="editEvent({{ $ev->id }})" 
                                    class="px-3 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-sky-700 hover:border-sky-400 shadow-sm cursor-pointer"
                                >
                                    Edit
                                </button>
                                <button 
                                    type="button" 
                                    wire:confirm="Are you sure you want to delete this event?"
                                    wire:click="deleteEvent({{ $ev->id }})" 
                                    class="px-3 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-red-600 hover:border-red-400 shadow-sm cursor-pointer"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app').'/gallery'" />

    <script>
    (function() {
        const getIframe = () => document.getElementById('preview-iframe');

        function sendScroll(sectionId, eventId = null) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;
            iframe.contentWindow.postMessage({
                type: 'TET_SCROLL_TO_SECTION',
                sectionId: sectionId,
                eventId: eventId
            }, '*');
        }

        function sendModal(action, id = null) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;
            iframe.contentWindow.postMessage({
                type: action === 'OPEN' ? 'TET_OPEN_MODAL' : 'TET_CLOSE_MODAL',
                id: id
            }, '*');
        }

        window.addEventListener('content-updated', function(e) {
            const iframe = getIframe();
            const detail = e.detail?.[0] || event.detail;
            if (iframe && iframe.contentWindow && detail?.state) {
                iframe.contentWindow.postMessage({ type: 'TET_LIVE_PREVIEW', state: detail.state }, '*');
                if (detail.eventId) sendModal('OPEN', detail.eventId);
            }
        });

        window.addEventListener('reload-frontend-collection', function() {
            const iframe = getIframe();
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.postMessage({ type: 'TET_RELOAD_COLLECTION' }, '*');
            }
        });
    })();
    </script>
</div>