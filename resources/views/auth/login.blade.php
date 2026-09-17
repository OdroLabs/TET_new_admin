<!DOCTYPE html>
<html lang="en" class="h-full bg-[#FDFCF9]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In | TET Command Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full font-sans antialiased bg-[#FDFCF9] flex items-center justify-center p-6">
    <div class="w-full max-w-md bg-white rounded-[2.5rem] shadow-2xl border border-slate-200/80 p-10 relative overflow-hidden">
        
        <!-- Header Branding -->
        <div class="text-center mb-10">
            <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-pink-400 via-sky-400 to-indigo-400 p-0.5 shadow-md mx-auto mb-4 flex items-center justify-center">
                <div class="w-full h-full bg-[#1A365D] rounded-full flex items-center justify-center text-sm">
                    🏳️‍⚧️
                </div>
            </div>
            <h1 class="font-serif text-3xl font-bold italic text-[#1A365D]">TET Command</h1>
            <p class="text-[9px] uppercase tracking-[0.3em] text-slate-400 font-black mt-1">Restricted Admin Gateway</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-3 rounded-2xl bg-pink-50 border border-pink-200 text-pink-700 text-xs font-semibold text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/admin/login" class="space-y-6">
            @csrf

            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Admin Email</label>
                <input 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="admin@tet.lk" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#1A365D] transition-all"
                >
            </div>

            <div>
                <label class="text-[10px] font-black uppercase text-slate-400 tracking-widest block mb-2">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    required 
                    placeholder="••••••••••••" 
                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3.5 text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#1A365D] transition-all"
                >
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium">
                    <input type="checkbox" name="remember" class="accent-[#1A365D] w-4 h-4 rounded">
                    <span>Remember this device</span>
                </label>
            </div>

            <button 
                type="submit" 
                class="w-full bg-[#1A365D] hover:bg-slate-800 text-white py-4 rounded-full font-bold text-xs uppercase tracking-[0.25em] shadow-xl hover:shadow-2xl transition-all cursor-pointer mt-2"
            >
                Sign In to Command Center
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                Trans Equality Trust • Secure Portal
            </p>
        </div>
    </div>
</body>
</html>