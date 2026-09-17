<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;

class ManageBookingPage extends Component
{
    use WithFileUploads;

    public $state = [];
    public $urls = [];
    public $hall_image;
    public $existing = [];

    // All keys matching your Next.js frontend
    protected $textKeys = [
        // 01. Hero
        'se_hero_badge', 'se_hero_title1', 'se_hero_title2', 'se_hero_desc',
        // 02. Business 1: Hall Booking
        'se_hall_tag', 'se_hall_title1', 'se_hall_title2', 'se_hall_desc', 'se_hall_capacity', 'se_hall_btn',
        // 03. Business 2: Daily Care Center
        'se_care_tag', 'se_care_title1', 'se_care_title2', 'se_care_desc',
        // 04. Business 3: Condoms & Wellness Enterprise
        'se_prod_tag', 'se_prod_title1', 'se_prod_title2', 'se_prod_desc', 'se_prod_btn',
    ];

    protected $urlKeys = [
        'se_hall_btn_url', 'se_prod_btn_url',
    ];

    public function mount()
    {
        foreach ($this->textKeys as $key) {
            $this->loadKey($key);
        }

        $urlDefaults = [
            'se_hall_btn_url' => '/contact?subject=HallBooking',
            'se_prod_btn_url' => '/contact?subject=BulkCondomOrders',
        ];

        foreach ($this->urlKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->urls[$key] = $setting ? $setting->getRawOriginal('value') : ($urlDefaults[$key] ?? '');
        }

        $this->existing['se_hall_img'] = Setting::where('key', 'se_hall_img')->first()?->value;
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

        // Preview temporary image or existing image
        $previewData['se_hall_img'] = $this->hall_image 
            ? $this->hall_image->temporaryUrl() 
            : ($this->existing['se_hall_img'] ?? null);

        // Section auto-scroll target
        $targetSection = 'se-hero';
        if (str_contains($propertyName, 'hall')) {
            $targetSection = 'hall-booking';
        } elseif (str_contains($propertyName, 'care')) {
            $targetSection = 'daily-care';
        } elseif (str_contains($propertyName, 'prod')) {
            $targetSection = 'condom-business';
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

        // 2. Save URLs
        foreach ($this->urls as $key => $val) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $val]
            );
        }

        // 3. Save Hall Photo (uses updateOrCreate to prevent erasing ID)
        if ($this->hall_image) {
            $path = $this->hall_image->store('booking', 'public');
            Setting::updateOrCreate(
                ['key' => 'se_hall_img'],
                ['value' => $path]
            );
            $this->existing['se_hall_img'] = $path;
            $this->hall_image = null;
        }

        // Dispatch updated persistent state to preview
        $previewData = array_merge($this->state, $this->urls);
        $previewData['se_hall_img'] = $this->existing['se_hall_img'] ?? null;

        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => 'se-hero',
        ]);
        $this->dispatch('reload-settings');

        session()->flash('message', 'TET Spaces & Enterprises content published successfully!');
    }

    public function render()
    {
        return view('livewire.manage-booking-page')->layout('components.layouts.admin');
    }
}