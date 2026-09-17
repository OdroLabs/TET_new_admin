<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;

class ManageServicesPage extends Component
{
    use WithFileUploads;

    public $state = [];
    public $urls = [];
    public $hero_bg;
    public $service_images = []; // Uploaded files for 6 services
    public $existing = [];

    protected $textKeys = [
        // 1. Hero
        's_hero_label', 's_hero_title', 's_hero_desc',
        // Request Assistance Button
        'btn_request',
        // 3. Process
        's_process_label', 's_process_title', 's_process_desc',
        // 4. Emergency
        's_emergency_badge', 's_emergency_title', 's_emergency_desc', 's_emergency_phone',
    ];

    public function mount()
    {
        // 1. Base text keys
        foreach ($this->textKeys as $key) {
            $this->loadKey($key);
        }

        // 2. 6 Services
        for ($i = 1; $i <= 6; $i++) {
            $this->loadKey("service_{$i}_title");
            $this->loadKey("service_{$i}_desc");
            $this->loadKey("service_{$i}_tag");
            $this->existing["service_{$i}_img"] = Setting::where('key', "service_{$i}_img")->first()?->value;
        }

        // 3. 3 Process Steps
        for ($i = 1; $i <= 3; $i++) {
            $this->loadKey("s_proc_{$i}_title");
            $this->loadKey("s_proc_{$i}_text");
        }

        // 4. Button URL & Hero Image
        $urlSetting = Setting::where('key', 'btn_request_url')->first();
        $this->urls['btn_request_url'] = $urlSetting ? $urlSetting->getRawOriginal('value') : '/contact';
        $this->existing['hero_bg'] = Setting::where('key', 'service_hero_bg')->first()?->value;
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
        $previewData = array_merge($this->state, $this->urls);

        $previewData['service_hero_bg'] = $this->hero_bg 
            ? $this->hero_bg->temporaryUrl() 
            : ($this->existing['hero_bg'] ?? null);

        for ($i = 1; $i <= 6; $i++) {
            $previewData["service_{$i}_img"] = isset($this->service_images[$i])
                ? $this->service_images[$i]->temporaryUrl()
                : ($this->existing["service_{$i}_img"] ?? null);
        }

        $targetSection = 'services-hero';
        $cardIndex = null;

        if (str_contains($propertyName, 'service_') || str_contains($propertyName, 'btn_request')) {
            $targetSection = 'services-grid';
            if (preg_match('/service_(\d+)/', $propertyName, $matches)) {
                $cardIndex = (int) $matches[1];
            }
        } elseif (str_contains($propertyName, 'process') || str_contains($propertyName, 'proc')) {
            $targetSection = 'services-process';
        } elseif (str_contains($propertyName, 'emergency')) {
            $targetSection = 'services-emergency';
        }

        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => $targetSection,
            'cardIndex' => $cardIndex,
        ]);
    }

   public function save()
    {
        // 1. Save all translated text fields
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }

        foreach ($this->urls as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val]
            );
        }

        if ($this->hero_bg) {
            $path = $this->hero_bg->store('services', 'public');
            
            Setting::updateOrCreate(
                ['key' => 'service_hero_bg'],
                ['value' => $path]
            );

            $this->existing['hero_bg'] = $path;
            $this->hero_bg = null; // Clear upload input
        }

        // 4. Save 6 Service Images with updateOrCreate
        foreach ($this->service_images as $index => $file) {
            if ($file) {
                $path = $file->store('services', 'public');
                
                Setting::updateOrCreate(
                    ['key' => "service_{$index}_img"],
                    ['value' => $path]
                );

                $this->existing["service_{$index}_img"] = $path;
            }
        }
        $this->service_images = [];

        $previewData = array_merge($this->state, $this->urls);
        $previewData['service_hero_bg'] = $this->existing['hero_bg'] ?? null;
        for ($i = 1; $i <= 6; $i++) {
            $previewData["service_{$i}_img"] = $this->existing["service_{$i}_img"] ?? null;
        }

        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => 'services-hero',
        ]);
        $this->dispatch('reload-settings');

        session()->flash('message', 'Services & support protocol published successfully!');
    }
    public function render()
    {
        return view('livewire.manage-services-page')->layout('components.layouts.admin');
    }
}