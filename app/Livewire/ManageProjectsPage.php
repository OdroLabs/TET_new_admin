<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;

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

        for ($p = 1; $p <= 4; $p++) {
            $this->loadKey("pj_{$p}_cat");
            $this->loadKey("pj_{$p}_title1");
            $this->loadKey("pj_{$p}_title2");
            $this->loadKey("pj_{$p}_desc");
            $this->loadKey("pj_{$p}_long_desc"); 
            $this->loadKey("pj_{$p}_status");

            for ($img = 1; $img <= 3; $img++) {
                $imgKey = "pj_{$p}_img{$img}";
                $this->existing[$imgKey] = Setting::where('key', $imgKey)->first()?->value;
            }
        }
    }

    private function loadKey($key)
    {
        $setting = Setting::where('key', $key)->first();
        $this->state[$key] = [
            'en' => $setting ? $setting->getTranslation('value', 'en') : '',
            'si' => $setting ? $setting->getTranslation('value', 'si') : '',
            'ta' => $setting ? $setting->getTranslation('value', 'ta') : '',
        ];
    }

    public function updated($propertyName)
    {
        $previewData = $this->state;

        // Temporary preview URLs for uploaded gallery images
        foreach ($this->images as $key => $file) {
            if ($file) {
                $previewData[$key] = $file->temporaryUrl();
            }
        }

        // Target Section and Card detection
        $targetSection = 'projects-hero';
        $cardIndex = null;

        if (str_contains($propertyName, 'pj_') && preg_match('/pj_(\d+)/', $propertyName, $matches)) {
            $targetSection = 'projects-grid';
            $cardIndex = (int) $matches[1];
        } elseif (str_contains($propertyName, 'cta')) {
            $targetSection = 'projects-cta';
        }

        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => $targetSection,
            'cardIndex' => $cardIndex,
        ]);
    }

    public function save()
    {
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }

        foreach ($this->images as $key => $file) {
            if ($file) {
                $path = $file->store('projects', 'public');
                $imgSetting = Setting::firstOrNew(['key' => $key]);
                $imgSetting->setRawAttributes(['key' => $key, 'value' => $path]);
                $imgSetting->save();
                $this->existing[$key] = $path;
            }
        }
        $this->images = [];

        session()->flash('message', 'Project portfolio & modal details saved successfully!');
    }

    public function render()
    {
        return view('livewire.manage-projects-page')->layout('components.layouts.admin');
    }
}