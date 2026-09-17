<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <!-- LEFT: SCROLLABLE CMS CONTROL PANEL -->
    <div class="w-full lg:w-[650px] h-full overflow-y-auto p-8 lg:p-10 border-r border-slate-200 scroll-smooth">
        <header class="mb-8">
            <h2 class="font-serif text-3xl font-bold italic text-[#1A365D]">Daily Activities &amp; News</h2>
            <p class="text-slate-400 text-[9px] mt-1 font-bold uppercase tracking-widest">Grassroots Field Updates &amp; Activity Publisher</p>
            
            @if (session()->has('message'))
                <div class="mt-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    {{ session('message') }}
                </div>
            @endif
        </header>

        <!-- SECTION 1: HEADER FORM -->
        <div data-section="news-hero" class="space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm mb-10">
            <div class="flex items-center justify-between">
                <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Header Content</h3>
                <button type="button" wire:click="saveHeaders" class="bg-[#1A365D] text-white px-4 py-1.5 rounded-full text-[9px] font-bold uppercase tracking-widest hover:bg-slate-800 cursor-pointer">
                    Save Headers
                </button>
            </div>
            @include('livewire.partials.trilingual-input', ['label' => 'Top Category Badge', 'key' => 'act_hero_label'])
            @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 1', 'key' => 'act_hero_title1'])
            @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 2', 'key' => 'act_hero_title2'])
            @include('livewire.partials.trilingual-input', ['label' => 'Intro Description', 'key' => 'act_hero_desc'])
        </div>

        <!-- SECTION 2: ACTIVITIES COLLECTION (CRUD) -->
        <div data-section="news-grid" class="space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Activities Collection ({{ count($this->activities) }})</h3>
                    <p class="text-[9px] text-slate-400 font-semibold">Manage Field Stories</p>
                </div>
                <button 
                    type="button" 
                    wire:click="newActivity" 
                    class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-md hover:scale-105 transition-all cursor-pointer"
                >
                    + Add New Activity
                </button>
            </div>

            <!-- ACTIVE FORM (WHEN CREATING OR EDITING) -->
            @if($editingId)
                <div class="p-6 bg-pink-50/50 rounded-3xl border border-pink-200 space-y-4">
                    <div class="flex items-center justify-between border-b border-pink-200/60 pb-3">
                        <span class="text-xs font-black text-pink-950 uppercase tracking-widest">
                            {{ $editingId === 'new' ? 'Create New Activity' : 'Edit Activity #' . $editingId }}
                        </span>
                        <button type="button" wire:click="$set('editingId', null)" class="text-xs text-slate-400 hover:text-slate-600 font-bold cursor-pointer">✕ Cancel</button>
                    </div>

                    <!-- 1. ACTIVITY TITLE (PRIMARY FIELD) -->
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest block">Activity Title</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                            <input type="text" wire:model="activityState.title.en" placeholder="English Title" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                            <input type="text" wire:model="activityState.title.si" placeholder="සිංහල මාතෘකාව" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                            <input type="text" wire:model="activityState.title.ta" placeholder="தமிழ் தலைப்பு" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                        </div>
                    </div>

                    <!-- 2. DATE & LOCATION -->
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Display Date</label>
                        <input type="text" wire:model="activityState.date" placeholder="e.g. Today • Aug 24, 2026" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400 mb-3">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Location</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                            <input type="text" wire:model="activityState.location.en" placeholder="English Location" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                            <input type="text" wire:model="activityState.location.si" placeholder="සිංහල ස්ථානය" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                            <input type="text" wire:model="activityState.location.ta" placeholder="தமிழ் இடம்" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>
                    </div>

                    <!-- 3. CARD SUMMARY (EXCERPT) -->
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest block">Card Summary (Excerpt)</label>
                        <div class="space-y-2">
                            <textarea wire:model="activityState.excerpt.en" placeholder="English short summary for card..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-16 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                            <textarea wire:model="activityState.excerpt.si" placeholder="සිංහල කෙටි විස්තරය..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-14 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                            <textarea wire:model="activityState.excerpt.ta" placeholder="தமிழ் சுருக்கம்..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-14 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                        </div>
                    </div>

                    <!-- 4. FULL MODAL STORY -->
                    <div class="space-y-2 pt-2 border-t border-pink-200/60">
                        <label class="text-[9px] font-black text-pink-600 uppercase tracking-widest block">Full Story (Visible in Modal)</label>
                        <div class="space-y-2">
                            <textarea wire:model="activityState.full_story.en" placeholder="Comprehensive English field report..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-20 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                            <textarea wire:model="activityState.full_story.si" placeholder="සම්පූර්ණ සිංහල විස්තරය..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-16 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                            <textarea wire:model="activityState.full_story.ta" placeholder="முழு தமிழ் அறிக்கை..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs h-16 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                        </div>
                    </div>

                    <!-- 5. PHOTO UPLOAD -->
                    <div class="pt-2 border-t border-pink-200/60">
                        <label class="text-[9px] font-bold uppercase text-slate-500 block mb-1">Activity Photo</label>
                        <input type="file" wire:model="activityImage" class="text-xs w-full">
                        @if($existingActivityImage && !$activityImage)
                            <span class="text-[8px] text-emerald-600 font-bold block mt-1">✓ Photo already uploaded</span>
                        @endif
                    </div>

                    <button 
                        type="button" 
                        wire:click="saveActivity" 
                        class="w-full bg-[#1A365D] hover:bg-slate-800 text-white py-3 rounded-full text-xs font-bold uppercase tracking-widest shadow-md transition-all cursor-pointer mt-4"
                    >
                        {{ $editingId === 'new' ? 'Publish New Activity' : 'Save Changes' }}
                    </button>
                </div>
            @endif

            <!-- LIST OF EXISTING ACTIVITIES -->
            <div class="space-y-3">
                @foreach($this->activities as $act)
                    <div 
                        data-activity-id="{{ $act->id }}" 
                        class="p-4 bg-slate-50 rounded-2xl border border-slate-200 flex items-center justify-between hover:bg-slate-100 transition-all"
                    >
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 rounded-full bg-sky-100 text-sky-800 text-xs font-bold flex items-center justify-center">
                                {{ $act->order }}
                            </span>
                            <div>
                                <h4 class="text-xs font-bold text-[#1A365D] line-clamp-1">
                                    {{ $act->getTranslation('title', 'en') ?: 'Untitled Activity #' . $act->id }}
                                </h4>
                                <span class="text-[9px] text-slate-400 font-semibold uppercase tracking-wider">{{ $act->date }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                wire:click="editActivity({{ $act->id }})" 
                                class="px-3 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold text-sky-700 hover:border-sky-400 shadow-sm cursor-pointer"
                            >
                                Edit
                            </button>
                            <button 
                                type="button" 
                                wire:confirm="Are you sure you want to delete this activity?"
                                wire:click="deleteActivity({{ $act->id }})" 
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

    <!-- RIGHT: PREVIEW IFRAME -->
     <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/news'" />

    <!-- SCRIPT -->
    <script>
    (function() {
        const getIframe = () => document.getElementById('preview-iframe');

        function sendScroll(sectionId, activityId = null) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;
            iframe.contentWindow.postMessage({
                type: 'TET_SCROLL_TO_SECTION',
                sectionId: sectionId,
                activityId: activityId
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

        // Livewire updates
        window.addEventListener('content-updated', function(e) {
            const iframe = getIframe();
            const detail = e.detail?.[0] || e.detail;
            if (iframe && iframe.contentWindow && detail?.state) {
                iframe.contentWindow.postMessage({ type: 'TET_LIVE_PREVIEW', state: detail.state }, '*');
                if (detail.activityId) sendModal('OPEN', detail.activityId);
            }
        });

        // Trigger iframe reload on create/delete
        window.addEventListener('reload-frontend-collection', function() {
            const iframe = getIframe();
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.postMessage({ type: 'TET_RELOAD_COLLECTION' }, '*');
            }
        });
    })();
    </script>
</div>