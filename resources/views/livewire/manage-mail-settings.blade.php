<div class="h-screen overflow-y-auto p-8 lg:p-12 bg-[#FDFCF9]">
    <div class="max-w-3xl">
        <header class="mb-8">
            <h2 class="font-serif text-3xl font-bold text-[#1A365D]">Email &amp; SMTP</h2>
            <p class="text-slate-400 text-xs font-semibold uppercase tracking-widest mt-1">Who gets notified when visitors submit website forms</p>
        </header>

        @if (session()->has('message'))
            <div class="mb-6 p-3 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-xl">{{ session('message') }}</div>
        @endif

        @if ($testResult)
            <div class="mb-6 p-3 text-xs font-semibold rounded-xl border break-words {{ $testOk ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-red-50 border-red-200 text-red-700' }}">
                {{ $testResult }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-8 pb-24">

            <!-- MASTER SWITCH -->
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-sm font-bold text-[#1A365D]">Send notification emails</h3>
                    <p class="text-xs text-slate-500 mt-1">When off, form submissions are still saved in the admin — just no email goes out.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" wire:model="isEnabled" class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:bg-emerald-500 transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-5"></div>
                </label>
            </div>

            <!-- RECIPIENTS -->
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm space-y-6">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-pink-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">01. Recipients</h3>
                </div>

                @foreach([['to', 'newTo', 'addTo', 'removeTo', 'To', 'Main recipients'], ['cc', 'newCc', 'addCc', 'removeCc', 'CC', 'Copied on every notification (optional)']] as $row)
                    @php [$list, $input, $add, $remove, $label, $hint] = $row; @endphp
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">{{ $label }} <span class="normal-case tracking-normal font-semibold">— {{ $hint }}</span></label>

                        <div class="flex flex-wrap gap-2 min-h-[2rem]">
                            @forelse($this->{$list} as $i => $email)
                                <span wire:key="{{ $list }}-{{ $i }}-{{ $email }}" class="inline-flex items-center gap-1.5 pl-3 pr-1.5 py-1 rounded-full text-xs font-semibold {{ $list === 'to' ? 'bg-sky-50 text-sky-900 border border-sky-200' : 'bg-slate-100 text-slate-700 border border-slate-200' }}">
                                    {{ $email }}
                                    <button type="button" wire:click="{{ $remove }}({{ $i }})" class="w-5 h-5 rounded-full hover:bg-red-100 hover:text-red-600 text-[10px] cursor-pointer" title="Remove">✕</button>
                                </span>
                            @empty
                                <span class="text-xs text-slate-400 italic py-1">No {{ $label }} addresses yet.</span>
                            @endforelse
                        </div>

                        <div class="flex gap-2">
                            <input type="text" wire:model="{{ $input }}" wire:keydown.enter.prevent="{{ $add }}"
                                placeholder="name@example.com — separate several with commas"
                                class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                            <button type="button" wire:click="{{ $add }}" class="px-4 py-2 bg-[#1A365D] hover:bg-slate-800 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest cursor-pointer">+ Add</button>
                        </div>
                        @error($input) <span class="text-[10px] text-red-500 font-bold block">{{ $message }}</span> @enderror
                        @error($list) <span class="text-[10px] text-red-500 font-bold block">{{ $message }}</span> @enderror
                        @error($list . '.*') <span class="text-[10px] text-red-500 font-bold block">{{ $message }}</span> @enderror
                    </div>
                @endforeach

                <div class="pt-4 border-t border-slate-100 space-y-2">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">Notify for</label>
                    <div class="flex flex-wrap gap-4 text-xs font-semibold text-sky-950">
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" wire:model="notifyContact" class="accent-pink-600 w-4 h-4"> Contact messages</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" wire:model="notifyInquiries" class="accent-pink-600 w-4 h-4"> Orders &amp; hall bookings</label>
                        <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" wire:model="notifyDonations" class="accent-pink-600 w-4 h-4"> Donation pledges</label>
                    </div>
                </div>
            </div>

            <!-- SMTP SERVER -->
            <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm space-y-5">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <h3 class="text-[10px] font-black uppercase text-[#1A365D] tracking-wider">02. SMTP Server</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    <div class="md:col-span-3">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Host</label>
                        <input type="text" wire:model="host" placeholder="smtp.gmail.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                        @error('host') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Port</label>
                        <input type="number" wire:model="port" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                        @error('port') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Encryption</label>
                        <select wire:model="encryption" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                            <option value="tls">TLS / STARTTLS (587)</option>
                            <option value="ssl">SSL (465)</option>
                            <option value="none">None (25)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Username</label>
                        <input type="text" wire:model="username" autocomplete="off" placeholder="usually the full email address" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">Password</label>
                        <input type="password" wire:model="password" autocomplete="new-password"
                            placeholder="{{ $hasPassword ? '•••••••• saved — leave blank to keep' : 'SMTP / app password' }}"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                        @if($hasPassword)
                            <button type="button" wire:click="clearPassword" class="text-[9px] text-red-500 hover:underline font-bold mt-1 cursor-pointer">Remove saved password</button>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">From address</label>
                        <input type="email" wire:model="fromAddress" placeholder="no-reply@transequalitytrust.lk" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                        @error('fromAddress') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block mb-1">From name</label>
                        <input type="text" wire:model="fromName" placeholder="Trans Equality Trust" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-[#1A365D]">
                    </div>
                </div>

                <p class="text-[10px] text-slate-400 leading-relaxed">
                    Gmail / Google Workspace: host <b>smtp.gmail.com</b>, port 587, TLS, and an <b>App Password</b> (not the normal login password). The password is stored encrypted.
                </p>
            </div>

            <!-- ACTIONS -->
            <div class="sticky bottom-6 z-30 flex flex-col sm:flex-row gap-3">
                <button type="button" wire:click="sendTest" wire:loading.attr="disabled" wire:target="sendTest, save"
                    class="sm:w-1/3 bg-white hover:bg-slate-50 border border-slate-300 disabled:opacity-50 text-[#1A365D] py-4 rounded-full font-bold text-xs uppercase tracking-[0.2em] shadow-lg cursor-pointer">
                    <span wire:loading.remove wire:target="sendTest">Save &amp; Send Test</span>
                    <span wire:loading wire:target="sendTest">Sending...</span>
                </button>
                <button type="submit" wire:loading.attr="disabled" wire:target="sendTest, save"
                    class="flex-1 bg-[#1A365D] hover:bg-slate-800 disabled:opacity-50 text-white py-4 rounded-full font-bold text-xs uppercase tracking-[0.25em] shadow-xl cursor-pointer">
                    <span wire:loading.remove wire:target="save">Save Email Settings</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
