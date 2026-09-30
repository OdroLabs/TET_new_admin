<div class="flex h-screen overflow-hidden bg-[#FDFCF9]">

    <!-- LEFT: PROJECTS MANAGER -->
    <div class="w-full lg:w-[650px] h-full overflow-y-auto p-8 lg:p-10 border-r border-slate-200 scroll-smooth">
        <header class="mb-8 flex items-start justify-between gap-4">
            <div>
                <h2 class="font-serif text-3xl font-bold italic text-[#1A365D]">Projects Manager</h2>
                <p class="text-slate-400 text-[9px] mt-1 font-bold uppercase tracking-widest">Add, edit, reorder &amp; publish project cards</p>
            </div>
            @if(!$editingId)
                <button type="button" wire:click="newProject"
                    class="shrink-0 bg-pink-600 hover:bg-pink-700 text-white px-5 py-2.5 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-md cursor-pointer">
                    + Add Project
                </button>
            @endif
        </header>

        @if (session()->has('message'))
            <div class="mb-6 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold">
                {{ session('message') }}
            </div>
        @endif

        <!-- CREATE / EDIT FORM -->
        @if($editingId)
            <div data-section="projects-grid" @if($editingId !== 'new') data-card="{{ $editingId }}" @endif
                class="mb-10 p-6 bg-white rounded-[2rem] border border-pink-200 shadow-md space-y-5">
                <div class="flex items-center justify-between border-b border-pink-100 pb-3">
                    <span class="text-[10px] font-black text-pink-900 uppercase tracking-widest">
                        {{ $editingId === 'new' ? 'New Project' : 'Edit Project #' . $editingId }}
                    </span>
                    <button type="button" wire:click="cancel" class="text-xs text-slate-400 hover:text-slate-600 font-bold cursor-pointer">✕ Cancel</button>
                </div>

                @foreach($fields as $key => $meta)
                    @php [$label, $isTextarea] = $meta; @endphp
                    <div class="space-y-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">
                            {{ $label }} @if($key === 'title1')<span class="text-pink-600">*</span>@endif
                        </label>
                        @if($isTextarea)
                            <div class="space-y-2">
                                <textarea wire:model="form.{{ $key }}.en" placeholder="English" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs {{ $key === 'long_desc' ? 'h-28' : 'h-16' }} outline-none focus:bg-white focus:ring-1 focus:ring-pink-400"></textarea>
                                <textarea wire:model="form.{{ $key }}.si" placeholder="සිංහල" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs {{ $key === 'long_desc' ? 'h-20' : 'h-14' }} outline-none focus:bg-white focus:ring-1 focus:ring-pink-400"></textarea>
                                <textarea wire:model="form.{{ $key }}.ta" placeholder="தமிழ்" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs {{ $key === 'long_desc' ? 'h-20' : 'h-14' }} outline-none focus:bg-white focus:ring-1 focus:ring-pink-400"></textarea>
                            </div>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                                <input type="text" wire:model="form.{{ $key }}.en" placeholder="English" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-pink-400">
                                <input type="text" wire:model="form.{{ $key }}.si" placeholder="සිංහල" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-pink-400">
                                <input type="text" wire:model="form.{{ $key }}.ta" placeholder="தமிழ்" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs outline-none focus:bg-white focus:ring-1 focus:ring-pink-400">
                            </div>
                        @endif
                        @error("form.{$key}.en") <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                @endforeach

                <!-- PHOTOS -->
                <div class="pt-3 border-t border-slate-100 space-y-3">
                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest block">
                        Photo Gallery ({{ count($existingImages) + count($newImages) }} / {{ \App\Livewire\ManageProjects::MAX_IMAGES }}) — first photo is the cover
                    </label>

                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                        @foreach($existingImages as $i => $path)
                            <div wire:key="existing-{{ $i }}-{{ md5($path) }}" class="relative group">
                                <img src="{{ \App\Models\Project::imageUrl($path) }}" class="w-full h-20 object-cover rounded-xl border border-slate-200">
                                <button type="button" wire:click="removeExistingImage({{ $i }})" title="Remove photo"
                                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-black/60 hover:bg-red-600 text-white text-[10px] font-bold cursor-pointer">✕</button>
                            </div>
                        @endforeach
                        @foreach($newImages as $i => $file)
                            <div wire:key="new-{{ $i }}" class="relative">
                                <img src="{{ $file->temporaryUrl() }}" class="w-full h-20 object-cover rounded-xl border-2 border-pink-300">
                                <span class="absolute bottom-1 left-1 text-[8px] font-bold bg-pink-600 text-white px-1.5 rounded">NEW</span>
                                <button type="button" wire:click="removeNewImage({{ $i }})" title="Remove photo"
                                    class="absolute top-1 right-1 w-6 h-6 rounded-full bg-black/60 hover:bg-red-600 text-white text-[10px] font-bold cursor-pointer">✕</button>
                            </div>
                        @endforeach
                    </div>

                    @if(count($existingImages) + count($newImages) < \App\Livewire\ManageProjects::MAX_IMAGES)
                        <input type="file" wire:model="uploadBatch" multiple accept="image/*" class="text-[10px] w-full">
                        <div wire:loading wire:target="uploadBatch" class="text-[9px] text-pink-600 font-semibold">Uploading...</div>
                    @endif
                    @error('uploadBatch.*') <span class="text-[10px] text-red-500 font-bold block">{{ $message }}</span> @enderror
                    @error('newImages') <span class="text-[10px] text-red-500 font-bold block">{{ $message }}</span> @enderror
                    @error('newImages.*') <span class="text-[10px] text-red-500 font-bold block">{{ $message }}</span> @enderror
                </div>

                <label class="flex items-center gap-2 cursor-pointer font-bold text-xs text-sky-950 pt-2">
                    <input type="checkbox" wire:model="isPublished" class="accent-pink-600 w-4 h-4">
                    <span>Published on website</span>
                </label>

                <button type="button" wire:click="save" wire:loading.attr="disabled" wire:target="save, uploadBatch"
                    class="w-full bg-[#1A365D] hover:bg-slate-800 disabled:opacity-50 text-white py-3.5 rounded-full text-xs font-bold uppercase tracking-widest shadow-md cursor-pointer">
                    <span wire:loading.remove wire:target="save, uploadBatch">{{ $editingId === 'new' ? 'Create Project' : 'Save Changes' }}</span>
                    <span wire:loading wire:target="save">Saving...</span>
                    <span wire:loading wire:target="uploadBatch">Uploading photos...</span>
                </button>
            </div>
        @endif

        <!-- PROJECT LIST -->
        <div data-section="projects-grid" class="space-y-3 pb-20">
            @forelse($this->projects as $index => $project)
                @php $cover = \App\Models\Project::imageUrl(($project->images ?? [])[0] ?? null); @endphp
                <div wire:key="project-{{ $project->id }}" data-card="{{ $project->id }}"
                    class="p-4 bg-white rounded-2xl border {{ $editingId == $project->id ? 'border-pink-300 ring-2 ring-pink-200' : 'border-slate-100' }} shadow-sm flex items-center gap-4">
                    <div class="flex flex-col gap-1">
                        <button type="button" wire:click="move({{ $project->id }}, 'up')" @disabled($index === 0)
                            class="w-6 h-6 rounded-md bg-slate-100 hover:bg-slate-200 disabled:opacity-30 text-[10px] cursor-pointer" title="Move up">▲</button>
                        <button type="button" wire:click="move({{ $project->id }}, 'down')" @disabled($loop->last)
                            class="w-6 h-6 rounded-md bg-slate-100 hover:bg-slate-200 disabled:opacity-30 text-[10px] cursor-pointer" title="Move down">▼</button>
                    </div>

                    @if($cover)
                        <img src="{{ $cover }}" class="w-16 h-16 object-cover rounded-xl border border-slate-100 shrink-0">
                    @else
                        <div class="w-16 h-16 rounded-xl bg-slate-100 shrink-0 flex items-center justify-center text-slate-300 text-lg">📷</div>
                    @endif

                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-sky-700 truncate">{{ $project->getTranslation('category', 'en', false) }}</span>
                        </div>
                        <h3 class="font-serif text-sm font-bold text-[#1A365D] truncate">
                            {{ $project->getTranslation('title1', 'en', false) }} <span class="italic font-normal">{{ $project->getTranslation('title2', 'en', false) }}</span>
                        </h3>
                        <button type="button" wire:click="togglePublished({{ $project->id }})"
                            class="text-[9px] font-bold cursor-pointer hover:underline {{ $project->is_published ? 'text-emerald-600' : 'text-slate-400' }}">
                            {{ $project->is_published ? '● Published' : '○ Hidden' }}
                        </button>
                        <span class="text-[9px] text-slate-400 ml-2">{{ count($project->images ?? []) }} photo(s)</span>
                    </div>

                    <div class="flex items-center gap-1 shrink-0">
                        <button type="button" wire:click="editProject({{ $project->id }})"
                            class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-[#1A365D] rounded-full text-[10px] font-bold cursor-pointer">Edit</button>
                        <button type="button" wire:click="deleteProject({{ $project->id }})"
                            wire:confirm="Delete this project and its photos? This cannot be undone."
                            class="px-2 py-1 text-red-500 hover:text-red-700 text-[10px] font-bold cursor-pointer">✕</button>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center bg-white rounded-2xl border border-dashed border-slate-200 text-xs text-slate-400">
                    No projects yet. Click “+ Add Project” to create the first one.
                </div>
            @endforelse

            <p class="text-[10px] text-slate-400 pt-2">
                Page heading and CTA banner text are edited under <a href="/admin/projects" class="underline font-bold text-[#1A365D]">Projects Page</a>.
            </p>
        </div>
    </div>

    <!-- RIGHT: LIVE PREVIEW -->
    <x-preview-panel :url="env('FRONTEND_URL', 'https://tet-frontend.vercel.app') . '/projects'" />
</div>
