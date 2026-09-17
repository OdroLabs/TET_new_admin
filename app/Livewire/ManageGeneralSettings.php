<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;

class ManageGeneralSettings extends Component
{
    // State for the 3 languages
    public $title_en = '';
    public $title_si = '';
    public $title_ta = '';

    public function mount() {
        // Fetch existing record from the database
        $setting = Setting::where('key', 'hero_title')->first();
        
        if ($setting) {
            // Spatie Translatable helper to get translations
            $this->title_en = $setting->getTranslation('value', 'en');
            $this->title_si = $setting->getTranslation('value', 'si');
            $this->title_ta = $setting->getTranslation('value', 'ta');
        }
    }

    public function save() {
        // Update or create the setting record
        $setting = Setting::updateOrCreate(['key' => 'hero_title']);
        
        $setting->setTranslation('value', 'en', $this->title_en);
        $setting->setTranslation('value', 'si', $this->title_si);
        $setting->setTranslation('value', 'ta', $this->title_ta);
        
        $setting->save();

        session()->flash('message', 'Institutional content published successfully.');
    }

    public function render() {
        return view('livewire.manage-general-settings')
            ->layout('components.layouts.admin');
    }
}