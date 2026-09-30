<?php
namespace Tests\Feature;

use App\Livewire\ManageNewsPage;
use App\Livewire\ManageProducts;
use App\Livewire\ManageProjects;
use App\Models\Product;
use App\Models\Project;
use App\Models\User;
use App\Support\Media;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    private string $cdn = 'https://ngowebsites.sfo3.cdn.digitaloceanspaces.com';

    public function test_config_derives_region_endpoint()
    {
        $this->assertSame('https://sfo3.digitaloceanspaces.com', config('filesystems.disks.spaces.endpoint'));
        $this->assertSame('TET', config('filesystems.disks.spaces.root'));
        $this->assertSame('spaces', config('filesystems.media'));
    }

    public function test_uploads_go_to_spaces_and_deletes_work()
    {
        // stand-in for the Space: local fake disk whose URL mimics the CDN + TET root
        Storage::fake('spaces', ['url' => $this->cdn . '/TET']);
        Storage::fake('public');
        config(['filesystems.disks.spaces.url' => $this->cdn]);   // Media::delete maps back using the real CDN base
        $this->actingAs(User::factory()->create());

        Livewire::test(ManageProjects::class)
            ->call('newProject')->set('form.title1.en', 'Cloud')
            ->set('uploadBatch', [UploadedFile::fake()->image('a.jpg')])
            ->call('save')->assertHasNoErrors();

        $url = Project::where('order', 5)->first()->images[0];
        $this->assertStringStartsWith($this->cdn . '/TET/projects/', $url);
        $key = substr($url, strlen($this->cdn . '/TET/'));
        Storage::disk('spaces')->assertExists($key);
        $this->assertSame([], Storage::disk('public')->allFiles());

        // admin preview + API use the URL as-is
        $this->assertSame($url, Media::url($url));
        $this->getJson('/api/projects')->assertJsonFragment(['images' => [$url]]);

        // delete project -> object removed from the Space
        Livewire::test(ManageProjects::class)->call('deleteProject', Project::where('order', 5)->value('id'));
        Storage::disk('spaces')->assertMissing($key);

        // products: replace image deletes the old object
        Livewire::test(ManageProducts::class)->call('newProduct')->set('productState.title.en', 'P')
            ->set('productImage', UploadedFile::fake()->image('p.jpg'))->call('saveProduct')->assertHasNoErrors();
        $first = Product::latest('id')->first()->image;
        $this->assertStringStartsWith($this->cdn . '/TET/products/', $first);
        Livewire::test(ManageProducts::class)->call('editProduct', Product::latest('id')->first()->id)
            ->set('productImage', UploadedFile::fake()->image('p2.jpg'))->call('saveProduct');
        Storage::disk('spaces')->assertMissing(substr($first, strlen($this->cdn . '/TET/')));
        $this->assertCount(1, Storage::disk('spaces')->allFiles());

        // legacy values still resolve, and deletes outside TET/ or on other hosts are ignored
        $this->assertSame(asset('storage/projects/old.jpg'), Media::url('projects/old.jpg'));
        Storage::disk('spaces')->put('other.jpg', 'x');
        Media::delete($this->cdn . '/OTHER/other.jpg');
        Media::delete('https://images.unsplash.com/photo-1');
        Storage::disk('spaces')->assertExists('other.jpg');

        // pages render with Spaces URLs
        $this->get('/admin/products')->assertOk()->assertSee($this->cdn . '/TET/products/', false);
    }
}
