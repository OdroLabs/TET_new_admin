<?php
namespace Tests\Feature;

use App\Livewire\ManageServices;
use App\Livewire\ManageServicesPage;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ServicesTest extends TestCase
{
    use RefreshDatabase;

    private string $cdn = 'https://ngowebsites.sfo3.cdn.digitaloceanspaces.com';

    public function test_services_crud()
    {
        Storage::fake('spaces', ['url' => $this->cdn . '/TET']);
        config(['filesystems.disks.spaces.url' => $this->cdn]);

        // migration seeded the 6 defaults
        $this->assertSame(6, Service::count());
        $this->assertSame('Legal Aid & Human Rights', Service::orderBy('order')->first()->getTranslation('title', 'en'));

        $this->get('/admin/service-list')->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create());
        $this->get('/admin/service-list')->assertOk()->assertSee('Services Manager')->assertSee('Crisis Intervention');
        $this->get('/admin/services')->assertOk()->assertSee('Open Manager');
        Livewire::test(ManageServicesPage::class)->set('state.s_hero_title.en', 'Hi')->call('save')->assertHasNoErrors();

        // create 7th with photo
        Livewire::test(ManageServices::class)->call('newService')
            ->set('form.title.en', 'Housing Support')->set('form.tag.en', 'Shelter')->set('form.description.ta', 'தமிழ்')
            ->set('newImage', UploadedFile::fake()->image('h.jpg'))
            ->call('save')->assertHasNoErrors();
        $s7 = Service::where('order', 7)->first();
        $this->assertSame('Housing Support', $s7->getTranslation('title', 'en'));
        $this->assertStringStartsWith($this->cdn . '/TET/services/', $s7->image);
        $key = substr($s7->image, strlen($this->cdn . '/TET/'));
        Storage::disk('spaces')->assertExists($key);

        Livewire::test(ManageServices::class)->call('newService')->call('save')->assertHasErrors('form.title.en');

        // replace photo -> old deleted
        Livewire::test(ManageServices::class)->call('editService', $s7->id)
            ->assertSet('form.tag.en', 'Shelter')
            ->set('newImage', UploadedFile::fake()->image('h2.jpg'))->call('save');
        Storage::disk('spaces')->assertMissing($key);
        $key2 = substr($s7->fresh()->image, strlen($this->cdn . '/TET/'));

        // remove photo
        Livewire::test(ManageServices::class)->call('editService', $s7->id)->call('clearImage')->call('save');
        $this->assertNull($s7->fresh()->image);
        Storage::disk('spaces')->assertMissing($key2);

        // reorder + hide + API
        Livewire::test(ManageServices::class)->call('move', $s7->id, 'up');
        $this->assertSame(6, $s7->fresh()->order);
        Livewire::test(ManageServices::class)->call('togglePublished', $s7->id);
        $api = $this->getJson('/api/services')->assertOk()->json();
        $this->assertCount(6, $api);
        Livewire::test(ManageServices::class)->call('togglePublished', $s7->id);
        $api = $this->getJson('/api/services')->json();
        $this->assertCount(7, $api);
        $this->assertSame('Housing Support', $api[5]['title']['en']);
        $this->assertSame('தமிழ்', $api[5]['description']['ta']);

        // delete (unsplash images are never deleted remotely; just the row)
        Livewire::test(ManageServices::class)->call('deleteService', Service::orderBy('order')->first()->id);
        $this->assertSame(6, Service::count());
    }

    public function test_legacy_service_settings_are_imported()
    {
        // re-run the migration with legacy settings present
        $migration = require base_path('database/migrations/2026_09_30_000003_create_services_table.php');
        $migration->down();
        DB::table('settings')->insert([
            ['key' => 'service_2_title', 'value' => json_encode(['en' => 'Edited Health', 'si' => 'සෞඛ්‍ය', 'ta' => ''])],
            ['key' => 'service_2_img', 'value' => $this->cdn . '/TET/services/x.jpg'],
            ['key' => 'service_5_desc', 'value' => json_encode(['en' => '', 'si' => 'si only', 'ta' => ''])],
        ]);
        $migration->up();

        $rows = Service::orderBy('order')->get();
        $this->assertCount(6, $rows);
        $this->assertSame('Edited Health', $rows[1]->getTranslation('title', 'en'));
        $this->assertSame('සෞඛ්‍ය', $rows[1]->getTranslation('title', 'si'));
        $this->assertSame($this->cdn . '/TET/services/x.jpg', $rows[1]->image);
        $this->assertSame('Legal Aid & Human Rights', $rows[0]->getTranslation('title', 'en'));
        $this->assertStringStartsWith('https://images.unsplash.com/', $rows[0]->image);
        // si-only legacy desc keeps si, English falls back to default text
        $this->assertSame('si only', $rows[4]->getTranslation('description', 'si'));
        $this->assertStringStartsWith('Our specialized team', $rows[4]->getTranslation('description', 'en'));
    }
}
