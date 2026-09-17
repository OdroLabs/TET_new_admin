<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ManageAboutPage extends Component
{
    use WithFileUploads;

    public $state = [];
    public $about_hero_image;
    public $about_leader_image;
    public $about_team_group_image;
    public $existing = [];

    protected $textKeys = [
        'about_hero_label', 'about_hero_title', 'about_hero_description',
        'about_vision_title', 'about_vision_text', 'about_mission_title', 'about_mission_text',
        'about_values_main_title',
        'about_value_1_title', 'about_value_1_text',
        'about_value_2_title', 'about_value_2_text',
        'about_value_3_title', 'about_value_3_text',
        'about_value_4_title', 'about_value_4_text',
        'about_leader_label', 'about_leader_name', 'about_leader_role', 'about_leader_bio',
        'about_leader_stat1_val', 'about_leader_stat1_label',
        'about_leader_stat2_val', 'about_leader_stat2_label',
        'about_team_label', 'about_team_title', 'about_team_desc'
    ];

    public function mount()
    {
        foreach ($this->textKeys as $key) {
            $setting = Setting::where('key', $key)->first();
       $this->state[$key] = [
    'en' => $setting ? $setting->getTranslation('value', 'en', false) : '',
    'si' => $setting ? $setting->getTranslation('value', 'si', false) : '',
    'ta' => $setting ? $setting->getTranslation('value', 'ta', false) : '',
];
        }

        $this->existing['about_hero_image'] = $this->cleanImagePath(Setting::where('key', 'about_hero_image')->first()?->value);
        $this->existing['about_leader_image'] = $this->cleanImagePath(Setting::where('key', 'about_leader_image')->first()?->value);
        $this->existing['about_team_group_image'] = $this->cleanImagePath(Setting::where('key', 'about_team_group_image')->first()?->value);
    }

 private function cleanImagePath($val): ?string
{
    if (!$val) return null;

    // If it's already an array
    if (is_array($val)) {
        return $val['en'] ?? reset($val) ?? null;
    }

    // If it's a JSON string
    if (is_string($val) && (str_starts_with($val, '{') || str_starts_with($val, '['))) {
        $decoded = json_decode($val, true);
        if (is_array($decoded)) {
            return $decoded['en'] ?? reset($decoded) ?? null;
        }
    }

    // Clean standard string path
    return trim($val, "\"'");
}

    public function getFullPreviewStateProperty(): array
    {
        // MERGE existing saved images so they are NEVER omitted from the preview
        $previewData = array_merge($this->existing, $this->state);

        if ($this->about_hero_image && method_exists($this->about_hero_image, 'temporaryUrl')) {
            $previewData['about_hero_image'] = $this->about_hero_image->temporaryUrl();
        }
        if ($this->about_leader_image && method_exists($this->about_leader_image, 'temporaryUrl')) {
            $previewData['about_leader_image'] = $this->about_leader_image->temporaryUrl();
        }
        if ($this->about_team_group_image && method_exists($this->about_team_group_image, 'temporaryUrl')) {
            $previewData['about_team_group_image'] = $this->about_team_group_image->temporaryUrl();
        }

        return $previewData;
    }

    public function updated($propertyName)
    {
        $targetSection = 'about-hero';
        if (str_contains($propertyName, 'vision') || str_contains($propertyName, 'mission')) {
            $targetSection = 'about-vision';
        } elseif (str_contains($propertyName, 'value')) {
            $targetSection = 'about-values';
        } elseif (str_contains($propertyName, 'leader')) {
            $targetSection = 'about-leader';
        } elseif (str_contains($propertyName, 'team')) {
            $targetSection = 'about-team';
        }

        $this->dispatch('content-updated', [
            'state' => $this->full_preview_state,
            'targetSection' => $targetSection,
        ]);
    }

    public function syncIframe()
    {
        $this->dispatch('content-updated', [
            'state' => $this->full_preview_state,
            'targetSection' => 'about-hero',
        ]);
    }

    public function save()
    {
        $this->validate([
            'about_hero_image' => 'nullable|image|max:10240',
            'about_leader_image' => 'nullable|image|max:10240',
            'about_team_group_image' => 'nullable|image|max:10240',
        ]);

        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }

        $this->uploadImage('about_hero_image');
        $this->uploadImage('about_leader_image');
        $this->uploadImage('about_team_group_image');

        Cache::forget('api_settings_map');

        session()->flash('message', 'About page successfully published!');

        // Dispatch reload and synchronized state to iframe
        $this->dispatch('settings-published', [
            'state' => $this->full_preview_state
        ]);
    }

    private function uploadImage($field)
    {
        if ($this->$field) {
            $path = $this->$field->store('about', 'public');

            Setting::updateOrCreate(
                ['key' => $field],
                ['value' => $path]
            );

            $this->existing[$field] = $path;
            $this->$field = null;
        }
    }

    public function render()
    {
        return view('livewire.manage-about-page')->layout('components.layouts.admin');
    }
}