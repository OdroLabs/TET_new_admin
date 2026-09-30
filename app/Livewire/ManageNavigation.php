<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;

class ManageNavigation extends Component
{
    use WithFileUploads;

    public $state = [];
    public $urls = [];
    public $logo_file;
    public $existing_logo;

    protected $textKeys = [
        'nav_home',
        'nav_about',
        'nav_services',
        'nav_drop_services',
        'nav_drop_volunteer',
        'nav_projects',
        'nav_gallery',
        'nav_activities',
        'nav_booking',
        'nav_contact',
        'btn_donate',
    ];

    protected $urlKeys = [
        'nav_donate_url',
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

        $urlSetting = Setting::where('key', 'nav_donate_url')->first();
        $this->urls['nav_donate_url'] = $urlSetting ? $urlSetting->getRawOriginal('value') : '';
        $this->existing_logo = Setting::where('key', 'site_logo')->first()?->value;
    }

    public function updated($propertyName)
    {
        $previewData = array_merge($this->state, $this->urls);

        if ($this->logo_file) {
            $previewData['site_logo'] = $this->logo_file->temporaryUrl();
        } else {
            $previewData['site_logo'] = $this->existing_logo;
        }

        $this->dispatch('content-updated', [
            'state' => $previewData,
        ]);
    }

    public function save()
    {
        // 1. Save navigation text labels
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }

        // 2. Save Donate Button URL
        foreach ($this->urls as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        // 3. Save Logo Upload
        if ($this->logo_file) {
            $path = \App\Support\Media::store($this->logo_file, 'branding');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
            $this->existing_logo = $path;
            $this->logo_file = null;
        }

        $previewData = array_merge($this->state, $this->urls);
        $previewData['site_logo'] = $this->existing_logo;

        $this->dispatch('content-updated', ['state' => $previewData]);
        $this->dispatch('reload-settings');

        session()->flash('message', 'Navigation bar & branding published successfully!');
    }

    public function render()
    {
        return view('livewire.manage-navigation')->layout('components.layouts.admin');
    }
}