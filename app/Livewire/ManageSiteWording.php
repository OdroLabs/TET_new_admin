<?php

namespace App\Livewire;

use App\Models\Setting;
use App\Support\Media;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * Every text, label, image and SEO value on the public website, grouped by page
 * and editable in English / Sinhala / Tamil. Keys come from database/data/site_content.json.
 */
class ManageSiteWording extends Component
{
    use WithFileUploads;

    public const GROUPS = [
        'nav' => 'Navigation',
        'home' => 'Home Page',
        'about' => 'About',
        'services' => 'Services',
        'projects' => 'Projects',
        'news' => 'Activities (News)',
        'gallery' => 'Events & Gallery',
        'booking' => 'Social Enterprise',
        'contact' => 'Contact',
        'donate' => 'Donate',
        'volunteer' => 'Volunteer',
        'footer' => 'Footer',
        'whatsapp' => 'WhatsApp Button',
        'logo' => 'Logo Text',
        'fontsize' => 'Text Size Control',
        'comingsoon' => 'Coming Soon Page',
        'seo' => 'SEO & Search Results',
    ];

    public string $group = 'nav';
    public string $search = '';

    /** key => ['en' => , 'si' => , 'ta' => ] (plain/image kinds use 'en' only) */
    public array $values = [];
    public array $original = [];
    public array $uploads = [];

    public function mount()
    {
        $this->loadValues();
    }

    public function updatedGroup()
    {
        $this->search = '';
        $this->uploads = [];
        $this->loadValues();
    }

    public function updatedSearch()
    {
        $this->loadValues();
    }

    /** Registry entries shown right now (current tab, or search results across all tabs). */
    public function getItemsProperty(): array
    {
        $items = array_filter(SiteContentSeeder::registry(), fn ($i) => $i['kind'] !== 'json');
        $q = mb_strtolower(trim($this->search));

        if ($q !== '') {
            return array_values(array_filter($items, function ($i) use ($q) {
                $v = $this->values[$i['key']] ?? [];
                $hay = mb_strtolower($i['key'] . ' ' . $i['en'] . ' ' . implode(' ', $v));
                return str_contains($hay, $q);
            }));
        }

        return array_values(array_filter($items, fn ($i) => $i['group'] === $this->group));
    }

    private function loadValues(): void
    {
        $keys = array_column(SiteContentSeeder::registry(), 'key');
        $raw = DB::table('settings')->whereIn('key', $keys)->pluck('value', 'key');

        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $this->decode($raw[$key] ?? null);
        }
        $this->values = $values;
        $this->original = $values;
    }

    private function decode(?string $raw): array
    {
        $out = ['en' => '', 'si' => '', 'ta' => ''];
        if ($raw === null || $raw === '') return $out;
        $decoded = json_decode($raw, true);
        if (is_array($decoded) && !array_is_list($decoded)) {
            foreach ($out as $l => $_) $out[$l] = is_string($decoded[$l] ?? null) ? $decoded[$l] : '';
            return $out;
        }
        $out['en'] = is_string($decoded) ? $decoded : trim($raw, "\"'");
        return $out;
    }

    public function save()
    {
        $this->validate(['uploads.*' => 'nullable|image|max:10240']);

        $kinds = array_column(SiteContentSeeder::registry(), 'kind', 'key');
        $changed = 0;

        foreach ($this->uploads as $key => $file) {
            if ($file && isset($kinds[$key])) {
                $old = $this->original[$key]['en'] ?? '';
                $this->values[$key]['en'] = Media::store($file, 'site');
                if ($old) Media::delete($old);
            }
        }
        $this->uploads = [];

        foreach ($this->values as $key => $value) {
            if (!isset($kinds[$key]) || $value == ($this->original[$key] ?? null)) continue;

            $setting = Setting::firstOrNew(['key' => $key]);
            if ($kinds[$key] === 'text' && $setting->isTranslatableAttribute('value')) {
                $setting->setTranslations('value', [
                    'en' => (string) ($value['en'] ?? ''),
                    'si' => (string) ($value['si'] ?? ''),
                    'ta' => (string) ($value['ta'] ?? ''),
                ]);
                $setting->save();
            } else {
                // plain values, URLs and images are language-independent
                DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => trim((string) ($value['en'] ?? '')), 'updated_at' => now(), 'created_at' => $setting->created_at ?? now()]
                );
            }
            $changed++;
        }

        Cache::forget('api_settings_map');
        $this->loadValues();

        session()->flash('message', $changed ? "Saved {$changed} change(s). The website updates within a minute." : 'No changes to save.');
        $this->dispatch('reload-settings');
    }

    public function render()
    {
        return view('livewire.manage-site-wording')->layout('components.layouts.admin');
    }
}
