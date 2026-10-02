<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">Navigation &amp; Branding</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Header Logo, Menu Links &amp; Trilingual Labels</p>
            </div>
            
            <button 
                type="submit" 
                form="nav-form"
                wire:loading.attr="disabled"
                wire:target="save, logo_file"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save, logo_file">
                    Publish Navigation →
                </span>
                <span wire:loading wire:target="save">
                    Publishing...
                </span>
                <span wire:loading wire:target="logo_file">
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

            <form id="nav-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
                <div data-section="nav-logo" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Logo &amp; Identity</h3>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                        <label class="text-[9px] font-bold uppercase text-slate-500 block">Upload Official Header Logo</label>
                        <input type="file" wire:model="logo_file" class="text-xs w-full">
                        
                        @if($existing_logo)
                            <div class="pt-2 flex items-center gap-3">
                                <span class="text-[9px] text-slate-400 font-bold uppercase">Saved Logo:</span>
                                <span class="text-[10px] font-mono text-slate-600 truncate max-w-xs">{{ $existing_logo }}</span>
                            </div>
                        @endif
                        <p class="text-[8px] text-slate-400">Transparent PNG or SVG with max height 60px recommended.</p>
                    </div>
                </div>

                <div data-section="nav-donate" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Top Action Button (Donate)</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Button Text Label', 'key' => 'btn_donate'])
                    
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Button Link Destination</label>
                        <input type="text" wire:model.live.debounce.300ms="urls.nav_donate_url" placeholder="/donate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-blue-400">
                    </div>
                </div>

                <div data-section="nav-labels" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                            <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">03. Navigation Menu Links</h3>
                        </div>
                        <span class="text-[8px] font-bold uppercase text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">
                            Auto-Unfolds Mobile Menu
                        </span>
                    </div>

                    <div class="space-y-4">
                        @include('livewire.partials.trilingual-input', ['label' => 'Home Link Text', 'key' => 'nav_home'])
                        @include('livewire.partials.trilingual-input', ['label' => 'About Link Text', 'key' => 'nav_about'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Services Parent Link Text', 'key' => 'nav_services'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Dropdown: Advocacy Services', 'key' => 'nav_drop_services'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Dropdown: Volunteer', 'key' => 'nav_drop_volunteer'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Projects Link Text', 'key' => 'nav_projects'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Events & Gallery Link Text', 'key' => 'nav_gallery'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Activities Link Text', 'key' => 'nav_activities'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Social Enterprise Link Text', 'key' => 'nav_booking'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Contact Us Link Text', 'key' => 'nav_contact'])
                    </div>
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel 
        :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app')" 
        :showDrawer="true" 
    />

</div>