<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->json('tag')->nullable();          // Trilingual category tag
            $table->json('title');                    // Trilingual title
            $table->json('description')->nullable();  // Trilingual description
            $table->string('image')->nullable();      // CDN URL, legacy storage path or external URL
            $table->integer('order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        $this->importLegacyServiceSettings();
    }

    /**
     * Turn the old fixed 6 cards (service_1_* … service_6_* settings, with the
     * website's built-in defaults for anything never edited) into rows, so the
     * Services page looks exactly the same after the switch.
     */
    private function importLegacyServiceSettings(): void
    {
        $defaults = \Database\Seeders\ServiceSeeder::defaults();

        $settings = Schema::hasTable('settings')
            ? DB::table('settings')->where('key', 'like', 'service_%')->pluck('value', 'key')
            : collect();

        $text = function (string $key, string $fallback) use ($settings): string {
            $raw = $settings[$key] ?? null;
            $value = ['en' => '', 'si' => '', 'ta' => ''];
            if ($raw !== null && $raw !== '') {
                $decoded = json_decode($raw, true);
                $decoded = is_array($decoded) ? $decoded : ['en' => trim($raw, "\"'")];
                foreach ($value as $lang => $_) $value[$lang] = (string) ($decoded[$lang] ?? '');
            }
            if ($value['en'] === '') $value['en'] = $fallback;
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        };

        $image = function (string $key, string $fallback) use ($settings): string {
            $raw = $settings[$key] ?? null;
            if ($raw) {
                $decoded = json_decode($raw, true);
                if (is_array($decoded)) $raw = $decoded['en'] ?? reset($decoded);
                elseif (is_string($decoded)) $raw = $decoded;
                $raw = is_string($raw) ? trim($raw, "\"'") : null;
            }
            return $raw ?: $fallback;
        };

        foreach ($defaults as $i => $d) {
            $n = $i + 1;
            DB::table('services')->insert([
                'tag' => $text("service_{$n}_tag", $d['tag']),
                'title' => $text("service_{$n}_title", $d['title']),
                'description' => $text("service_{$n}_desc", $d['description']),
                'image' => $image("service_{$n}_img", $d['image']),
                'order' => $n,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
