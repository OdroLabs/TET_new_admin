<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/** Coming Soon page + search-engine visibility switches (Admin → Site Status). */
return new class extends Migration {
    public function up(): void
    {
        foreach (['site_coming_soon' => '0', 'site_noindex' => '0'] as $key => $value) {
            if (!DB::table('settings')->where('key', $key)->exists()) {
                DB::table('settings')->insert(['key' => $key, 'value' => $value, 'created_at' => now(), 'updated_at' => now()]);
            }
        }
        Setting::previewKey();

        // Coming Soon wording, image and SEO text (never overwrites existing values)
        (new \Database\Seeders\SiteContentSeeder())->run();
    }

    public function down(): void
    {
        DB::table('settings')->whereIn('key', ['site_coming_soon', 'site_noindex', 'site_preview_key'])->delete();
    }
};
