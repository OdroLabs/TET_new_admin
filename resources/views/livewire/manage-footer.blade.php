<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <div class="w-full lg:w-[680px] h-full flex flex-col border-r border-slate-200 bg-[#FDFCF9]">
        <header class="p-6 lg:px-8 border-b border-slate-200/80 bg-white/90 backdrop-blur-md flex items-center justify-between z-20 flex-shrink-0">
            <div>
                <h2 class="font-serif text-2xl font-bold italic text-[#1A365D]">Footer &amp; Social Channels</h2>
                <p class="text-slate-400 text-[9px] mt-0.5 font-bold uppercase tracking-widest">Social Links, Institutional Disclaimers &amp; Columns</p>
            </div>
            
            <button 
                type="submit" 
                form="footer-form"
                wire:loading.attr="disabled"
                wire:target="save"
                class="bg-[#1A365D] hover:bg-[#2374b0] disabled:opacity-50 disabled:cursor-not-allowed text-white px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:shadow-lg transition-all flex items-center gap-2 cursor-pointer flex-shrink-0"
            >
                <span wire:loading.remove wire:target="save">
                    Publish Footer →
                </span>
                <span wire:loading wire:target="save">
                    Publishing...
                </span>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto p-6 lg:p-8 scroll-smooth">
            @if (session()->has('message'))
                <div class="mb-6 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    {{ session('message') }}
                </div>
            @endif

            <form id="footer-form" wire:submit.prevent="save" class="space-y-8 pb-16">
                
                <div data-section="site-footer" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-sky-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Identity &amp; Social Links</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Footer Mission Tagline', 'key' => 'footer_desc'])

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2 border-t border-slate-100">
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Facebook URL</label>
                            <input type="url" wire:model.live.debounce.300ms="urls.footer_fb_url" placeholder="https://facebook.com/..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Instagram URL</label>
                            <input type="url" wire:model.live.debounce.300ms="urls.footer_ig_url" placeholder="https://instagram.com/..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">LinkedIn URL</label>
                            <input type="url" wire:model.live.debounce.300ms="urls.footer_ln_url" placeholder="https://linkedin.com/..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">X (Twitter) URL</label>
                            <input type="url" wire:model.live.debounce.300ms="urls.footer_x_url" placeholder="https://x.com/..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>
                    </div>
                </div>

                <div data-section="site-footer" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Column Headers &amp; Manual</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @include('livewire.partials.trilingual-input', ['label' => 'Column 2 Header', 'key' => 'footer_head_org'])
                        @include('livewire.partials.trilingual-input', ['label' => 'Column 3 Header', 'key' => 'footer_head_init'])
                    </div>

                    <div class="pt-2 border-t border-slate-100 space-y-3">
                        @include('livewire.partials.trilingual-input', ['label' => 'Legal Rights Manual Link Text', 'key' => 'footer_legal_manual'])
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Manual Document Link (URL / PDF)</label>
                            <input type="text" wire:model.live.debounce.300ms="urls.footer_manual_url" placeholder="https://... or /manual.pdf" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>
                    </div>
                </div>

                <div data-section="site-footer" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">03. Support Card (Column 4)</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Support Card Header', 'key' => 'footer_head_support'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Support Card Description', 'key' => 'footer_support_text'])
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        @include('livewire.partials.trilingual-input', ['label' => 'Donate Button Text', 'key' => 'footer_btn_donate'])
                        <div>
                            <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Donate Destination Link</label>
                            <input type="text" wire:model.live.debounce.300ms="urls.footer_donate_url" placeholder="/donate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>
                    </div>
                </div>

                <div data-section="site-footer" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-emerald-400">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                        <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">04. Copyright &amp; Legal Disclaimers</h3>
                    </div>

                    @include('livewire.partials.trilingual-input', ['label' => 'Copyright Entity Text', 'key' => 'footer_copy'])

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                        <div class="space-y-2">
                            @include('livewire.partials.trilingual-input', ['label' => 'Privacy Policy Label', 'key' => 'footer_privacy'])
                            <input type="text" wire:model.live.debounce.300ms="urls.footer_privacy_url" placeholder="/privacy" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>

                        <div class="space-y-2">
                            @include('livewire.partials.trilingual-input', ['label' => 'Terms Label', 'key' => 'footer_terms'])
                            <input type="text" wire:model.live.debounce.300ms="urls.footer_terms_url" placeholder="/terms" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/footer'" />

</div>