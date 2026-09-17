<div class="p-8 lg:p-12 bg-[#FDFCF9] min-h-screen">
    <header class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold text-[#1A365D]">Messages &amp; Inquiries Inbox</h2>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-widest mt-1">Direct Inquiries Received via Public Contact Desk</p>
        </div>
        <a href="/admin/contact" class="bg-[#1A365D] hover:bg-slate-800 text-white px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest transition-all">
            Edit Page Copy ↗
        </a>
    </header>

    @if (session()->has('message'))
        <div class="mb-6 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <!-- FILTER BAR -->
    <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Search by sender, email, ref, or keyword..." 
            class="w-full md:w-80 px-4 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-1 focus:ring-[#1A365D]"
        >

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select wire:model.live="statusFilter" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 outline-none">
                <option value="all">All Inquiries</option>
                <option value="unread">Unread Only</option>
                <option value="replied">Replied</option>
                <option value="archived">Archived</option>
            </select>
        </div>
    </div>

    <!-- MESSAGES TABLE -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider text-slate-400">
                <tr>
                    <th class="py-4 px-6">Reference</th>
                    <th class="py-4 px-6">Sender Details</th>
                    <th class="py-4 px-6">Subject / Message</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6">Received</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($messages as $msg)
                    <tr class="hover:bg-slate-50/60 transition-colors {{ $msg->status === 'unread' ? 'bg-sky-50/20 font-medium' : '' }}">
                        <td class="py-4 px-6 font-mono font-bold text-[#1A365D]">{{ $msg->reference }}</td>
                        <td class="py-4 px-6">
                            <span class="font-bold block text-slate-800">{{ $msg->name }}</span>
                            <a href="mailto:{{ $msg->email }}?subject=Re: {{ $msg->subject }} [{{ $msg->reference }}]" class="text-[10px] text-sky-600 hover:underline">
                                {{ $msg->email }}
                            </a>
                            @if($msg->phone)
                                <span class="text-[10px] text-slate-400 block">📞 {{ $msg->phone }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <span class="font-bold text-slate-900 block">{{ $msg->subject ?: 'General Inquiry' }}</span>
                            <p class="text-[11px] text-slate-600 mt-0.5 max-w-md whitespace-pre-line">{{ $msg->message }}</p>
                        </td>
                        <td class="py-4 px-6">
                            @if($msg->status === 'unread')
                                <span class="px-2.5 py-1 rounded-full bg-pink-100 text-pink-700 font-bold text-[10px]">● Unread</span>
                            @elseif($msg->status === 'replied')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px]">✓ Replied</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px]">Archived</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-400 text-[10px]">{{ $msg->created_at->format('M d, Y • h:i A') }}</td>
                        <td class="py-4 px-6 text-right space-x-1 whitespace-nowrap">
                            <a 
                                href="mailto:{{ $msg->email }}?subject=Re: {{ $msg->subject }} [{{ $msg->reference }}]"
                                wire:click="updateStatus({{ $msg->id }}, 'replied')"
                                class="px-3 py-1 rounded-full bg-[#1A365D] hover:bg-slate-800 text-white font-bold text-[10px] inline-block"
                            >
                                Reply ✉️
                            </a>
                            <button wire:click="deleteMessage({{ $msg->id }})" wire:confirm="Remove this message record?" class="text-red-500 hover:text-red-700 font-bold px-2 py-1 cursor-pointer">
                                ✕
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400 font-medium">No messages in inbox.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $messages->links() }}
        </div>
    </div>
</div>