<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use App\Models\Setting;

class ManageGalleryPage extends Component
{
    use WithFileUploads;

    // Header State
    public $state = [];

    // Active Event Editing
    public $editingId = null;
    public $eventState = [
        'title' => ['en' => '', 'si' => '', 'ta' => ''],
        'cat' => ['en' => '', 'si' => '', 'ta' => ''],
        'date' => '',
        'location' => ['en' => '', 'si' => '', 'ta' => ''],
        'excerpt' => ['en' => '', 'si' => '', 'ta' => ''],
        'full_story' => ['en' => '', 'si' => '', 'ta' => ''],
    ];

    public $coverImage;
    public $existingCoverImage;

    public $galleryImage1;
    public $galleryImage2;
    public $existingGalleryImages = [];

    protected $headerKeys = [
        'gl_events_tag', 'gl_gallery_title', 'gl_gallery_desc'
    ];

    public function mount()
    {
        foreach ($this->headerKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->state[$key] = [
                'en' => $setting ? $setting->getTranslation('value', 'en') : '',
                'si' => $setting ? $setting->getTranslation('value', 'si') : '',
                'ta' => $setting ? $setting->getTranslation('value', 'ta') : '',
            ];
        }
    }

    public function getEventsProperty()
    {
        return Event::orderBy('order', 'asc')->get();
    }

    // ➕ New Event
    public function newEvent()
    {
        $this->editingId = 'new';
        $this->eventState = [
            'title' => ['en' => '', 'si' => '', 'ta' => ''],
            'cat' => ['en' => 'Community Dialogue', 'si' => '', 'ta' => ''],
            'date' => strtoupper(date('M d, Y')),
            'location' => ['en' => 'Colombo, Sri Lanka', 'si' => '', 'ta' => ''],
            'excerpt' => ['en' => '', 'si' => '', 'ta' => ''],
            'full_story' => ['en' => '', 'si' => '', 'ta' => ''],
        ];
        $this->coverImage = null;
        $this->existingCoverImage = null;
        $this->galleryImage1 = null;
        $this->galleryImage2 = null;
        $this->existingGalleryImages = [];

        $this->dispatch('content-updated', [
            'state' => $this->state,
            'targetSection' => 'gallery-events'
        ]);
    }

    // ✏️ Edit Existing Event
    public function editEvent($id)
    {
        $ev = Event::findOrFail($id);
        $this->editingId = $id;
        $this->eventState = [
            'title' => [
                'en' => $ev->getTranslation('title', 'en') ?: '',
                'si' => $ev->getTranslation('title', 'si') ?: '',
                'ta' => $ev->getTranslation('title', 'ta') ?: '',
            ],
            'cat' => [
                'en' => $ev->getTranslation('cat', 'en') ?: '',
                'si' => $ev->getTranslation('cat', 'si') ?: '',
                'ta' => $ev->getTranslation('cat', 'ta') ?: '',
            ],
            'date' => $ev->date ?: '',
            'location' => [
                'en' => $ev->getTranslation('location', 'en') ?: '',
                'si' => $ev->getTranslation('location', 'si') ?: '',
                'ta' => $ev->getTranslation('location', 'ta') ?: '',
            ],
            'excerpt' => [
                'en' => $ev->getTranslation('excerpt', 'en') ?: '',
                'si' => $ev->getTranslation('excerpt', 'si') ?: '',
                'ta' => $ev->getTranslation('excerpt', 'ta') ?: '',
            ],
            'full_story' => [
                'en' => $ev->getTranslation('full_story', 'en') ?: '',
                'si' => $ev->getTranslation('full_story', 'si') ?: '',
                'ta' => $ev->getTranslation('full_story', 'ta') ?: '',
            ],
        ];

        $this->existingCoverImage = $ev->cover_image;
        $this->existingGalleryImages = $ev->gallery_images ?? [];
        $this->coverImage = null;
        $this->galleryImage1 = null;
        $this->galleryImage2 = null;

        $this->dispatch('content-updated', [
            'state' => $this->state,
            'targetSection' => 'gallery-events',
            'eventId' => $id,
        ]);
    }

    // 💾 Save Event
    public function saveEvent()
    {
        if ($this->editingId === 'new') {
            $ev = new Event();
            $ev->order = (Event::max('order') ?? 0) + 1;
        } else {
            $ev = Event::findOrFail($this->editingId);
        }

        foreach (['title', 'cat', 'location', 'excerpt', 'full_story'] as $field) {
            foreach ($this->eventState[$field] as $lang => $val) {
                $ev->setTranslation($field, $lang, $val ?? '');
            }
        }
        $ev->date = $this->eventState['date'] ?? strtoupper(date('M d, Y'));

        // Handle Cover Image
        if ($this->coverImage) {
            $ev->cover_image = $this->coverImage->store('gallery', 'public');
        }

        // Handle Sub-Gallery Images
        $gallery = $this->existingGalleryImages;
        if ($this->galleryImage1) {
            $gallery[0] = $this->galleryImage1->store('gallery', 'public');
        }
        if ($this->galleryImage2) {
            $gallery[1] = $this->galleryImage2->store('gallery', 'public');
        }
        $ev->gallery_images = array_values(array_filter($gallery));

        $ev->save();
        $this->editingId = null;
        $this->coverImage = null;
        $this->galleryImage1 = null;
        $this->galleryImage2 = null;

        session()->flash('message', 'Event published successfully!');
        $this->dispatch('reload-frontend-collection');
    }

    // 🗑️ Delete Event
    public function deleteEvent($id)
    {
        Event::findOrFail($id)->delete();
        session()->flash('message', 'Event removed!');
        $this->dispatch('reload-frontend-collection');
    }

    // Save Headers
    public function saveHeaders()
    {
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }
        session()->flash('message', 'Header content saved!');
    }

    public function updated($propertyName)
    {
        $previewData = $this->state;
        $this->dispatch('content-updated', [
            'state' => $previewData,
            'eventId' => is_numeric($this->editingId) ? $this->editingId : null,
        ]);
    }

    public function render()
    {
        return view('livewire.manage-gallery-page')->layout('components.layouts.admin');
    }
}