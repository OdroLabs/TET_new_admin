<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;

class ManageHomePage extends Component
{
    use WithFileUploads;

    public $state = [];
    public $urls = [];
    public $hero_image_main, $hero_image_sub, $story_image;
    public $existing = [];

    // 8 Carousel Cards State & Uploads
    public $impact_cards = [];
    public $impact_card_images = []; 

    protected $textKeys = [
        'hero_top_label', 'hero_title_1', 'hero_title_2', 'hero_description',
        'btn_support', 'btn_mission',
        'impact_title', 'impact_label', 'view_journal',
        'stat_1_val', 'stat_1_label', 'stat_1_desc',
        'stat_2_val', 'stat_2_label', 'stat_2_desc',
        'stat_3_val', 'stat_3_label', 'stat_3_desc',
        'story_label', 'story_title', 'story_description',
        'story_stat_val', 'story_stat_label', 'explore_services'
    ];

    protected $urlKeys = [
        'btn_support_url', 'btn_mission_url', 'view_journal_url',
        'story_video_url', 'explore_services_url'
    ];

    public function mount()
    {
        // 1. Text keys
        foreach ($this->textKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->state[$key] = [
                'en' => $setting ? $setting->getTranslation('value', 'en') : '',
                'si' => $setting ? $setting->getTranslation('value', 'si') : '',
                'ta' => $setting ? $setting->getTranslation('value', 'ta') : '',
            ];
        }

        // 2. URLs
        $urlDefaults = [
            'btn_support_url' => '/donate',
            'btn_mission_url' => '/about',
            'view_journal_url' => '/news',
            'story_video_url' => 'https://youtube.com',
            'explore_services_url' => '/services',
        ];

        foreach ($this->urlKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            $this->urls[$key] = $setting ? $setting->getRawOriginal('value') : ($urlDefaults[$key] ?? '');
        }

        // 3. Existing single images
        $this->existing['hero_image_main'] = Setting::where('key', 'hero_image_main')->first()?->value;
        $this->existing['hero_image_sub'] = Setting::where('key', 'hero_image_sub')->first()?->value;
        $this->existing['story_image'] = Setting::where('key', 'story_image')->first()?->value;

        // 4. Load 8 Impact Cards (or seed defaults)
  $savedCards = Setting::where('key', 'impact_cards')->first();
        if ($savedCards) {
            $raw = $savedCards->getRawOriginal('value');
            $decoded = json_decode($raw, true);

            // If Spatie wrapped it in ['en' => ...]
            if (is_array($decoded) && isset($decoded['en'])) {
                $decoded = is_string($decoded['en']) ? json_decode($decoded['en'], true) : $decoded['en'];
            }

            // Ensure it's a valid list of cards with numeric keys
            if (is_array($decoded) && isset($decoded[0])) {
                $this->impact_cards = $decoded;
            } else {
                $this->impact_cards = $this->getDefaultImpactCards();
            }
        } else {
            $this->impact_cards = $this->getDefaultImpactCards();
        }
    }

    private function getDefaultImpactCards(): array
    {
        $defaults = [
            ['cat' => 'Legal', 'title' => 'Human Rights Appeal', 'img' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f'],
            ['cat' => 'Policy', 'title' => 'Consortium Meeting', 'img' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952'],
            ['cat' => 'Community', 'title' => 'Safe-Space Unity', 'img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644'],
            ['cat' => 'Health', 'title' => 'Recovery Pathways', 'img' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8'],
            ['cat' => 'Education', 'title' => 'Vocational Skills', 'img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f'],
            ['cat' => 'Inclusion', 'title' => 'Workplace Training', 'img' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d'],
            ['cat' => 'Advocacy', 'title' => 'Global Representation', 'img' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85'],
            ['cat' => 'Unity', 'title' => 'Community Support', 'img' => 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8'],
        ];

        return array_map(function ($item) {
            return [
                'cat' => ['en' => $item['cat'], 'si' => $item['cat'], 'ta' => $item['cat']],
                'title' => ['en' => $item['title'], 'si' => $item['title'], 'ta' => $item['title']],
                'image' => $item['img'],
            ];
        }, $defaults);
    }

    public function updated($propertyName)
    {
        $previewData = array_merge($this->state, $this->urls);
        $previewCards = $this->impact_cards;

        // Attach temporary URLs for single images
        if ($this->hero_image_main) $previewData['hero_image_main'] = $this->hero_image_main->temporaryUrl();
        if ($this->hero_image_sub) $previewData['hero_image_sub'] = $this->hero_image_sub->temporaryUrl();
        if ($this->story_image) $previewData['story_image'] = $this->story_image->temporaryUrl();

        // Attach temporary URLs for carousel card images
        foreach ($this->impact_card_images as $idx => $file) {
            if ($file) {
                $previewCards[$idx]['image'] = $file->temporaryUrl();
            }
        }
        $previewData['impact_cards'] = $previewCards;

        // Auto-detect which section is being changed
        $targetSection = 'section-hero';
        $slideIndex = null;

        if (str_contains($propertyName, 'impact') || str_contains($propertyName, 'view_journal')) {
            $targetSection = 'section-impact';
            if (preg_match('/impact_card[s|_images]*\.(\d+)/', $propertyName, $matches)) {
                $slideIndex = (int) $matches[1];
            }
        } elseif (str_contains($propertyName, 'stat')) {
            $targetSection = 'section-stats';
        } elseif (str_contains($propertyName, 'story') || str_contains($propertyName, 'explore')) {
            $targetSection = 'section-story';
        }

        $this->dispatch('content-updated', [
            'state' => $previewData,
            'targetSection' => $targetSection,
            'slideIndex' => $slideIndex,
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

        // 2. Save URLs
        foreach ($this->urls as $key => $val) {
            $urlSetting = Setting::firstOrNew(['key' => $key]);
            $urlSetting->setRawAttributes([
                'key' => $key,
                'value' => $val,
            ]);
            $urlSetting->save();
        }

        foreach ($this->impact_card_images as $idx => $file) {
            if ($file) {
                $path = $file->store('homepage/impact', 'public');
                $this->impact_cards[$idx]['image'] = $path;
            }
        }
        $this->impact_card_images = [];

        $cardSetting = Setting::firstOrNew(['key' => 'impact_cards']);
        $cardSetting->setRawAttributes([
            'key' => 'impact_cards',
            'value' => json_encode($this->impact_cards),
        ]);
        $cardSetting->save();

        // 4. Upload single images
        $this->uploadImage('hero_image_main');
        $this->uploadImage('hero_image_sub');
        $this->uploadImage('story_image');

        session()->flash('message', 'All homepage sections & carousel cards saved successfully!');
    }

    private function uploadImage($field)
    {
        if ($this->$field) {
            $path = $this->$field->store('homepage', 'public');
            $imageSetting = Setting::firstOrNew(['key' => $field]);
            $imageSetting->setRawAttributes([
                'key' => $field,
                'value' => $path,
            ]);
            $imageSetting->save();
            $this->existing[$field] = $path;
            $this->$field = null;
        }
    }

    public function render()
    {
        return view('livewire.manage-home-page')->layout('components.layouts.admin');
    }
}