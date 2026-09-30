<?php
namespace Tests\Feature;

use App\Livewire\ManageFooter;
use App\Livewire\ManageSiteWording;
use App\Models\Setting;
use App\Models\User;
use Database\Seeders\SiteContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SiteContentTest extends TestCase
{
    use RefreshDatabase;

    private function raw(string $key) { return DB::table('settings')->where('key', $key)->value('value'); }

    public function test_migration_seeds_every_registry_key()
    {
        $keys = array_column(SiteContentSeeder::registry(), 'key');
        $this->assertGreaterThan(500, count($keys));
        $this->assertSame(count($keys), count(array_unique($keys)), 'duplicate keys in registry');
        $this->assertSame([], array_values(array_diff($keys, DB::table('settings')->pluck('key')->all())));

        $api = $this->getJson('/api/settings')->assertOk()->json();
        $this->assertSame('Support Us', $api['btn_support']['en']);
        $this->assertSame('ආධාර කරන්න', $api['footer_btn_donate']['si']);                  // translations carried over
        $this->assertSame('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80', $api['hero_image_main']);
        $this->assertCount(8, $api['impact_cards']);
        $this->assertSame('/donate', Setting::text('nav_donate_url'));
    }

    public function test_seeder_never_overwrites_admin_edits_and_fills_blanks()
    {
        Setting::where('key', 'hero_title_1')->first()->setTranslations('value', ['en' => 'Edited', 'si' => 'සිං', 'ta' => ''])->save();
        Setting::where('key', 'impact_title')->first()->setTranslations('value', ['en' => '', 'si' => 'keep si', 'ta' => ''])->save();
        DB::table('settings')->where('key', 'footer_nav_about')->delete();
        Setting::where('key', 'nav_about')->first()->setTranslations('value', ['en' => 'Who we are', 'si' => '', 'ta' => ''])->save();
        DB::table('settings')->where('key', 'dn_bank_name')->delete();

        (new SiteContentSeeder())->run();
        (new SiteContentSeeder())->run(); // idempotent

        $this->assertSame(['en' => 'Edited', 'si' => 'සිං', 'ta' => ''], json_decode($this->raw('hero_title_1'), true));
        $this->assertSame('Real-World Impact', json_decode($this->raw('impact_title'), true)['en']);   // blank English filled
        $this->assertSame('keep si', json_decode($this->raw('impact_title'), true)['si']);           // other language kept
        $this->assertSame('Who we are', json_decode($this->raw('footer_nav_about'), true)['en']);   // copied from shared key
        $this->assertSame('Commercial Bank of Ceylon', Setting::text('dn_bank_name'));
    }

    public function test_donation_bank_details_come_from_settings()
    {
        DB::table('settings')->where('key', 'dn_bank_account_number')->update(['value' => json_encode(['en' => '1234-5678', 'si' => '', 'ta' => ''])]);
        $this->postJson('/api/donations', ['amount' => 1000, 'payment_method' => 'bank_transfer', 'is_anonymous' => true])
            ->assertCreated()
            ->assertJsonPath('bank_details.account_number', '1234-5678')
            ->assertJsonPath('bank_details.bank_name', 'Commercial Bank of Ceylon');
    }

    public function test_site_wording_page()
    {
        $cdn = 'https://ngowebsites.sfo3.cdn.digitaloceanspaces.com';
        Storage::fake('spaces', ['url' => $cdn . '/TET']);
        config(['filesystems.disks.spaces.url' => $cdn]);

        $this->get('/admin/site-wording')->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create());
        $this->get('/admin/site-wording')->assertOk()->assertSee('Site Wording')->assertSee('nav_about');

        // every tab renders
        foreach (array_keys(ManageSiteWording::GROUPS) as $g) {
            Livewire::test(ManageSiteWording::class)->set('group', $g)->assertOk();
        }

        // search across tabs
        $c = Livewire::test(ManageSiteWording::class)->set('search', 'crisis intervention');
        $this->assertNotEmpty($c->instance()->items);

        // edit a UI label in 3 languages + a plain value + upload an image
        Livewire::test(ManageSiteWording::class)
            ->set('group', 'booking')
            ->set('values.ui_booking_submit.en', 'Send Request')
            ->set('values.ui_booking_submit.si', 'යවන්න')
            ->set('group', 'donate')    // switching tabs reloads values...
            ->set('values.dn_amount_presets.en', '500, 2500')
            ->set('uploads.seo_donate_og_image', UploadedFile::fake()->image('og.jpg'))
            ->call('save')->assertHasNoErrors();

        // ...so the booking edit made before switching tabs is discarded (by design), donate edits saved
        $this->assertSame('Submit Commercial Request', Setting::text('ui_booking_submit'));
        $this->assertSame('500, 2500', Setting::text('dn_amount_presets'));
        $this->assertStringStartsWith($cdn . '/TET/site/', Setting::text('seo_donate_og_image'));

        Livewire::test(ManageSiteWording::class)->set('group', 'booking')
            ->set('values.ui_booking_submit.en', 'Send Request')->set('values.ui_booking_submit.si', 'යවන්න')
            ->call('save');
        $this->assertSame('Send Request', Setting::text('ui_booking_submit'));
        $this->assertSame('යවන්න', Setting::text('ui_booking_submit', 'si'));
        $this->assertSame('Send Request', $this->getJson('/api/settings')->json('ui_booking_submit.en'));
    }

    public function test_footer_editor_edits_footer_donate_button()
    {
        $this->actingAs(User::factory()->create());
        Livewire::test(ManageFooter::class)
            ->assertSet('state.footer_btn_donate.en', 'Make a Donation')
            ->set('state.footer_btn_donate.en', 'Give now')->call('save');
        $this->assertSame('Give now', Setting::text('footer_btn_donate'));
        $this->assertSame('Donate', Setting::text('btn_donate'));   // navbar button untouched
    }
}
