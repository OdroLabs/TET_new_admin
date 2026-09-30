<?php

namespace App\Livewire;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

/** Coming Soon switch, search-engine visibility and the Coming Soon page content. */
class ManageSiteStatus extends Component
{
    /** Trilingual Coming Soon texts: key => [label, textarea?] */
    public const TEXT_FIELDS = [
        'cs_badge' => ['Small badge', false],
        'cs_title_1' => ['Headline (first line)', false],
        'cs_title_2' => ['Headline (second line, gradient)', false],
        'cs_message' => ['Message', true],
        'cs_contact_label' => ['Contact heading', false],
        'seo_comingsoon_title' => ['Browser tab / Google title', false],
        'seo_comingsoon_description' => ['Google description', true],
    ];

    public bool $comingSoon = false;
    public bool $noindex = false;
    public string $previewKey = '';

    public array $texts = [];
    public string $contactEmail = '';
    public string $contactPhone = '';

    public function mount()
    {
        $this->comingSoon = Setting::text('site_coming_soon') === '1';
        $this->noindex = Setting::text('site_noindex') === '1';
        $this->previewKey = Setting::previewKey();

        $raw = DB::table('settings')->whereIn('key', array_keys(self::TEXT_FIELDS))->pluck('value', 'key');
        foreach (array_keys(self::TEXT_FIELDS) as $key) {
            $decoded = json_decode($raw[$key] ?? '', true);
            $this->texts[$key] = [
                'en' => is_array($decoded) ? (string) ($decoded['en'] ?? '') : (string) ($raw[$key] ?? ''),
                'si' => is_array($decoded) ? (string) ($decoded['si'] ?? '') : '',
                'ta' => is_array($decoded) ? (string) ($decoded['ta'] ?? '') : '',
            ];
        }

        $this->contactEmail = Setting::text('cs_contact_email');
        $this->contactPhone = Setting::text('cs_contact_phone');
    }

    /** Switches save immediately — no need to press Save for these. */
    public function updatedComingSoon($value)
    {
        Setting::putPlain('site_coming_soon', $value ? '1' : '0');
        session()->flash('status', $value
            ? 'Coming Soon is ON — visitors now see the Coming Soon page.'
            : 'Coming Soon is OFF — the full website is live.');
    }

    public function updatedNoindex($value)
    {
        Setting::putPlain('site_noindex', $value ? '1' : '0');
        session()->flash('status', $value
            ? 'Search engines are now told not to index or follow the site.'
            : 'Search engines may index the site again.');
    }

    public function regenerateKey()
    {
        $this->previewKey = Str::random(32);
        Setting::putPlain('site_preview_key', $this->previewKey);
        session()->flash('status', 'New preview link created. Old preview links stop working.');
    }

    public function getFrontendUrlProperty(): string
    {
        return rtrim((string) env('FRONTEND_URL', 'http://localhost:3000'), '/');
    }

    public function save()
    {
        $this->validate([
            'contactEmail' => 'nullable|email',
        ]);

        foreach ($this->texts as $key => $langs) {
            $setting = Setting::firstOrNew(['key' => $key]);
            $setting->setTranslations('value', array_map(fn ($v) => (string) $v, $langs));
            $setting->save();
        }

        Setting::putPlain('cs_contact_email', trim($this->contactEmail));
        Setting::putPlain('cs_contact_phone', trim($this->contactPhone));

        session()->flash('status', 'Coming Soon page saved.');
        $this->dispatch('reload-settings');
    }

    public function render()
    {
        return view('livewire.manage-site-status')->layout('components.layouts.admin');
    }
}
