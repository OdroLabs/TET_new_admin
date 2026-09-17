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
        $defaultTexts = [
            'nav_home' => ['en' => 'Home', 'si' => 'මුල් පිටුව', 'ta' => 'முகப்பு'],
            'nav_about' => ['en' => 'About', 'si' => 'අප ගැන', 'ta' => 'எங்களை பற்றி'],
            'nav_services' => ['en' => 'Services', 'si' => 'සේවාවන්', 'ta' => 'சேவைகள்'],
            'nav_drop_services' => ['en' => 'Advocacy Services', 'si' => 'නීතිමය සේවා', 'ta' => 'சட்ட சேவைகள்'],
            'nav_drop_volunteer' => ['en' => 'Volunteer', 'si' => 'ස්වේච්ඡා සේවය', 'ta' => 'தன்னார்வலர்'],
            'nav_projects' => ['en' => 'Projects', 'si' => 'ව්‍යාපෘති', 'ta' => 'திட்டங்கள்'],
            'nav_gallery' => ['en' => 'Events & Gallery', 'si' => 'සිදුවීම් සහ ගැලරිය', 'ta' => 'நிகழ்வுகள் & தொகுப்பு'],
            'nav_activities' => ['en' => 'Activities', 'si' => 'ක්‍රියාකාරකම්', 'ta' => 'செயற்பாடுகள்'],
            'nav_booking' => ['en' => 'Social Enterprise', 'si' => 'සමාජ ව්‍යවසාය', 'ta' => 'சமூக நிறுவனம்'],
            'nav_contact' => ['en' => 'Contact Us', 'si' => 'අප අමතන්න', 'ta' => 'தொடர்புக்கு'],
            'btn_donate' => ['en' => 'Donate', 'si' => 'ආධාර කරන්න', 'ta' => 'நன்கொடை'],
        ];

        foreach ($this->textKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->state[$key] = [
                'en' => $setting ? $setting->getTranslation('value', 'en') : ($defaultTexts[$key]['en'] ?? ''),
                'si' => $setting ? $setting->getTranslation('value', 'si') : ($defaultTexts[$key]['si'] ?? ''),
                'ta' => $setting ? $setting->getTranslation('value', 'ta') : ($defaultTexts[$key]['ta'] ?? ''),
            ];
        }

        $urlSetting = Setting::where('key', 'nav_donate_url')->first();
        $this->urls['nav_donate_url'] = $urlSetting ? $urlSetting->getRawOriginal('value') : '/donate';
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
            $path = $this->logo_file->store('branding', 'public');
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