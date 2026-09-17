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
        'btn_donate',
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
        $defaultTexts = [
            'footer_desc' => [
                'en' => 'Sri Lanka’s leading advocacy group protecting the rights, safety, and choice of the transgender community.',
                'si' => 'සංක්‍රාන්ති ලිංගික ප්‍රජාවගේ අයිතිවාසිකම් සහ ආරක්ෂාව සුරකින ශ්‍රී ලංකාවේ ප්‍රමුඛතම සංවිධානය.',
                'ta' => 'திருநங்கைகள் சமூகத்தின் உரிமைகள் மற்றும் பாதுகாப்பைப் பாதுகாக்கும் இலங்கையின் முன்னணி அமைப்பு.'
            ],
            'footer_head_org' => ['en' => 'Organization', 'si' => 'ආයතනය', 'ta' => 'அமைப்பு'],
            'footer_head_init' => ['en' => 'Initiatives', 'si' => 'ක්‍රියාකාරකම්', 'ta' => 'முயற்சிகள்'],
            'footer_legal_manual' => ['en' => 'Legal Rights Manual', 'si' => 'නීතිමය අයිතිවාසිකම් අත්පොත', 'ta' => 'சட்ட உரிமைகள் கையேடு'],
            'footer_head_support' => ['en' => 'Support Our Work', 'si' => 'අපට සහාය වන්න', 'ta' => 'எங்கள் பணிக்கு ஆதரவு'],
            'footer_support_text' => [
                'en' => 'Your contribution directly funds 24/7 legal aid and rehabilitation paths.',
                'si' => 'ඔබගේ ආධාර සෘජුවම පැය 24 පුරා නීති ආධාර සහ පුනරුත්ථාපන කටයුතු සඳහා යෙදවේ.',
                'ta' => 'உங்கள் பங்களிப்பு 24/7 சட்ட உதவி மற்றும் மறுவாழ்வு பணிகளுக்கு நேரடியாக உதவுகிறது.'
            ],
            'btn_donate' => ['en' => 'Make a Donation', 'si' => 'ආධාර කරන්න', 'ta' => 'நன்கொடை வழங்குக'],
            'footer_copy' => ['en' => 'Trans Equality Trust Sri Lanka.', 'si' => 'ට්‍රාන්ස් ඉක්වැලිටි ට්‍රස්ට් ශ්‍රී ලංකා.', 'ta' => 'டிரான்ஸ் ஈக்வாலிட்டி டிரஸ்ட் இலங்கை.'],
            'footer_privacy' => ['en' => 'Privacy Policy', 'si' => 'පුද්ගලිකත්ව ප්‍රතිපත්තිය', 'ta' => 'தனியுரிமைக் கொள்கை'],
            'footer_terms' => ['en' => 'Terms & Conditions', 'si' => 'නියම සහ කොන්දේසි', 'ta' => 'விதிமுறைகள்'],
        ];

        foreach ($this->textKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->state[$key] = [
                'en' => $setting ? $setting->getTranslation('value', 'en') : ($defaultTexts[$key]['en'] ?? ''),
                'si' => $setting ? $setting->getTranslation('value', 'si') : ($defaultTexts[$key]['si'] ?? ''),
                'ta' => $setting ? $setting->getTranslation('value', 'ta') : ($defaultTexts[$key]['ta'] ?? ''),
            ];
        }

        $defaultUrls = [
            'footer_fb_url' => 'https://facebook.com',
            'footer_ig_url' => 'https://instagram.com',
            'footer_ln_url' => 'https://linkedin.com',
            'footer_x_url' => 'https://x.com',
            'footer_manual_url' => '#',
            'footer_donate_url' => '/donate',
            'footer_privacy_url' => '/privacy',
            'footer_terms_url' => '/terms',
        ];

        foreach ($this->urlKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->urls[$key] = $setting ? $setting->getRawOriginal('value') : ($defaultUrls[$key] ?? '');
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