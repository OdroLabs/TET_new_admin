<div class="p-8 lg:p-12 bg-[#FDFCF9] min-h-screen">
    <header class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl font-bold text-[#1A365D]">Donation Ledger</h2>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-widest mt-1">Financial Records, Contributions &amp; Bank Verifications</p>
        </div>
        <a href="/admin/donate" class="bg-[#1A365D] hover:bg-slate-800 text-white px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-widest transition-all">
            Edit Page Content ↗
        </a>
    </header>

    @if (session()->has('message'))
        <div class="mb-6 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl">
            {{ session('message') }}
        </div>
    @endif

    <!-- KPI CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <span class="text-[10px] font-black uppercase text-emerald-600 tracking-widest block mb-1">Total Verified Funds</span>
            <p class="font-serif text-3xl font-black text-[#1A365D]">LKR {{ number_format($totalRaised, 2) }}</p>
            <span class="text-[10px] text-slate-400 font-medium">Credited to TET Accounts</span>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <span class="text-[10px] font-black uppercase text-amber-600 tracking-widest block mb-1">Pending Verification</span>
            <p class="font-serif text-3xl font-black text-amber-500">{{ $pendingCount }}</p>
            <span class="text-[10px] text-slate-400 font-medium">Direct Bank Transfers awaiting slip</span>
        </div>

        <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <span class="text-[10px] font-black uppercase text-sky-600 tracking-widest block mb-1">Total Contributors</span>
            <p class="font-serif text-3xl font-black text-sky-900">{{ $totalDonors }}</p>
            <span class="text-[10px] text-slate-400 font-medium">All registered attempts</span>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm mb-6 flex flex-col md:flex-row gap-4 justify-between items-center">
        <div class="w-full md:w-80">
            <input 
                type="text" 
                wire:model.live.debounce.300ms="search" 
                placeholder="Search by Donor, Email or Ref (e.g. TET-DON)..." 
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs outline-none focus:ring-1 focus:ring-[#1A365D]"
            >
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select wire:model.live="statusFilter" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 outline-none">
                <option value="all">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="verified">Verified</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <select wire:model.live="methodFilter" class="px-3 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 outline-none">
                <option value="all">All Payment Types</option>
                <option value="card">Card Payment</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>
        </div>
    </div>

    <!-- DONATIONS TABLE -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-black tracking-wider text-slate-400">
                <tr>
                    <th class="py-4 px-6">Reference</th>
                    <th class="py-4 px-6">Donor Details</th>
                    <th class="py-4 px-6">Amount (LKR)</th>
                    <th class="py-4 px-6">Payment Method</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6">Date</th>
                    <th class="py-4 px-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($donations as $don)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-4 px-6 font-mono font-bold text-[#1A365D]">{{ $don->reference }}</td>
                        <td class="py-4 px-6">
                            <span class="font-bold block text-slate-800">{{ $don->donor_name }}</span>
                            @if($don->donor_email)
                                <span class="text-[10px] text-slate-400">{{ $don->donor_email }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 font-serif font-black text-sm text-[#1A365D]">
                            {{ number_format($don->amount, 2) }}
                        </td>
                        <td class="py-4 px-6">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $don->payment_method === 'card' ? 'bg-sky-50 text-sky-700' : 'bg-pink-50 text-pink-700' }}">
                                {{ $don->payment_method === 'card' ? '💳 Card' : '🏦 Bank Transfer' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($don->status === 'verified')
                                <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-700 font-bold text-[10px]">✓ Verified</span>
                            @elseif($don->status === 'pending')
                                <span class="px-2.5 py-1 rounded-full bg-amber-50 text-amber-700 font-bold text-[10px]">⏳ Pending</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 font-bold text-[10px]">✕ Cancelled</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-slate-400 text-[10px]">{{ $don->created_at->format('M d, Y • h:i A') }}</td>
                        <td class="py-4 px-6 text-right space-x-1">
                            @if($don->status !== 'verified')
                                <button wire:click="updateStatus({{ $don->id }}, 'verified')" class="px-3 py-1 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[10px] transition-all">
                                    Verify
                                </button>
                            @else
                                <button wire:click="updateStatus({{ $don->id }}, 'pending')" class="px-3 py-1 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold text-[10px] transition-all">
                                    Unverify
                                </button>
                            @endif
                            <button wire:click="deleteDonation({{ $don->id }})" wire:confirm="Are you sure you want to remove this record?" class="text-red-500 hover:text-red-700 font-bold px-2 py-1">
                                ✕
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400 font-medium">No donation records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $donations->links() }}
        </div>
    </div>
</div>