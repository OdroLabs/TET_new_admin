<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;

    protected $fillable = ['key', 'value'];

    /** Never exposed through the public /api/settings feed. */
    public const PRIVATE_KEYS = ['site_preview_key'];

    public $translatable = ['value'];

    protected static function booted()
    {
        // Invalidate settings cache whenever a setting is created, updated, or deleted
        static::saved(function () {
            Cache::forget('api_settings_map');
        });

        static::deleted(function () {
            Cache::forget('api_settings_map');
        });
    }

    /** Store a language-independent value (flags, keys, URLs) as a plain string. */
    public static function putPlain(string $key, string $value): void
    {
        \Illuminate\Support\Facades\DB::table('settings')->updateOrInsert(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );
        Cache::forget('api_settings_map');
    }

    /** The secret that lets the admin preview the real site while Coming Soon is on. */
    public static function previewKey(): string
    {
        $key = static::text('site_preview_key');
        if ($key === '') {
            $key = \Illuminate\Support\Str::random(32);
            static::putPlain('site_preview_key', $key);
        }
        return $key;
    }

    /** English (or plain) text of a setting, e.g. for API responses and emails. */
    public static function text(string $key, string $locale = 'en'): string
    {
        $raw = static::query()->toBase()->where('key', $key)->value('value'); // raw JSON, not the translated accessor
        if ($raw === null || $raw === '') return '';
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            return (string) (($decoded[$locale] ?? '') !== '' ? $decoded[$locale] : ($decoded['en'] ?? ''));
        }
        return is_string($decoded) ? $decoded : trim($raw, "\"'");
    }

    public function isTranslatableAttribute(string $key): bool
    {
        if ($key !== 'value') {
            return false;
        }

        $settingKey = $this->getAttribute('key');

        $projectImages = [];
        for ($p = 1; $p <= 4; $p++) {
            for ($img = 1; $img <= 3; $img++) {
                $projectImages[] = "pj_{$p}_img{$img}";
            }
        }

        $nonTranslatable = array_merge([
            // Navigation & Branding
            'site_logo', 'nav_donate_url',

            // Footer & Social Media URLs
            'footer_fb_url', 'footer_ig_url', 'footer_ln_url', 'footer_x_url',
            'footer_manual_url', 'footer_donate_url', 'footer_privacy_url', 'footer_terms_url',

            // 01. Home Page
            'impact_cards',
            'hero_image_main',
            'hero_image_sub',
            'story_image',
            'btn_support_url',
            'btn_mission_url',
            'view_journal_url',
            'story_video_url',
            'explore_services_url',

            // 02. About Page
            'about_hero_image',
            'about_leader_image',
            'about_team_group_image',

            // 03. Services Page
            'service_hero_bg',
            'service_1_img',
            'service_2_img',
            'service_3_img',
            'service_4_img',
            'service_5_img',
            'service_6_img',
            'btn_request_url',

            // 04. Volunteer Page
            'v_hero_img',

            // 05. TET Spaces & Booking (Social Enterprise)
            'se_hall_img',
            'se_hall_btn_url',
            'se_prod_btn_url',

            // Contact Page
            'ct_form_img',
        ], $projectImages);

        if ($settingKey && in_array($settingKey, $nonTranslatable, true)) {
            return false;
        }

        return true;
    }
}