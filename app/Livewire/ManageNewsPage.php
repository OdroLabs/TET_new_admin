<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Activity;
use App\Models\Setting;

class ManageNewsPage extends Component
{
    use WithFileUploads;

    // Header State
    public $state = [];

    // Active Activity Editing (Category removed, Title is primary)
    public $editingId = null;
    public $activityState = [
        'title' => ['en' => '', 'si' => '', 'ta' => ''],
        'date' => '',
        'location' => ['en' => '', 'si' => '', 'ta' => ''],
        'excerpt' => ['en' => '', 'si' => '', 'ta' => ''],
        'full_story' => ['en' => '', 'si' => '', 'ta' => ''],
    ];
    public $activityImage;
    public $existingActivityImage;

    protected $headerKeys = [
        'act_hero_label', 'act_hero_title1', 'act_hero_title2', 'act_hero_desc'
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

    public function getActivitiesProperty()
    {
        return Activity::orderBy('order', 'asc')->get();
    }

    // ➕ New Activity Form
    public function newActivity()
    {
        $this->editingId = 'new';
        $this->activityState = [
            'title' => ['en' => '', 'si' => '', 'ta' => ''],
            'date' => 'Today • ' . date('M d, Y'),
            'location' => ['en' => 'Colombo, Sri Lanka', 'si' => '', 'ta' => ''],
            'excerpt' => ['en' => '', 'si' => '', 'ta' => ''],
            'full_story' => ['en' => '', 'si' => '', 'ta' => ''],
        ];
        $this->activityImage = null;
        $this->existingActivityImage = null;

        $this->dispatch('content-updated', [
            'state' => $this->state,
            'targetSection' => 'news-grid',
        ]);
    }

    // ✏️ Edit Existing Activity
    public function editActivity($id)
    {
        $act = Activity::findOrFail($id);
        $this->editingId = $id;
        $this->activityState = [
            'title' => [
                'en' => $act->getTranslation('title', 'en') ?: '',
                'si' => $act->getTranslation('title', 'si') ?: '',
                'ta' => $act->getTranslation('title', 'ta') ?: '',
            ],
            'date' => $act->date ?: '',
            'location' => [
                'en' => $act->getTranslation('location', 'en') ?: '',
                'si' => $act->getTranslation('location', 'si') ?: '',
                'ta' => $act->getTranslation('location', 'ta') ?: '',
            ],
            'excerpt' => [
                'en' => $act->getTranslation('excerpt', 'en') ?: '',
                'si' => $act->getTranslation('excerpt', 'si') ?: '',
                'ta' => $act->getTranslation('excerpt', 'ta') ?: '',
            ],
            'full_story' => [
                'en' => $act->getTranslation('full_story', 'en') ?: '',
                'si' => $act->getTranslation('full_story', 'si') ?: '',
                'ta' => $act->getTranslation('full_story', 'ta') ?: '',
            ],
        ];
        $this->existingActivityImage = $act->image;
        $this->activityImage = null;

        $this->dispatch('content-updated', [
            'state' => $this->state,
            'targetSection' => 'news-grid',
            'activityId' => $id,
        ]);
    }

    // 💾 Save Activity
    public function saveActivity()
    {
        if ($this->editingId === 'new') {
            $act = new Activity();
            $act->order = (Activity::max('order') ?? 0) + 1;
            $act->cat = ['en' => 'Field Aid'];
        } else {
            $act = Activity::findOrFail($this->editingId);
        }

        foreach (['title', 'location', 'excerpt', 'full_story'] as $field) {
            foreach ($this->activityState[$field] as $lang => $val) {
                $act->setTranslation($field, $lang, $val ?? '');
            }
        }
        $act->date = $this->activityState['date'] ?? 'Today';

        if ($this->activityImage) {
            $act->image = $this->activityImage->store('news', 'public');
        }

        $act->save();
        $this->editingId = null;
        $this->activityImage = null;

        session()->flash('message', 'Activity successfully saved!');
        $this->dispatch('reload-frontend-collection');
    }

    // 🗑️ Delete Activity
    public function deleteActivity($id)
    {
        Activity::findOrFail($id)->delete();
        session()->flash('message', 'Activity removed!');
        $this->dispatch('reload-frontend-collection');
    }

    // Save Header Settings
    public function saveHeaders()
    {
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }
        session()->flash('message', 'Header settings published!');
    }

    public function updated($propertyName)
    {
        $previewData = $this->state;
        $this->dispatch('content-updated', [
            'state' => $previewData,
            'activityId' => is_numeric($this->editingId) ? $this->editingId : null,
        ]);
    }

    public function render()
    {
        return view('livewire.manage-news-page')->layout('components.layouts.admin');
    }
}