@props([
    'url' => env('FRONTEND_URL', 'https://tet-frontend.vercel.app'),
    'showDrawer' => false,
    'defaultMode' => 'desktop', // 'desktop', 'tablet', or 'mobile'
])

<div class="flex-1 bg-slate-100 p-6 lg:p-10 flex flex-col items-center justify-center relative overflow-hidden h-screen">
    
    <!-- 1. GLOBAL PREVIEW TOOLBAR -->
    <div class="mb-4 z-20 flex flex-wrap items-center gap-2 bg-white/95 backdrop-blur-md p-1.5 rounded-2xl border border-slate-200 shadow-sm text-xs">
        
        <!-- Viewport Mode Buttons -->
        <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
            <button 
                type="button" 
                onclick="setPreviewViewport('mobile')" 
                id="btn-vp-mobile"
                title="Mobile Phone View"
                class="px-2.5 py-1.5 rounded-lg font-bold text-slate-600 hover:text-slate-900 transition-all cursor-pointer flex items-center gap-1.5 text-[11px]"
            >
                <span>📱</span>
                <span class="hidden sm:inline">Mobile</span>
            </button>

            <button 
                type="button" 
                onclick="setPreviewViewport('tablet')" 
                id="btn-vp-tablet"
                title="Tablet View"
                class="px-2.5 py-1.5 rounded-lg font-bold text-slate-600 hover:text-slate-900 transition-all cursor-pointer flex items-center gap-1.5 text-[11px]"
            >
                <span>📟</span>
                <span class="hidden sm:inline">Tablet</span>
            </button>

            <button 
                type="button" 
                onclick="setPreviewViewport('desktop')" 
                id="btn-vp-desktop"
                title="Desktop View"
                class="px-2.5 py-1.5 rounded-lg font-bold bg-[#1A365D] text-white transition-all cursor-pointer flex items-center gap-1.5 text-[11px]"
            >
                <span>🖥️</span>
                <span class="hidden sm:inline">Desktop</span>
            </button>
        </div>

        <span class="w-px h-4 bg-slate-200 mx-1"></span>

        <!-- Optional Menu Drawer Toggle (for Navigation manager) -->
        @if($showDrawer)
            <button 
                type="button" 
                onclick="sendGlobalNavDrawer('TOGGLE')" 
                title="Toggle Mobile Nav Drawer"
                class="px-3 py-1.5 rounded-xl font-bold text-pink-600 hover:bg-pink-50 border border-pink-200 transition-all cursor-pointer text-[11px]"
            >
                ☰ Menu
            </button>
        @endif

        <!-- Quick Refresh Button -->
        <button 
            type="button" 
            onclick="refreshPreviewIframe()" 
            title="Reload Preview Frame"
            class="p-1.5 px-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all cursor-pointer text-[11px] font-bold"
        >
            🔄 Reload
        </button>

        <!-- Pop out in full new tab -->
        <a 
            href="{{ $url }}" 
            target="_blank" 
            title="Open in New Tab"
            class="p-1.5 px-2.5 rounded-xl text-slate-600 hover:bg-slate-100 hover:text-slate-900 transition-all cursor-pointer text-[11px] font-bold"
        >
            ↗ Pop Out
        </a>
    </div>

    <!-- 2. DEVICE IFRAME WRAPPER -->
    <div 
        id="global-preview-wrapper" 
        class="w-full max-w-5xl h-[80vh] bg-white rounded-[2.5rem] shadow-2xl border-[10px] border-slate-900 overflow-hidden relative z-10 transition-all duration-300 ease-out"
    >
        <iframe 
            id="preview-iframe" 
            src="{{ $url }}" 
            class="w-full h-full border-none"
        ></iframe>
    </div>

    <!-- 3. STATUS INDICATOR -->
    <div class="mt-3 z-10 flex items-center gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-ping"></span>
        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">
            Ultra-Low Latency Preview Active
        </span>
    </div>

    <!-- 4. GLOBAL PREVIEW CONTROLLER SCRIPT -->
    <script>
    (function() {
        const getIframe = () => document.getElementById('preview-iframe');
        let navDrawerOpen = false;

        // Viewport Switcher
        window.setPreviewViewport = function(mode) {
            const wrapper = document.getElementById('global-preview-wrapper');
            const btnMobile = document.getElementById('btn-vp-mobile');
            const btnTablet = document.getElementById('btn-vp-tablet');
            const btnDesktop = document.getElementById('btn-vp-desktop');

            const allBtns = [btnMobile, btnTablet, btnDesktop];
            allBtns.forEach(btn => {
                btn.classList.remove('bg-[#1A365D]', 'text-white');
                btn.classList.add('text-slate-600');
            });

            if (mode === 'mobile') {
                wrapper.className = 'w-[380px] max-w-full h-[80vh] bg-white rounded-[3rem] shadow-2xl border-[12px] border-slate-900 overflow-hidden relative z-10 transition-all duration-300 ease-out';
                btnMobile.classList.add('bg-[#1A365D]', 'text-white');
                btnMobile.classList.remove('text-slate-600');
            } else if (mode === 'tablet') {
                wrapper.className = 'w-[680px] max-w-full h-[80vh] bg-white rounded-[2.5rem] shadow-2xl border-[10px] border-slate-900 overflow-hidden relative z-10 transition-all duration-300 ease-out';
                btnTablet.classList.add('bg-[#1A365D]', 'text-white');
                btnTablet.classList.remove('text-slate-600');
            } else {
                // Desktop
                wrapper.className = 'w-full max-w-5xl h-[80vh] bg-white rounded-[2.5rem] shadow-2xl border-[10px] border-slate-900 overflow-hidden relative z-10 transition-all duration-300 ease-out';
                btnDesktop.classList.add('bg-[#1A365D]', 'text-white');
                btnDesktop.classList.remove('text-slate-600');
            }
        };

        // Reload Iframe
        window.refreshPreviewIframe = function() {
            const iframe = getIframe();
            if (iframe) iframe.src = iframe.src;
        };

        // Drawer Command
        window.sendGlobalNavDrawer = function(action) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;

            if (action === 'TOGGLE') {
                navDrawerOpen = !navDrawerOpen;
                iframe.contentWindow.postMessage({
                    type: navDrawerOpen ? 'TET_OPEN_NAV_DRAWER' : 'TET_CLOSE_NAV_DRAWER'
                }, '*');
            }
        };

        function sendScroll(sectionId, index = null) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;

            iframe.contentWindow.postMessage({
                type: 'TET_SCROLL_TO_SECTION',
                sectionId: sectionId,
                cardIndex: index,
                activityId: index,
                eventId: index,
                slideIndex: index
            }, '*');
        }

        function sendModalAction(action, id = null) {
            const iframe = getIframe();
            if (!iframe || !iframe.contentWindow) return;

            iframe.contentWindow.postMessage({
                type: action === 'OPEN' ? 'TET_OPEN_MODAL' : 'TET_CLOSE_MODAL',
                id: id
            }, '*');
        }

        // Global Event Delegation for Cards, Sections & Modals
        function handleGlobalInteraction(e) {
            const cardItem = e.target.closest('[data-card], [data-event-id], [data-activity-id], [data-slide]');
            if (cardItem) {
                const id = parseInt(
                    cardItem.getAttribute('data-card') || 
                    cardItem.getAttribute('data-event-id') || 
                    cardItem.getAttribute('data-activity-id') || 
                    cardItem.getAttribute('data-slide'), 
                    10
                );
                const section = cardItem.closest('[data-section]');
                const sectionId = section ? section.getAttribute('data-section') : null;
                sendScroll(sectionId, id);
                sendModalAction('OPEN', id);
                return;
            }

            // Clicked outside modal target
            sendModalAction('CLOSE');

            const sectionContainer = e.target.closest('[data-section]');
            if (sectionContainer) {
                const sectionId = sectionContainer.getAttribute('data-section');
                sendScroll(sectionId);

                // Auto open mobile drawer if on navigation labels
                if (sectionId === 'nav-labels') {
                    const iframe = getIframe();
                    if (iframe && iframe.contentWindow) {
                        iframe.contentWindow.postMessage({ type: 'TET_OPEN_NAV_DRAWER' }, '*');
                    }
                } else if (sectionId === 'nav-logo') {
                    const iframe = getIframe();
                    if (iframe && iframe.contentWindow) {
                        iframe.contentWindow.postMessage({ type: 'TET_CLOSE_NAV_DRAWER' }, '*');
                    }
                }
            }
        }

        document.addEventListener('focusin', handleGlobalInteraction);
        document.addEventListener('click', handleGlobalInteraction);

        // Content update streaming from Livewire
        window.addEventListener('content-updated', function(event) {
            const iframe = getIframe();
            const detail = event.detail?.[0] || event.detail;

            if (iframe && iframe.contentWindow && detail?.state) {
                iframe.contentWindow.postMessage({
                    type: 'TET_LIVE_PREVIEW',
                    state: detail.state
                }, '*');

                if (detail.targetSection) {
                    sendScroll(detail.targetSection, detail.cardIndex || detail.activityId || detail.eventId || detail.slideIndex);
                }
            }
        });

        window.addEventListener('reload-settings', function() {
            const iframe = getIframe();
            if (iframe && iframe.contentWindow) {
                iframe.contentWindow.postMessage({ type: 'TET_RELOAD_SETTINGS' }, '*');
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