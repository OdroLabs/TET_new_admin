<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;

class ManageContactPage extends Component
{
    use WithFileUploads;

    public $state = [];
    public $form_image; 
    public $existing = [];

    protected $textKeys = [
        // 1. Hero
        'ct_hero_label', 'ct_hero_title', 'ct_hero_desc',
        // 2. Crisis Section
        'ct_crisis_badge', 'ct_crisis_title', 'ct_crisis_desc', 'ct_crisis_phone',
        // 3. Contact Grid (3 Cards)
        'ct_g1_label', 'ct_g1_val', 'ct_g1_sub',
        'ct_g2_label', 'ct_g2_val', 'ct_g2_sub',
        'ct_g3_label', 'ct_g3_val', 'ct_g3_sub',
        // 4. Form Section
        'ct_form_title', 'ct_form_btn'
    ];

    public function mount()
    {
        foreach ($this->textKeys as $key) { 
            $this->loadKey($key); 
        }
        $this->existing['ct_form_img'] = Setting::where('key', 'ct_form_img')->first()?->value;
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

        $previewData['ct_form_img'] = $this->form_image 
            ? $this->form_image->temporaryUrl() 
            : ($this->existing['ct_form_img'] ?? null);

        $targetSection = 'contact-hero';
        if (str_contains($propertyName, 'crisis')) {
            $targetSection = 'contact-crisis';
        } elseif (str_contains($propertyName, 'ct_g')) {
            $targetSection = 'contact-cards';
        } elseif (str_contains($propertyName, 'form')) {
            $targetSection = 'contact-form';
        }

        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => $targetSection,
        ]);
    }

    public function save()
    {
        // 1. Save text fields
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }

        // 2. Save Form Image
        if ($this->form_image) {
            $path = $this->form_image->store('contact', 'public');
            Setting::updateOrCreate(
                ['key' => 'ct_form_img'],
                ['value' => $path]
            );
            $this->existing['ct_form_img'] = $path;
            $this->form_image = null;
        }

        $previewData = $this->state;
        $previewData['ct_form_img'] = $this->existing['ct_form_img'] ?? null;

        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => 'contact-hero',
        ]);
        $this->dispatch('reload-settings');

        session()->flash('message', 'Contact desk configuration published successfully!');
    }

    public function render()
    {
        return view('livewire.manage-contact-page')->layout('components.layouts.admin');
    }
}