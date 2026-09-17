<!DOCTYPE html>
<html lang="en" class="h-full bg-[#FDFCF9]">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TET Admin | Boutique Command Center</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <!-- Custom Luxury Scrollbar for Sidebar -->
    <style>
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 10px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }
    </style>

    @livewireStyles
</head>

<body class="h-full font-sans text-slate-900 antialiased overflow-hidden">
    <div class="flex h-full">

        <!-- SIDEBAR: Institutional Navy (#1A365D) -->
        <aside class="w-72 bg-[#1A365D] text-white flex flex-col shadow-2xl z-50 h-full border-r border-white/5">

            <!-- BRAND HEADER -->
            <div class="p-7 pb-6 flex-shrink-0 border-b border-white/5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-pink-400 via-sky-400 to-indigo-400 p-0.5 shadow-md flex items-center justify-center">
                        <div class="w-full h-full bg-[#1A365D] rounded-full flex items-center justify-center text-xs">
                            🏳️‍⚧️
                        </div>
                    </div>
                    <div>
                        <h1 class="font-serif text-2xl font-bold tracking-tight text-white leading-none">TET Admin</h1>
                        <p class="text-[8px] uppercase tracking-[0.3em] text-sky-300/70 font-black mt-1.5">Boutique Command Center</p>
                    </div>
                </div>
            </div>

            <!-- NAVIGATION MENU -->
            <nav class="flex-1 px-4 py-6 space-y-6 overflow-y-auto sidebar-scroll">

                <!-- 1. SITE CONFIGURATION (Pages & Branding) -->
                <div class="space-y-1">
                    <div class="px-3 pb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400/50"></span>
                        <span class="text-[9px] uppercase tracking-[0.25em] text-blue-200/50 font-black">Site Configuration</span>
                    </div>

                    <a href="/admin/navigation" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/navigation') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🎨</span>
                            <span>Nav &amp; Branding</span>
                        </div>
                        @if(request()->is('admin/navigation')) <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span> @endif
                    </a>

                    <a href="/admin/footer" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/footer') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">👣</span>
                            <span>Footer &amp; Socials</span>
                        </div>
                        @if(request()->is('admin/footer')) <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span> @endif
                    </a>

                    <a href="/admin/home" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/home') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🏠</span>
                            <span>Home Page</span>
                        </div>
                        @if(request()->is('admin/home')) <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span> @endif
                    </a>

                    <a href="/admin/about" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/about') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📄</span>
                            <span>About Identity</span>
                        </div>
                        @if(request()->is('admin/about')) <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span> @endif
                    </a>

                    <a href="/admin/services" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/services') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🛠️</span>
                            <span>Core Services</span>
                        </div>
                        @if(request()->is('admin/services')) <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span> @endif
                    </a>

                    <a href="/admin/booking" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/booking') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🏢</span>
                            <span>TET Spaces (Venues)</span>
                        </div>
                        @if(request()->is('admin/booking')) <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span> @endif
                    </a>
                </div>

                <!-- 2. ADVOCACY & MEDIA PUBLISHING -->
                <div class="space-y-1">
                    <div class="px-3 pb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-pink-400/50"></span>
                        <span class="text-[9px] uppercase tracking-[0.25em] text-pink-200/50 font-black">Advocacy &amp; Media</span>
                    </div>

                    <a href="/admin/projects" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/projects') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📊</span>
                            <span>Strategic Projects</span>
                        </div>
                        @if(request()->is('admin/projects')) <span class="w-1.5 h-1.5 rounded-full bg-pink-400"></span> @endif
                    </a>

                    <a href="/admin/news" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/news') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📰</span>
                            <span>Daily Activities</span>
                        </div>
                        @if(request()->is('admin/news')) <span class="w-1.5 h-1.5 rounded-full bg-pink-400"></span> @endif
                    </a>

                    <a href="/admin/gallery" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/gallery') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🖼️</span>
                            <span>Events &amp; Gallery</span>
                        </div>
                        @if(request()->is('admin/gallery')) <span class="w-1.5 h-1.5 rounded-full bg-pink-400"></span> @endif
                    </a>
                </div>

                <!-- 3. COMMERCIAL & ENTERPRISE HUB -->
                <div class="space-y-1">
                    <div class="px-3 pb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400/50"></span>
                        <span class="text-[9px] uppercase tracking-[0.25em] text-emerald-200/50 font-black">Commercial &amp; Store</span>
                    </div>

                    <a href="/admin/products" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/products') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">🛡️</span>
                            <span>Products Catalog</span>
                        </div>
                        @if(request()->is('admin/products')) <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> @endif
                    </a>

                    <a href="/admin/orders" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/orders') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📋</span>
                            <span>Orders &amp; Inquiries</span>
                        </div>
                        @if(request()->is('admin/orders')) <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> @endif
                    </a>
                </div>

                <!-- 4. INQUیرIES, COMMUNITY & GIVING -->
                <div class="space-y-1 pb-4">
                    <div class="px-3 pb-2 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-400/50"></span>
                        <span class="text-[9px] uppercase tracking-[0.25em] text-purple-200/50 font-black">Community &amp; Giving</span>
                    </div>

                    <a href="/admin/contact" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/contact') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">📞</span>
                            <span>Contact &amp; Hotline</span>
                        </div>
                        @if(request()->is('admin/contact')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span> @endif
                    </a>

                    <a href="/admin/messages" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/messages') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">✉️</span>
                            <span>Inbox &amp; Inquiries</span>
                        </div>
                        @if(request()->is('admin/messages')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span> @endif
                    </a>

                    <a href="/admin/volunteer" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/volunteer') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">💜</span>
                            <span>Volunteer Desk</span>
                        </div>
                        @if(request()->is('admin/volunteer')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span> @endif
                    </a>

                    <a href="/admin/donate" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/donate') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">✨</span>
                            <span>Donation Page Copy</span>
                        </div>
                        @if(request()->is('admin/donate')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span> @endif
                    </a>

                    <a href="/admin/donations" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl transition-all text-xs font-semibold {{ request()->is('admin/donations') ? 'bg-white/15 text-white shadow-sm border border-white/10' : 'text-white/70 hover:text-white hover:bg-white/5' }}">
                        <div class="flex items-center gap-3">
                            <span class="text-base group-hover:scale-110 transition-transform">💰</span>
                            <span>Donation Ledger</span>
                        </div>
                        @if(request()->is('admin/donations')) <span class="w-1.5 h-1.5 rounded-full bg-purple-400"></span> @endif
                    </a>
                </div>

            </nav>

            <!-- FOOTER USER BAR -->
            <div class="p-5 border-t border-white/5 flex-shrink-0 bg-black/10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-8 h-8 rounded-full bg-white/10 border border-white/10 flex items-center justify-center font-bold text-xs text-sky-200">
                            {{ substr(auth()->user()->name ?? 'AD', 0, 2) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Admin User' }}</p>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-[9px] text-pink-400 hover:text-pink-300 uppercase tracking-widest font-bold cursor-pointer bg-transparent border-0 p-0">
                                    Sign Out ↗
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </aside>

        <!-- MAIN WORKSPACE -->
        <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#FDFCF9]">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>