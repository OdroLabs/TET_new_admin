<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Puts every piece of website text, label, image and SEO value into the settings
 * table (database/data/site_content.json is the registry). The website has no
 * hardcoded fallbacks, so this is what it shows until an admin edits it.
 *
 * Safe to run repeatedly: it only fills keys that are missing or have an empty
 * English value — anything already edited in the admin is left untouched.
 */
class SiteContentSeeder extends Seeder
{
    public static function registry(): array
    {
        static $items = null;
        return $items ??= json_decode(file_get_contents(database_path('data/site_content.json')), true) ?: [];
    }

    public function run(): void
    {
        $existing = DB::table('settings')->pluck('value', 'key')->all();

        foreach (static::registry() as $item) {
            $key = $item['key'];
            $raw = $existing[$key] ?? null;

            // A key given its own copy (e.g. footer_nav_about) starts from the shared key's saved value
            if ($raw === null && !empty($item['seed_from']) && $this->hasEnglish($existing[$item['seed_from']] ?? null)) {
                $raw = $existing[$item['seed_from']];
                $this->write($key, $raw);
                continue;
            }

            if ($this->hasEnglish($raw)) {
                continue;   // already has content
            }

            $setting = Setting::firstOrNew(['key' => $key]);

            if ($setting->isTranslatableAttribute('value')) {
                $current = $raw ? (json_decode($raw, true) ?: []) : [];
                $setting->setTranslations('value', [
                    'en' => $item['en'],
                    'si' => ($current['si'] ?? '') !== '' ? $current['si'] : ($item['si'] ?? ''),
                    'ta' => ($current['ta'] ?? '') !== '' ? $current['ta'] : ($item['ta'] ?? ''),
                ]);
                $setting->saveQuietly();
            } else {
                $this->write($key, $item['en']);
            }
        }

        Cache::forget('api_settings_map');
    }

    /** Raw write, bypassing translation handling (images, JSON lists, copied values). */
    private function write(string $key, string $raw): void
    {
        DB::table('settings')->updateOrInsert(['key' => $key], ['value' => $raw, 'updated_at' => now(), 'created_at' => now()]);
    }

    private function hasEnglish(?string $raw): bool
    {
        if ($raw === null || trim($raw) === '') return false;
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            if (array_is_list($decoded)) return true;                 // JSON list (impact cards)
            $en = $decoded['en'] ?? null;          // translations: only English counts
            return is_string($en) ? trim($en) !== '' : !empty($en);
        }
        if (is_string($decoded)) return trim($decoded) !== '';
        return true;
    }
}
