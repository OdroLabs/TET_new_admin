<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">
    
    <!-- LEFT: SCROLLABLE CMS CONTROL PANEL -->
    <div class="w-full lg:w-[650px] h-full overflow-y-auto p-8 lg:p-10 border-r border-slate-200 scroll-smooth">
        <header class="mb-8">
            <h2 class="font-serif text-3xl font-bold italic text-[#1A365D]">Donation Portal Content</h2>
            <p class="text-slate-400 text-[9px] mt-1 font-bold uppercase tracking-widest">Institutional Investment &amp; Transparency Management</p>
            
            @if (session()->has('message'))
                <div class="mt-4 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                    {{ session('message') }}
                </div>
            @endif
        </header>

        <form wire:submit.prevent="save" class="space-y-10 pb-28">
            
            <!-- SECTION 1: HERO -->
            <div data-section="donate-hero" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-blue-400">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Hero Header</h3>
                </div>

                @include('livewire.partials.trilingual-input', ['label' => 'Top Badge', 'key' => 'dn_hero_label'])
                @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 1', 'key' => 'dn_hero_title1'])
                @include('livewire.partials.trilingual-input', ['label' => 'Headline Part 2 (Gradient / Italic)', 'key' => 'dn_hero_title2'])
                @include('livewire.partials.trilingual-input', ['label' => 'Description', 'key' => 'dn_hero_desc'])
            </div>

            <!-- SECTION 2: CONTRIBUTION DESK -->
            <div data-section="donate-desk" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-pink-400">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. Contribution Desk &amp; Form Labels</h3>
                </div>

                @include('livewire.partials.trilingual-input', ['label' => 'Desk Title', 'key' => 'dn_desk_title'])
                @include('livewire.partials.trilingual-input', ['label' => 'Desk Description', 'key' => 'dn_desk_desc'])
                @include('livewire.partials.trilingual-input', ['label' => 'Amount Selection Label', 'key' => 'dn_desk_amt_label'])
                @include('livewire.partials.trilingual-input', ['label' => 'Submit Button Text', 'key' => 'dn_desk_btn'])

                <div class="h-px bg-slate-100 my-4"></div>

                @include('livewire.partials.trilingual-input', ['label' => 'Identity Section Heading', 'key' => 'dn_id_title'])
                @include('livewire.partials.trilingual-input', ['label' => 'Anonymous Checkbox Text', 'key' => 'dn_id_anon'])
                
                <div class="h-px bg-slate-100 my-4"></div>

                @include('livewire.partials.trilingual-input', ['label' => 'Payment Section Heading', 'key' => 'dn_pay_title'])
                @include('livewire.partials.trilingual-input', ['label' => 'Payment Option 1 (Card)', 'key' => 'dn_pay_opt1'])
                @include('livewire.partials.trilingual-input', ['label' => 'Payment Option 2 (Bank Transfer)', 'key' => 'dn_pay_opt2'])
                
                <div class="h-px bg-slate-100 my-4"></div>

                <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Trust Badges (Footer of Card)</p>
                <div class="space-y-3">
                    @include('livewire.partials.trilingual-input', ['label' => 'Badge 1 (SSL)', 'key' => 'dn_badge1'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Badge 2 (NGO)', 'key' => 'dn_badge2'])
                    @include('livewire.partials.trilingual-input', ['label' => 'Badge 3 (Security)', 'key' => 'dn_badge3'])
                </div>
            </div>

            <!-- SECTION 3: TRANSPARENCY & IMPACT -->
            <div data-section="donate-transparency" class="editor-section space-y-6 p-6 bg-white rounded-[2rem] border border-slate-100 shadow-sm transition-all focus-within:ring-2 focus-within:ring-purple-400">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">03. Accountability &amp; Impact (3 Pillars)</h3>
                </div>

                @include('livewire.partials.trilingual-input', ['label' => 'Section Small Tag', 'key' => 'dn_imp_label'])
                @include('livewire.partials.trilingual-input', ['label' => 'Section Headline', 'key' => 'dn_imp_title'])

                @for($i=1; $i<=3; $i++)
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                        <p class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest">Impact Allocation Card 0{{$i}}</p>
                        @include('livewire.partials.trilingual-input', ['label' => 'Value / Percentage (e.g. 40%)', 'key' => "dn_i{$i}_val"])
                        @include('livewire.partials.trilingual-input', ['label' => 'Pillar Title', 'key' => "dn_i{$i}_title"])
                        @include('livewire.partials.trilingual-input', ['label' => 'Pillar Description', 'key' => "dn_i{$i}_desc"])
                    </div>
                @endfor
            </div>

            <div class="sticky bottom-6 z-30">
                <button type="submit" class="w-full bg-[#1A365D] text-white py-4 rounded-full font-bold text-xs uppercase tracking-[0.25em] shadow-xl hover:shadow-2xl hover:-translate-y-0.5 active:translate-y-0 transition-all cursor-pointer">
                    Publish Donation Portal
                </button>
            </div>
        </form>
    </div>

    <!-- RIGHT: PREVIEW IFRAME -->
    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app').'/donate'" />

    <!-- DELEGATED SCRIPT -->
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

        window.addEventListener('content-updated', function(e) {
            const iframe = getIframe();
            const detail = e.detail?.[0] || e.detail;
            if (iframe && iframe.contentWindow && detail?.state) {
                iframe.contentWindow.postMessage({ type: 'TET_LIVE_PREVIEW', state: detail.state }, '*');
                if (detail.targetSection) sendScroll(detail.targetSection);
            }
        });
    })();
    </script>
</div>