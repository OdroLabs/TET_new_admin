<?php
namespace Tests\Feature;

use App\Livewire\ManageSiteStatus;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SiteStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_endpoint_and_private_key()
    {
        $key = Setting::previewKey();
        $this->assertSame(32, strlen($key));

        $this->getJson('/api/site-status')->assertOk()->assertExactJson(['coming_soon' => false, 'noindex' => false, 'preview' => false]);
        $this->getJson('/api/site-status?key=' . $key)->assertJsonPath('preview', true);
        $this->getJson('/api/site-status?key=nope')->assertJsonPath('preview', false);

        // the preview key is never published
        $this->assertArrayNotHasKey('site_preview_key', $this->getJson('/api/settings')->json());
        $this->assertSame('Something beautiful', $this->getJson('/api/settings')->json('cs_title_1.en'));
    }

    public function test_admin_page_switches_and_content()
    {
        $this->get('/admin/site-status')->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create());
        $this->get('/admin/site-status')->assertOk()->assertSee('Coming Soon mode')->assertSee('tet_preview=', false);

        // switches save instantly
        Livewire::test(ManageSiteStatus::class)->set('comingSoon', true)->set('noindex', true);
        $this->getJson('/api/site-status')->assertJson(['coming_soon' => true, 'noindex' => true]);
        $this->get('/admin/home')->assertSee('Coming Soon');     // sidebar badge

        // content + launch date
        Livewire::test(ManageSiteStatus::class)
            ->set('texts.cs_title_1.en', 'Almost there')
            ->set('texts.cs_title_1.si', 'ළඟදීම')
            ->set('contactEmail', 'hello@tet.lk')
            ->call('save')->assertHasNoErrors();
        $this->assertSame('Almost there', Setting::text('cs_title_1'));
        $this->assertSame('ළඟදීම', Setting::text('cs_title_1', 'si'));
        $this->assertSame('hello@tet.lk', Setting::text('cs_contact_email'));

        Livewire::test(ManageSiteStatus::class)->set('contactEmail', 'not-an-email')->call('save')->assertHasErrors('contactEmail');

        // regenerate the key -> old links stop working
        $old = Setting::previewKey();
        Livewire::test(ManageSiteStatus::class)->call('regenerateKey');
        $this->getJson('/api/site-status?key=' . $old)->assertJsonPath('preview', false);
        $this->getJson('/api/site-status?key=' . Setting::previewKey())->assertJsonPath('preview', true);

        // admin preview frames carry the key so they show the real site
        $this->get('/admin/home')->assertSee('tet_preview=' . Setting::previewKey(), false);
    }
}
