<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Activity;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ManageNewsPage extends Component
{
    use WithFileUploads;

    // Header State
    public $state = [];

    // Active Activity Editing
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
        'act_hero_label',
        'act_hero_title1',
        'act_hero_title2',
        'act_hero_desc'
    ];

    public function mount()
    {
        foreach ($this->headerKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->state[$key] = [
                'en' => $setting ? $setting->getTranslation('value', 'en', false) : '',
                'si' => $setting ? $setting->getTranslation('value', 'si', false) : '',
                'ta' => $setting ? $setting->getTranslation('value', 'ta', false) : '',
            ];
        }
    }

    public function getActivitiesProperty()
    {
        return Activity::orderBy('order', 'asc')->get();
    }

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

    public function editActivity($id)
    {
        $act = Activity::findOrFail($id);
        $this->editingId = $id;
        $this->activityState = [
            'title' => [
                'en' => $act->getTranslation('title', 'en', false) ?: '',
                'si' => $act->getTranslation('title', 'si', false) ?: '',
                'ta' => $act->getTranslation('title', 'ta', false) ?: '',
            ],
            'date' => $act->date ?: '',
            'location' => [
                'en' => $act->getTranslation('location', 'en', false) ?: '',
                'si' => $act->getTranslation('location', 'si', false) ?: '',
                'ta' => $act->getTranslation('location', 'ta', false) ?: '',
            ],
            'excerpt' => [
                'en' => $act->getTranslation('excerpt', 'en', false) ?: '',
                'si' => $act->getTranslation('excerpt', 'si', false) ?: '',
                'ta' => $act->getTranslation('excerpt', 'ta', false) ?: '',
            ],
            'full_story' => [
                'en' => $act->getTranslation('full_story', 'en', false) ?: '',
                'si' => $act->getTranslation('full_story', 'si', false) ?: '',
                'ta' => $act->getTranslation('full_story', 'ta', false) ?: '',
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

    public function saveActivity()
    {
        if ($this->activityImage) {
            $this->validate([
                'activityImage' => 'image|max:10240',
            ]);
        }

        if ($this->editingId === 'new') {
            $act = new Activity();
            $act->order = (Activity::max('order') ?? 0) + 1;
            $act->cat = ['en' => 'Field Aid'];
        } else {
            $act = Activity::findOrFail($this->editingId);
        }

        // ✅ CRUCIAL FIX 1: Set is_published to true so API fetches it
        $act->is_published = true;

        foreach (['title', 'location', 'excerpt', 'full_story'] as $field) {
            foreach ($this->activityState[$field] as $lang => $val) {
                $act->setTranslation($field, $lang, $val ?? '');
            }
        }
        $act->date = $this->activityState['date'] ?? 'Today';

        // Persist new file and delete old file if replaced
        if ($this->activityImage) {
            if ($act->image && Storage::disk('public')->exists($act->image)) {
                Storage::disk('public')->delete($act->image);
            }
            $act->image = $this->activityImage->store('news', 'public');
        }

        $act->save();

        // ✅ CRUCIAL FIX 2: Flush the API activities cache immediately
        Cache::forget('api_activities_list');

        $this->editingId = null;
        $this->activityImage = null;
        $this->existingActivityImage = null;

        session()->flash('message', 'Activity successfully saved!');
        $this->dispatch('reload-frontend-collection');
    }

    public function deleteActivity($id)
    {
        $act = Activity::findOrFail($id);
        if ($act->image && Storage::disk('public')->exists($act->image)) {
            Storage::disk('public')->delete($act->image);
        }
        $act->delete();

        // ✅ CRUCIAL FIX 2: Flush cache on delete
        Cache::forget('api_activities_list');

        session()->flash('message', 'Activity removed!');
        $this->dispatch('reload-frontend-collection');
    }

    public function saveHeaders()
    {
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }

        // Flush API settings cache
        Cache::forget('api_settings_map');

        session()->flash('message', 'Header settings published!');
        $this->dispatch('settings-published', [
            'state' => $this->state,
            'targetSection' => 'news-hero'
        ]);
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