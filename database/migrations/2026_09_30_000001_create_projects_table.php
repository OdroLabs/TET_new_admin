<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->json('category')->nullable();   // Trilingual badge
            $table->json('title1');                 // Trilingual title part 1
            $table->json('title2')->nullable();     // Trilingual title part 2 (gradient)
            $table->json('summary')->nullable();    // Short card summary
            $table->json('long_desc')->nullable();  // Modal case study
            $table->json('status')->nullable();     // Phase / status badge
            $table->json('images')->nullable();     // Array of storage paths or URLs
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        $this->importLegacyProjectSettings();

        // Nothing entered in the old 4-slot editor yet: start with the site's default projects.
        if (DB::table('projects')->count() === 0) {
            (new \Database\Seeders\ProjectSeeder())->run();
        }
    }

    /**
     * Carry the old fixed "pj_1_* ... pj_4_*" settings over into real rows,
     * so nothing already entered in the admin is lost.
     */
    private function importLegacyProjectSettings(): void
    {
        if (!Schema::hasTable('settings')) {
            return;
        }

        $settings = DB::table('settings')->where('key', 'like', 'pj_%')->pluck('value', 'key');

        $text = function (string $key) use ($settings): ?string {
            $raw = $settings[$key] ?? null;
            if ($raw === null || $raw === '') return null;
            $decoded = json_decode($raw, true);
            $value = is_array($decoded) ? $decoded : ['en' => trim($raw, "\"'")];
            $value = array_merge(['en' => '', 'si' => '', 'ta' => ''], array_map(fn ($v) => (string) ($v ?? ''), $value));
            return implode('', $value) === '' ? null : json_encode($value, JSON_UNESCAPED_UNICODE);
        };

        $image = function (string $key) use ($settings): ?string {
            $raw = $settings[$key] ?? null;
            if (!$raw) return null;
            $decoded = json_decode($raw, true);
            if (is_array($decoded)) $raw = $decoded['en'] ?? reset($decoded);
            if (is_string($decoded)) $raw = $decoded;
            $raw = is_string($raw) ? trim($raw, "\"'") : null;
            return $raw ?: null;
        };

        for ($p = 1; $p <= 4; $p++) {
            $title1 = $text("pj_{$p}_title1");
            if (!$title1) continue;

            $images = array_values(array_filter([
                $image("pj_{$p}_img1"), $image("pj_{$p}_img2"), $image("pj_{$p}_img3"),
            ]));

            DB::table('projects')->insert([
                'category' => $text("pj_{$p}_cat"),
                'title1' => $title1,
                'title2' => $text("pj_{$p}_title2"),
                'summary' => $text("pj_{$p}_desc"),
                'long_desc' => $text("pj_{$p}_long_desc"),
                'status' => $text("pj_{$p}_status"),
                'images' => json_encode($images),
                'order' => $p,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
