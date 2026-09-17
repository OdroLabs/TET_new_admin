<div class="p-8 lg:p-12 bg-[#FDFCF9] min-h-screen">
    <header class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold text-[#1A365D]">Products Catalog</h2>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-widest mt-1">Sexual Health &amp; Wellness Products Enterprise</p>
        </div>
        <button 
            type="button" 
            wire:click="newProduct" 
            class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest transition-all shadow-md cursor-pointer"
        >
            + Add New Product
        </button>
    </header>

    @if (session()->has('message'))
        <div class="mb-6 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <!-- ACTIVE FORM (CREATE / EDIT) -->
    @if($editingId)
        <div class="mb-10 p-6 md:p-8 bg-white rounded-3xl border border-pink-200 shadow-md space-y-6">
            <div class="flex items-center justify-between border-b border-pink-100 pb-3">
                <span class="text-xs font-black text-pink-900 uppercase tracking-widest">
                    {{ $editingId === 'new' ? 'Add New Enterprise Product' : 'Edit Product #' . $editingId }}
                </span>
                <button type="button" wire:click="$set('editingId', null)" class="text-xs text-slate-400 hover:text-slate-600 font-bold cursor-pointer">✕ Cancel</button>
            </div>

            <!-- Title -->
            <div class="space-y-2">
                <label class="text-[9px] font-black text-[#1A365D] uppercase tracking-widest block">Product Title</label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <input type="text" wire:model="productState.title.en" placeholder="English Title" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                    <input type="text" wire:model="productState.title.si" placeholder="සිංහල මාතෘකාව" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                    <input type="text" wire:model="productState.title.ta" placeholder="தமிழ் தலைப்பு" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:ring-1 focus:ring-pink-400">
                </div>
            </div>

            <!-- Price, Currency, Specs, Badge, Icon -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Price (LKR)</label>
                    <input type="number" step="0.50" wire:model="productState.price" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none font-bold text-sky-950">
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Currency</label>
                    <input type="text" wire:model="productState.currency" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Specs / Quantity</label>
                    <input type="text" wire:model="productState.specs" placeholder="e.g. Box of 3 • 12s" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Badge Tag</label>
                    <input type="text" wire:model="productState.badge" placeholder="e.g. Top Seller" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none">
                </div>
                <div>
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Icon (Emoji)</label>
                    <input type="text" wire:model="productState.icon" placeholder="🛡️" class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none text-center">
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Description</label>
                <div class="space-y-2">
                    <textarea wire:model="productState.description.en" placeholder="English description..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs h-16 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                    <textarea wire:model="productState.description.si" placeholder="සිංහල විස්තරය..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs h-14 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                    <textarea wire:model="productState.description.ta" placeholder="தமிழ் விளக்கம்..." class="w-full border border-slate-200 rounded-xl px-3 py-2 text-xs h-14 outline-none focus:ring-1 focus:ring-pink-400"></textarea>
                </div>
            </div>

            <!-- Photo Upload & Status -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-2 border-t border-slate-100">
                <div>
                    <label class="text-[9px] font-bold uppercase text-slate-400 block mb-1">Product Photo (Optional)</label>
                    <input type="file" wire:model="productImage" class="text-xs">
                </div>
                <label class="flex items-center gap-2 cursor-pointer font-bold text-xs text-sky-950">
                    <input type="checkbox" wire:model="productState.is_available" class="accent-pink-600 w-4 h-4">
                    <span>Available in Store</span>
                </label>
            </div>

            <button 
                type="button" 
                wire:click="saveProduct" 
                class="w-full bg-[#1A365D] hover:bg-slate-800 text-white py-3 rounded-full text-xs font-bold uppercase tracking-widest shadow-md transition-all cursor-pointer"
            >
                Save Product
            </button>
        </div>
    @endif

    <!-- PRODUCTS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($this->products as $prod)
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-3xl">{{ $prod->icon }}</span>
                        @if($prod->badge)
                            <span class="text-[9px] font-bold uppercase tracking-wider text-pink-700 bg-pink-100 px-3 py-1 rounded-full">
                                {{ $prod->badge }}
                            </span>
                        @endif
                    </div>
                    <h3 class="font-serif text-lg font-bold text-[#1A365D] mb-1">
                        {{ $prod->getTranslation('title', 'en') }}
                    </h3>
                    <p class="text-slate-500 text-xs line-clamp-3 mb-3 leading-relaxed">
                        {{ $prod->getTranslation('description', 'en') }}
                    </p>
                    <div class="text-[11px] font-semibold text-sky-800">{{ $prod->specs }}</div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="font-serif text-lg font-black text-[#1A365D]">
                            {{ $prod->currency }} {{ number_format($prod->price, 2) }}
                        </span>
                        <span class="block text-[9px] font-bold {{ $prod->is_available ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $prod->is_available ? '● In Stock' : '○ Out of Stock' }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2">
                        <button 
                            type="button" 
                            wire:click="editProduct({{ $prod->id }})" 
                            class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-[#1A365D] rounded-full text-[10px] font-bold cursor-pointer"
                        >
                            Edit
                        </button>
                        <button 
                            type="button" 
                            wire:confirm="Remove this product from the catalog?"
                            wire:click="deleteProduct({{ $prod->id }})" 
                            class="px-2 py-1 text-red-500 hover:text-red-700 text-[10px] font-bold cursor-pointer"
                        >
                            ✕
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>