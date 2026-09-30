<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageProjects extends Component
{
    use WithFileUploads;

    public const MAX_IMAGES = 10;

    /** Trilingual fields shown in the form: key => [label, textarea?] */
    public array $fields = [
        'category'  => ['Category Badge', false],
        'status'    => ['Phase / Status Badge', false],
        'title1'    => ['Title Part 1', false],
        'title2'    => ['Title Part 2 (Gradient / Italic)', false],
        'summary'   => ['Short Card Summary', true],
        'long_desc' => ['Comprehensive Case Study (Modal)', true],
    ];

    public $editingId = null;       // null | 'new' | int
    public array $form = [];
    public bool $isPublished = true;
    public array $existingImages = [];
    public array $removedImages = [];
    public $newImages = [];
    public $uploadBatch = [];   // bound to the file input; appended into $newImages

    public function mount()
    {
        $this->resetForm();
    }

    public function getProjectsProperty()
    {
        return Project::orderBy('order')->orderBy('id')->get();
    }

    private function resetForm(): void
    {
        $this->form = [];
        foreach (array_keys($this->fields) as $f) {
            $this->form[$f] = ['en' => '', 'si' => '', 'ta' => ''];
        }
        $this->isPublished = true;
        $this->existingImages = [];
        $this->removedImages = [];
        $this->newImages = [];
        $this->uploadBatch = [];
        $this->resetValidation();
    }

    public function newProject()
    {
        $this->resetForm();
        $this->editingId = 'new';
    }

    public function editProject($id)
    {
        $project = Project::findOrFail($id);
        $this->resetForm();
        $this->editingId = $project->id;

        foreach (array_keys($this->fields) as $f) {
            foreach (['en', 'si', 'ta'] as $lang) {
                $this->form[$f][$lang] = $project->getTranslation($f, $lang, false) ?: '';
            }
        }
        $this->isPublished = (bool) $project->is_published;
        $this->existingImages = array_values($project->images ?? []);
    }

    public function cancel()
    {
        $this->editingId = null;
        $this->resetForm();
    }

    public function removeExistingImage(int $index)
    {
        if (isset($this->existingImages[$index])) {
            $this->removedImages[] = $this->existingImages[$index];
            unset($this->existingImages[$index]);
            $this->existingImages = array_values($this->existingImages);
        }
    }

    public function updatedUploadBatch()
    {
        $this->validate(['uploadBatch.*' => 'image|max:10240'], [
            'uploadBatch.*.image' => 'Only image files can be uploaded.',
            'uploadBatch.*.max' => 'Each photo must be 10 MB or smaller.',
        ]);
        foreach ((array) $this->uploadBatch as $file) {
            $this->newImages[] = $file;
        }
        $this->uploadBatch = [];
    }

    public function removeNewImage(int $index)
    {
        if (isset($this->newImages[$index])) {
            unset($this->newImages[$index]);
            $this->newImages = array_values($this->newImages);
        }
    }

    public function save()
    {
        $this->validate([
            'form.title1.en' => 'required|string|max:255',
            'newImages.*' => 'image|max:10240',
        ], [
            'form.title1.en.required' => 'An English title is required.',
        ]);

        if (count($this->existingImages) + count($this->newImages) > self::MAX_IMAGES) {
            $this->addError('newImages', 'A project can have up to ' . self::MAX_IMAGES . ' photos.');
            return;
        }

        if ($this->editingId === 'new') {
            $project = new Project();
            $project->order = (Project::max('order') ?? 0) + 1;
        } else {
            $project = Project::findOrFail($this->editingId);
        }

        foreach (array_keys($this->fields) as $f) {
            $project->setTranslations($f, array_map(fn ($v) => $v ?? '', $this->form[$f]));
        }

        $images = $this->existingImages;
        foreach ($this->newImages as $file) {
            $images[] = \App\Support\Media::store($file, 'projects');
        }
        $project->images = array_values($images);
        $project->is_published = $this->isPublished;
        $project->save();

        $this->deleteStoredFiles($this->removedImages);

        $wasNew = $this->editingId === 'new';
        $this->editingId = null;
        $this->resetForm();

        session()->flash('message', $wasNew ? 'Project added.' : 'Project updated.');
        $this->dispatch('reload-frontend-collection');
    }

    public function togglePublished($id)
    {
        $project = Project::findOrFail($id);
        $project->is_published = !$project->is_published;
        $project->save();
        $this->dispatch('reload-frontend-collection');
    }

    public function move($id, string $direction)
    {
        $list = $this->projects->values();
        $index = $list->search(fn ($p) => $p->id == $id);
        $swap = $direction === 'up' ? $index - 1 : $index + 1;
        if ($index === false || $swap < 0 || $swap >= $list->count()) return;

        $ordered = $list->all();
        [$ordered[$index], $ordered[$swap]] = [$ordered[$swap], $ordered[$index]];
        foreach ($ordered as $i => $p) {
            if ($p->order !== $i + 1) {
                $p->order = $i + 1;
                $p->save();
            }
        }
        $this->dispatch('reload-frontend-collection');
    }

    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $this->deleteStoredFiles($project->images ?? []);
        $project->delete();

        if ($this->editingId == $id) $this->cancel();

        session()->flash('message', 'Project deleted.');
        $this->dispatch('reload-frontend-collection');
    }

    private function deleteStoredFiles(array $paths): void
    {
        foreach ($paths as $path) {
            \App\Support\Media::delete($path);
        }
    }

    public function render()
    {
        return view('livewire.manage-projects')->layout('components.layouts.admin');
    }
}
