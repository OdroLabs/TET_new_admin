<?php
namespace Tests\Feature;

use App\Livewire\ManageMailSettings;
use App\Livewire\ManageProjects;
use App\Models\MailSetting;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    public function test_everything()
    {
        Storage::fake('public');
        Storage::fake('spaces', ['url' => 'https://ngowebsites.sfo3.cdn.digitaloceanspaces.com/TET']);
        config(['filesystems.disks.spaces.url' => 'https://ngowebsites.sfo3.cdn.digitaloceanspaces.com']);
        $user = User::factory()->create();

        // guests are redirected
        $this->get('/admin/project-list')->assertRedirect('/admin/login');
        $this->get('/admin/email-settings')->assertRedirect('/admin/login');

        $this->actingAs($user);
        $this->get('/admin/project-list')->assertOk()->assertSee('Projects Manager')->assertSee('Sex Work Policy');
        $this->get('/admin/email-settings')->assertOk()->assertSee('Email &amp; SMTP', false);
        $this->get('/admin/projects')->assertOk()->assertSee('Open Manager');

        $this->assertSame(4, Project::count());

        // create a 5th and 6th project with photos
        foreach (['Fifth', 'Sixth'] as $name) {
            Livewire::test(ManageProjects::class)
                ->call('newProject')
                ->set('form.title1.en', $name)
                ->set('form.title1.si', 'සිංහල')
                ->set('uploadBatch', [UploadedFile::fake()->image('a.jpg'), UploadedFile::fake()->image('b.jpg')])
                ->assertCount('newImages', 2)
                ->call('save')
                ->assertHasNoErrors();
        }
        $this->assertSame(6, Project::count());
        $p6 = Project::where('order', 6)->first();
        $this->assertSame('Sixth', $p6->getTranslation('title1', 'en'));
        $this->assertCount(2, $p6->images);
        Storage::disk('spaces')->assertExists(substr($p6->images[0], strlen('https://ngowebsites.sfo3.cdn.digitaloceanspaces.com/TET/')));

        // validation
        Livewire::test(ManageProjects::class)->call('newProject')->call('save')->assertHasErrors('form.title1.en');

        // edit: remove one photo, unpublish
        $removed = $p6->images[0];
        Livewire::test(ManageProjects::class)
            ->call('editProject', $p6->id)
            ->assertSet('form.title1.en', 'Sixth')
            ->call('removeExistingImage', 0)
            ->set('isPublished', false)
            ->call('save')->assertHasNoErrors();
        $p6->refresh();
        $this->assertCount(1, $p6->images);
        Storage::disk('spaces')->assertMissing(substr($removed, strlen('https://ngowebsites.sfo3.cdn.digitaloceanspaces.com/TET/')));
        $this->assertFalse($p6->is_published);

        // reorder: move 6th up
        Livewire::test(ManageProjects::class)->call('move', $p6->id, 'up');
        $this->assertSame(5, $p6->fresh()->order);

        // API returns only published, in order
        $api = $this->getJson('/api/projects')->assertOk()->json();
        $this->assertCount(5, $api);
        $this->assertSame('Fifth', $api[4]['title1']['en']);
        $this->assertArrayHasKey('images', $api[0]);

        // publish toggle clears API cache
        Livewire::test(ManageProjects::class)->call('togglePublished', $p6->id);
        $this->assertCount(6, $this->getJson('/api/projects')->json());

        // delete
        Livewire::test(ManageProjects::class)->call('deleteProject', $p6->id);
        $this->assertSame(5, Project::count());

        // mail settings
        Livewire::test(ManageMailSettings::class)
            ->set('isEnabled', true)
            ->call('save')->assertHasErrors(['host', 'fromAddress', 'to']);

        Livewire::test(ManageMailSettings::class)
            ->set('newTo', 'bad-email')->call('addTo')->assertHasErrors('newTo')
            ->set('newTo', 'a@tet.lk, b@tet.lk')->call('addTo')->assertSet('to', ['a@tet.lk', 'b@tet.lk'])
            ->set('newCc', 'c@tet.lk')->call('addCc')
            ->call('removeTo', 0)
            ->set('isEnabled', true)
            ->set('host', 'smtp.example.com')->set('port', 587)->set('username', 'u')->set('password', 'secret')
            ->set('fromAddress', 'noreply@tet.lk')
            ->call('save')->assertHasNoErrors();

        $s = MailSetting::current();
        $this->assertSame(['b@tet.lk'], $s->to_addresses);
        $this->assertSame(['c@tet.lk'], $s->cc_addresses);
        $this->assertSame('secret', $s->password);
        $this->assertNotSame('secret', \DB::table('mail_settings')->value('password')); // encrypted at rest

        // reload: password not echoed, kept when blank
        Livewire::test(ManageMailSettings::class)
            ->assertSet('password', '')->assertSet('hasPassword', true)
            ->call('save');
        $this->assertSame('secret', MailSetting::current()->password);

        // test send to an unreachable host reports failure instead of crashing
        Livewire::test(ManageMailSettings::class)
            ->set('host', '127.0.0.1')->set('port', 1)
            ->call('sendTest')
            ->assertSet('testOk', false);
    }
}
