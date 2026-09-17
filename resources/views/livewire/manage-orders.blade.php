<div class="p-8 lg:p-12 bg-[#FDFCF9] min-h-screen">
    <header class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold text-[#1A365D]">Orders &amp; Space Inquiries</h2>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-widest mt-1">Direct Commercial Requests &amp; Venue Bookings</p>
        </div>
    </header>

    @if (session()->has('message'))
        <div class="mb-6 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <span class="text-[10px] font-black uppercase text-pink-600 tracking-widest block mb-1">New / Action Required</span>
            <p class="font-serif text-3xl font-black text-pink-600">{{ $newCount }}</p>
            <span class="text-[10px] text-slate-400">Awaiting phone/email response</span>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <span class="text-[10px] font-black uppercase text-sky-600 tracking-widest block mb-1">Product Orders</span>
            <p class="font-serif text-3xl font-black text-[#1A365D]">{{ $productOrders }}</p>
            <span class="text-[10px] text-slate-400">Condoms &amp; wellness kits</span>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <span class="text-[10px] font-black uppercase text-purple-600 tracking-widest block mb-1">Venue Booking Inquiries</span>
            <p class="font-serif text-3xl font-black text-purple-900">{{ $hallBookings }}</p>
            <span class="text-[10px] text-slate-400">Hall reservations</span>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Search by customer name, phone, item or reference..." 
            class="w-full md:w-80 px-4 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-1 focus:ring-[#1A365D]"
        >

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select wire:model.live="typeFilter" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 outline-none">
                <option value="all">All Request Types</option>
                <option value="product_order">Product Orders</option>
                <option value="hall_booking">Hall Bookings</option>
            </select>

            <select wire:model.live="statusFilter" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 outline-none">
                <option value="all">All Statuses</option>
                <option value="new">New (Unopened)</option>
                <option value="contacted">Contacted</option>
                <option value="completed">Completed</option>
            </select>
        </div>
    </div>

    <!-- INQUIRIES TABLE -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider text-slate-400">
                <tr>
                    <th class="py-4 px-6">Reference</th>
                    <th class="py-4 px-6">Customer</th>
                    <th class="py-4 px-6">Request Item</th>
                    <th class="py-4 px-6">Type</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6">Received</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($inquiries as $inq)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-[#1A365D]">{{ $inq->reference }}</td>
                        <td class="py-4 px-6">
                            <span class="font-bold block text-slate-800">{{ $inq->customer_name }}</span>
                            <span class="text-[10px] text-sky-700 font-semibold block">📞 {{ $inq->customer_phone }}</span>
                            @if($inq->customer_email)
                                <span class="text-[10px] text-slate-400">{{ $inq->customer_email }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-900 block">{{ $inq->item_name ?: 'General Request' }}</span>
                            @if($inq->quantity > 1)
                                <span class="text-[10px] text-slate-400">Qty: {{ $inq->quantity }}</span>
                            @endif
                            @if($inq->message)
                                <p class="text-[11px] text-slate-500 italic mt-0.5 max-w-xs">{{ $inq->message }}</p>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $inq->type === 'product_order' ? 'bg-pink-50 text-pink-700' : 'bg-purple-50 text-purple-700' }}">
                                {{ $inq->type === 'product_order' ? '🛡️ Product' : '🏛️ Venue Hire' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($inq->status === 'new')
                                <span class="px-2.5 py-1 rounded-full bg-pink-100 text-pink-700 font-bold text-[10px]">● New</span>
                            @elseif($inq->status === 'contacted')
                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 font-bold text-[10px]">⏳ Contacted</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px]">✓ Completed</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-400 text-[10px]">{{ $inq->created_at->format('M d, Y • h:i A') }}</td>
                        <td class="py-4 px-6 text-right space-x-1">
                            @if($inq->status === 'new')
                                <button wire:click="updateStatus({{ $inq->id }}, 'contacted')" class="px-3 py-1 rounded-full bg-sky-600 hover:bg-sky-700 text-white font-bold text-[10px]">
                                    Contacted
                                </button>
                            @elseif($inq->status === 'contacted')
                                <button wire:click="updateStatus({{ $inq->id }}, 'completed')" class="px-3 py-1 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px]">
                                    Complete
                                </button>
                            @endif
                            <button wire:click="deleteInquiry({{ $inq->id }})" wire:confirm="Remove this inquiry record?" class="text-red-500 hover:text-red-700 font-bold px-2 py-1">
                                ✕
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 font-medium">No order or venue inquiries found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $inquiries->links() }}
        </div>
    </div>
</div>