<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class ManageProjectsPage extends Component
{
    use WithFileUploads;

    public $state = [];
    public $images = []; 
    public $existing = [];

    protected $textKeys = [
        // Hero
        'pj_hero_label', 'pj_hero_title1', 'pj_hero_title2', 'pj_hero_desc',
        // CTA
        'pj_cta_title', 'pj_cta_desc'
    ];

    public function mount()
    {
        // 1. Base text keys
        foreach ($this->textKeys as $key) { 
            $this->loadKey($key); 
        }

        // 2. Project card keys (1 to 4)
        for ($p = 1; $p <= 4; $p++) {
            $this->loadKey("pj_{$p}_cat");
            $this->loadKey("pj_{$p}_title1");
            $this->loadKey("pj_{$p}_title2");
            $this->loadKey("pj_{$p}_desc");
            $this->loadKey("pj_{$p}_long_desc"); 
            $this->loadKey("pj_{$p}_status");

            for ($img = 1; $img <= 3; $img++) {
                $imgKey = "pj_{$p}_img{$img}";
                $this->existing[$imgKey] = $this->cleanImagePath(Setting::where('key', $imgKey)->first()?->value);
            }
        }
    }

    private function cleanImagePath($val): ?string
    {
        if (!$val) return null;
        if (is_array($val)) return $val['en'] ?? reset($val) ?? null;

        if (is_string($val) && (str_starts_with($val, '{') || str_starts_with($val, '['))) {
            $decoded = json_decode($val, true);
            if (is_array($decoded)) return $decoded['en'] ?? reset($decoded) ?? null;
        }
        return trim($val, "\"'");
    }

    private function loadKey($key)
    {
        $setting = Setting::where('key', $key)->first();
        $this->state[$key] = [
            'en' => $setting ? $setting->getTranslation('value', 'en', false) : '',
            'si' => $setting ? $setting->getTranslation('value', 'si', false) : '',
            'ta' => $setting ? $setting->getTranslation('value', 'ta', false) : '',
        ];
    }

    public function getFullPreviewStateProperty(): array
    {
        // ✅ CRUCIAL FIX: Merge existing images with text so images never disappear while typing
        $previewData = array_merge($this->existing, $this->state);

        foreach ($this->images as $key => $file) {
            if ($file && method_exists($file, 'temporaryUrl')) {
                $previewData[$key] = $file->temporaryUrl();
            }
        }

        return $previewData;
    }

    public function updated($propertyName)
    {
        $targetSection = 'projects-hero';
        $cardIndex = null;

        if (str_contains($propertyName, 'pj_') && preg_match('/pj_(\d+)/', $propertyName, $matches)) {
            $targetSection = 'projects-grid';
            $cardIndex = (int) $matches[1];
        } elseif (str_contains($propertyName, 'cta')) {
            $targetSection = 'projects-cta';
        }

        $this->dispatch('content-updated', [
            'state' => $this->full_preview_state,
            'targetSection' => $targetSection,
            'cardIndex' => $cardIndex,
        ]);
    }

    public function save()
    {
        // Validate uploads
        $this->validate([
            'images.*' => 'nullable|image|max:10240',
        ]);

        // 1. Save text fields
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }

        // 2. Save images safely (Prevents id wipeout)
        foreach ($this->images as $key => $file) {
            if ($file) {
                $path = $file->store('projects', 'public');
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $path]
                );
                $this->existing[$key] = $path;
            }
        }
        $this->images = [];

        // ✅ CRUCIAL FIX: Invalidate settings cache
        Cache::forget('api_settings_map');

        // ✅ CRUCIAL FIX: Notify preview iframe to reload settings
        $this->dispatch('settings-published', [
            'state' => $this->full_preview_state,
            'targetSection' => 'projects-hero',
        ]);

        session()->flash('message', 'Project portfolio & modal details saved successfully!');
    }

    public function render()
    {
        return view('livewire.manage-projects-page')->layout('components.layouts.admin');
    }
}