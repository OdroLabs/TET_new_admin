<?php

namespace App\Livewire;

use App\Models\Service;
use App\Support\Media;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageServices extends Component
{
    use WithFileUploads;

    /** Trilingual fields shown in the form: key => [label, textarea?] */
    public array $fields = [
        'tag'         => ['Category Tag', false],
        'title'       => ['Service Title', false],
        'description' => ['Service Description', true],
    ];

    public $editingId = null;       // null | 'new' | int
    public array $form = [];
    public bool $isPublished = true;
    public ?string $existingImage = null;
    public bool $removeImage = false;
    public $newImage;

    public function mount()
    {
        $this->resetForm();
    }

    public function getServicesProperty()
    {
        return Service::orderBy('order')->orderBy('id')->get();
    }

    private function resetForm(): void
    {
        $this->form = [];
        foreach (array_keys($this->fields) as $f) {
            $this->form[$f] = ['en' => '', 'si' => '', 'ta' => ''];
        }
        $this->isPublished = true;
        $this->existingImage = null;
        $this->removeImage = false;
        $this->newImage = null;
        $this->resetValidation();
    }

    public function newService()
    {
        $this->resetForm();
        $this->editingId = 'new';
    }

    public function editService($id)
    {
        $service = Service::findOrFail($id);
        $this->resetForm();
        $this->editingId = $service->id;

        foreach (array_keys($this->fields) as $f) {
            foreach (['en', 'si', 'ta'] as $lang) {
                $this->form[$f][$lang] = $service->getTranslation($f, $lang, false) ?: '';
            }
        }
        $this->isPublished = (bool) $service->is_published;
        $this->existingImage = $service->image;
    }

    public function cancel()
    {
        $this->editingId = null;
        $this->resetForm();
    }

    public function clearImage()
    {
        $this->newImage = null;
        if ($this->existingImage) $this->removeImage = true;
    }

    public function save()
    {
        $this->validate([
            'form.title.en' => 'required|string|max:255',
            'newImage' => 'nullable|image|max:10240',
        ], [
            'form.title.en.required' => 'An English title is required.',
        ]);

        if ($this->editingId === 'new') {
            $service = new Service();
            $service->order = (Service::max('order') ?? 0) + 1;
        } else {
            $service = Service::findOrFail($this->editingId);
        }

        foreach (array_keys($this->fields) as $f) {
            $service->setTranslations($f, array_map(fn ($v) => $v ?? '', $this->form[$f]));
        }

        $old = $service->image;
        if ($this->newImage) {
            $service->image = Media::store($this->newImage, 'services');
        } elseif ($this->removeImage) {
            $service->image = null;
        }
        $service->is_published = $this->isPublished;
        $service->save();

        if ($old && $old !== $service->image) {
            Media::delete($old);
        }

        $wasNew = $this->editingId === 'new';
        $this->editingId = null;
        $this->resetForm();

        session()->flash('message', $wasNew ? 'Service added.' : 'Service updated.');
        $this->dispatch('reload-frontend-collection');
    }

    public function togglePublished($id)
    {
        $service = Service::findOrFail($id);
        $service->is_published = !$service->is_published;
        $service->save();
        $this->dispatch('reload-frontend-collection');
    }

    public function move($id, string $direction)
    {
        $list = $this->services->values();
        $index = $list->search(fn ($s) => $s->id == $id);
        $swap = $direction === 'up' ? $index - 1 : $index + 1;
        if ($index === false || $swap < 0 || $swap >= $list->count()) return;

        $ordered = $list->all();
        [$ordered[$index], $ordered[$swap]] = [$ordered[$swap], $ordered[$index]];
        foreach ($ordered as $i => $s) {
            if ($s->order !== $i + 1) {
                $s->order = $i + 1;
                $s->save();
            }
        }
        $this->dispatch('reload-frontend-collection');
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        Media::delete($service->image);
        $service->delete();

        if ($this->editingId == $id) $this->cancel();

        session()->flash('message', 'Service deleted.');
        $this->dispatch('reload-frontend-collection');
    }

    public function render()
    {
        return view('livewire.manage-services')->layout('components.layouts.admin');
    }
}
