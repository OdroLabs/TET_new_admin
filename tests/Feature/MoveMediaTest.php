<?php
namespace Tests\Feature;

use App\Models\Product;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MoveMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_moves_local_images_and_rewrites_references()
    {
        $cdn = 'https://ngowebsites.sfo3.cdn.digitaloceanspaces.com/TET';
        Storage::fake('public');
        Storage::fake('spaces', ['url' => $cdn]);
        Storage::disk('public')->put('homepage/hero.jpg', 'a');
        Storage::disk('public')->put('homepage/impact/c1.png', 'b');
        Storage::disk('public')->put('products/p.webp', 'c');

        DB::table('settings')->updateOrInsert(['key' => 'hero_image_main'], ['value' => 'homepage/hero.jpg']);
        DB::table('settings')->updateOrInsert(['key' => 'impact_cards'], ['value' => json_encode([['title' => 'x', 'image' => 'homepage/impact/c1.png'], ['image' => 'gone/missing.jpg']])]);
        DB::table('settings')->updateOrInsert(['key' => 'hero_title'], ['value' => json_encode(['en' => 'Hello.jpg is not a path', 'si' => ''])]);
        Product::query()->delete();
        $prod = new Product(); $prod->setTranslation('title', 'en', 'P'); $prod->setTranslation('description', 'en', '');
        $prod->price = 1; $prod->image = 'products/p.webp'; $prod->save();

        $this->artisan('media:move-to-spaces --dry-run')->assertSuccessful();
        $this->assertSame('homepage/hero.jpg', DB::table('settings')->where('key', 'hero_image_main')->value('value'));
        $this->assertSame([], Storage::disk('spaces')->allFiles());

        $this->artisan('media:move-to-spaces')->assertSuccessful();

        $this->assertSame("$cdn/homepage/hero.jpg", DB::table('settings')->where('key', 'hero_image_main')->value('value'));
        $cards = json_decode(DB::table('settings')->where('key', 'impact_cards')->value('value'), true);
        $this->assertSame("$cdn/homepage/impact/c1.png", $cards[0]['image']);
        $this->assertSame('gone/missing.jpg', $cards[1]['image']);
        $this->assertSame('Hello.jpg is not a path', json_decode(DB::table('settings')->where('key', 'hero_title')->value('value'), true)['en']);
        $this->assertSame("$cdn/products/p.webp", $prod->fresh()->image);
        // seeded projects use Unsplash URLs -> untouched
        $this->assertStringStartsWith('https://images.unsplash.com/', Project::first()->images[0]);
        Storage::disk('spaces')->assertExists(['homepage/hero.jpg', 'homepage/impact/c1.png', 'products/p.webp']);

        // idempotent
        $this->artisan('media:move-to-spaces')->assertSuccessful()->expectsOutputToContain('Moved 0 file(s)');
    }
}
