<!DOCTYPE html>
<html lang="en" class="h-full bg-[#F8F9FA]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TET Admin | Boutique Command Center</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        navy: {
                            950: '#0B132B',
                            900: '#111D42',
                            800: '#172554',
                            700: '#1E3A8A',
                        },
                        brand: {
                            blue: '#2A8ACD',
                            pink: '#EFBAC6',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 9999px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }

       
        .admin-scroll-area,
        main form,
        .admin-form-panel {
            padding-bottom: 7rem !important;
            scroll-behavior: smooth;
        }

        .admin-action-dock {
            position: sticky;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 40;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-top: 1px solid rgba(226, 232, 240, 0.9);
            padding: 1rem 1.5rem;
            margin-top: 2rem;
            box-shadow: 0 -10px 25px -5px rgba(15, 23, 42, 0.05);
        }
    </style>

    @livewireStyles
</head>

<body class="h-full font-sans text-slate-800 antialiased overflow-hidden selection:bg-brand-blue/20 selection:text-brand-blue">
    <div class="flex h-full">

        <aside class="w-72 bg-gradient-to-b from-[#0F1C3F] via-[#111F45] to-[#0A132C] text-white flex flex-col shadow-2xl z-50 h-full border-r border-white/10 relative">

            <div class="absolute top-0 left-0 w-48 h-48 bg-brand-blue/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-20 right-0 w-36 h-36 bg-pink-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="p-6 pb-5 flex-shrink-0 border-b border-white/10 relative z-10">
                <div class="flex items-center gap-3.5">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-brand-blue via-pink-400 to-indigo-400 p-[1.5px] shadow-lg shadow-sky-500/20">
                            <div class="w-full h-full bg-[#0F1C3F] rounded-[14px] flex items-center justify-center text-sm">
                                🏳️‍⚧️
                            </div>
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-emerald-400 rounded-full border-2 border-[#0F1C3F]"></span>
                    </div>
                    <div>
                        <h1 class="font-serif text-xl font-bold tracking-tight text-white leading-none">TET Admin</h1>
                        <p class="text-[9px] uppercase tracking-[0.25em] text-sky-200/70 font-bold mt-1">Boutique Command Center</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-3.5 py-5 space-y-6 overflow-y-auto sidebar-scroll relative z-10 text-[12px]">

                <div class="space-y-1">
                    <div class="px-3 pb-1.5 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400/80"></span>
                        <span class="text-[9px] uppercase tracking-[0.22em] text-sky-200/60 font-black">Site Configuration</span>
                    </div>

                    <a href="/admin/navigation" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/navigation') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🎨</span>
                            <span>Nav &amp; Branding</span>
                        </div>
                        @if(request()->is('admin/navigation')) <span class="w-1.5 h-1.5 rounded-full bg-brand-blue shadow-sm shadow-sky-400"></span> @endif
                    </a>

                    <a href="/admin/footer" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/footer') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">👣</span>
                            <span>Footer &amp; Socials</span>
                        </div>
                        @if(request()->is('admin/footer')) <span class="w-1.5 h-1.5 rounded-full bg-brand-blue shadow-sm shadow-sky-400"></span> @endif
                    </a>

                    <a href="/admin/home" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/home') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🏠</span>
                            <span>Home Page</span>
                        </div>
                        @if(request()->is('admin/home')) <span class="w-1.5 h-1.5 rounded-full bg-brand-blue shadow-sm shadow-sky-400"></span> @endif
                    </a>

                    <a href="/admin/about" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/about') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📄</span>
                            <span>About Identity</span>
                        </div>
                        @if(request()->is('admin/about')) <span class="w-1.5 h-1.5 rounded-full bg-brand-blue shadow-sm shadow-sky-400"></span> @endif
                    </a>

                    <a href="/admin/services" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/services') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🛠️</span>
                            <span>Services Page</span>
                        </div>
                        @if(request()->is('admin/services')) <span class="w-1.5 h-1.5 rounded-full bg-brand-blue shadow-sm shadow-sky-400"></span> @endif
                    </a>

                    <a href="/admin/service-list" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/service-list') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🧩</span>
                            <span>Services Manager</span>
                        </div>
                        @if(request()->is('admin/service-list')) <span class="w-1.5 h-1.5 rounded-full bg-brand-blue shadow-sm shadow-sky-400"></span> @endif
                    </a>

                    <a href="/admin/booking" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/booking') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🏢</span>
                            <span>TET Spaces (Venues)</span>
                        </div>
                        @if(request()->is('admin/booking')) <span class="w-1.5 h-1.5 rounded-full bg-brand-blue shadow-sm shadow-sky-400"></span> @endif
                    </a>
                </div>

                <div class="space-y-1">
                    <div class="px-3 pb-1.5 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-400/80"></span>
                        <span class="text-[9px] uppercase tracking-[0.22em] text-pink-200/60 font-black">Advocacy &amp; Media</span>
                    </div>

                    <a href="/admin/projects" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/projects') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                            <span>Projects Page</span>
                        </div>
                        @if(request()->is('admin/projects')) <span class="w-1.5 h-1.5 rounded-full bg-pink-400 shadow-sm shadow-pink-400"></span> @endif
                    </a>

                    <a href="/admin/project-list" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/project-list') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🗂️</span>
                            <span>Projects Manager</span>
                        </div>
                        @if(request()->is('admin/project-list')) <span class="w-1.5 h-1.5 rounded-full bg-pink-400 shadow-sm shadow-pink-400"></span> @endif
                    </a>

                    <a href="/admin/news" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/news') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📰</span>
                            <span>Daily Activities</span>
                        </div>
                        @if(request()->is('admin/news')) <span class="w-1.5 h-1.5 rounded-full bg-pink-400 shadow-sm shadow-pink-400"></span> @endif
                    </a>

                    <a href="/admin/gallery" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/gallery') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🖼️</span>
                            <span>Events &amp; Gallery</span>
                        </div>
                        @if(request()->is('admin/gallery')) <span class="w-1.5 h-1.5 rounded-full bg-pink-400 shadow-sm shadow-pink-400"></span> @endif
                    </a>
                </div>

                <div class="space-y-1">
                    <div class="px-3 pb-1.5 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400/80"></span>
                        <span class="text-[9px] uppercase tracking-[0.22em] text-emerald-200/60 font-black">Commercial &amp; Store</span>
                    </div>

                    <a href="/admin/products" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/products') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🛡️</span>
                            <span>Products Catalog</span>
                        </div>
                        @if(request()->is('admin/products')) <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-sm shadow-emerald-400"></span> @endif
                    </a>

                    <a href="/admin/orders" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/orders') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📋</span>
                            <span>Orders &amp; Inquiries</span>
                        </div>
                        @if(request()->is('admin/orders')) <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-sm shadow-emerald-400"></span> @endif
                    </a>
                </div>

                <!-- 4. COMMUNITY & GIVING -->
                <div class="space-y-1">
                    <div class="px-3 pb-1.5 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-400/80"></span>
                        <span class="text-[9px] uppercase tracking-[0.22em] text-purple-200/60 font-black">Community &amp; Giving</span>
                    </div>

                    <a href="/admin/contact" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/contact') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📞</span>
                            <span>Contact &amp; Hotline</span>
                        </div>
                        @if(request()->is('admin/contact')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shadow-sm shadow-purple-400"></span> @endif
                    </a>

                    <a href="/admin/messages" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/messages') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">✉️</span>
                            <span>Inbox &amp; Inquiries</span>
                        </div>
                        @if(request()->is('admin/messages')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shadow-sm shadow-purple-400"></span> @endif
                    </a>

                    <a href="/admin/volunteer" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/volunteer') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">💜</span>
                            <span>Volunteer Desk</span>
                        </div>
                        @if(request()->is('admin/volunteer')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shadow-sm shadow-purple-400"></span> @endif
                    </a>

                    <a href="/admin/donate" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/donate') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">✨</span>
                            <span>Donation Page Copy</span>
                        </div>
                        @if(request()->is('admin/donate')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shadow-sm shadow-purple-400"></span> @endif
                    </a>

                    <a href="/admin/donations" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/donations') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">💰</span>
                            <span>Donation Ledger</span>
                        </div>
                        @if(request()->is('admin/donations')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400 shadow-sm shadow-purple-400"></span> @endif
                    </a>
                </div>

                <div class="space-y-1 pb-4">
                    <div class="px-3 pb-1.5 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400/80"></span>
                        <span class="text-[9px] uppercase tracking-[0.22em] text-amber-200/60 font-black">System</span>
                    </div>

                    <a href="/admin/site-status" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/site-status') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🚦</span>
                            <span>Site Status</span>
                        </div>
                        @if(\App\Models\Setting::text('site_coming_soon') === '1')
                            <span class="text-[8px] font-black uppercase tracking-wider bg-amber-400 text-amber-950 px-1.5 py-0.5 rounded">Coming Soon</span>
                        @elseif(request()->is('admin/site-status')) <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shadow-sm shadow-amber-400"></span> @endif
                    </a>

                    <a href="/admin/email-settings" class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all font-medium {{ request()->is('admin/email-settings') ? 'bg-white/15 text-white shadow-sm border border-white/15' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📧</span>
                            <span>Email &amp; SMTP</span>
                        </div>
                        @if(request()->is('admin/email-settings')) <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shadow-sm shadow-amber-400"></span> @endif
                    </a>
                </div>

            </nav>

            <!-- FOOTER USER BAR -->
            <div class="p-4 border-t border-white/10 flex-shrink-0 bg-black/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-brand-blue to-indigo-500 p-[1px] flex-shrink-0">
                            <div class="w-full h-full bg-[#0F1C3F] rounded-[11px] flex items-center justify-center font-bold text-xs text-sky-200">
                                {{ substr(auth()->user()->name ?? 'AD', 0, 2) }}
                            </div>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Admin User' }}</p>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-[10px] text-pink-300 hover:text-pink-200 font-semibold cursor-pointer bg-transparent border-0 p-0 flex items-center gap-1 transition-colors">
                                    Sign Out <span class="text-xs">↗</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </aside>

        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#FBFBFD] relative">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>