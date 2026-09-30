<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;

class ManageFooter extends Component
{
    public $state = [];
    public $urls = [];

    protected $textKeys = [
        'footer_desc',
        'footer_head_org',
        'footer_head_init',
        'footer_legal_manual',
        'footer_head_support',
        'footer_support_text',
        'footer_btn_donate',
        'footer_copy',
        'footer_privacy',
        'footer_terms',
    ];

    protected $urlKeys = [
        'footer_fb_url',
        'footer_ig_url',
        'footer_ln_url',
        'footer_x_url',
        'footer_manual_url',
        'footer_donate_url',
        'footer_privacy_url',
        'footer_terms_url',
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

        foreach ($this->urlKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->urls[$key] = $setting ? $setting->getRawOriginal('value') : '';
        }
    }

    public function updated($propertyName)
    {
        $previewData = array_merge($this->state, $this->urls);

        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => 'site-footer', // Auto-scrolls iframe to the footer
        ]);
    }

    public function save()
    {
        // 1. Save text translations
        foreach ($this->state as $key => $translations) {
            $setting = Setting::firstOrNew(['key' => $key]);
            foreach ($translations as $lang => $val) {
                $setting->setTranslation('value', $lang, $val ?? '');
            }
            $setting->save();
        }

        // 2. Save URLs
        foreach ($this->urls as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val]);
        }

        $previewData = array_merge($this->state, $this->urls);
        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => 'site-footer',
        ]);
        $this->dispatch('reload-settings');

        session()->flash('message', 'Footer configuration & social channels published!');
    }

    public function render()
    {
        return view('livewire.manage-footer')->layout('components.layouts.admin');
    }
}