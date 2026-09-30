<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\Event;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * One-time move of images already on the local public disk (storage/app/public)
 * into DigitalOcean Spaces (TET/ folder), rewriting DB references to CDN URLs.
 *
 *   php artisan media:move-to-spaces --dry-run
 *   php artisan media:move-to-spaces
 */
class MoveMediaToSpaces extends Command
{
    protected $signature = 'media:move-to-spaces {--dry-run : Show what would move without uploading or changing the database}';

    protected $description = 'Upload existing local images to DigitalOcean Spaces (TET/) and point the database at them';

    private array $moved = [];   // local path => CDN URL
    private array $missing = [];

    public function handle(): int
    {
        if (!config('filesystems.disks.spaces.bucket')) {
            $this->error('DO_SPACE is not set in .env.');
            return self::FAILURE;
        }

        $dry = (bool) $this->option('dry-run');
        $this->moved = [];
        $this->missing = [];

        // settings: plain strings or JSON (trilingual values, impact_cards, ...)
        foreach (DB::table('settings')->get(['id', 'key', 'value']) as $row) {
            $new = $this->convertRaw($row->value);
            if ($new !== $row->value) {
                $this->line("settings.{$row->key}");
                if (!$dry) DB::table('settings')->where('id', $row->id)->update(['value' => $new]);
            }
        }

        $columns = [
            [Activity::class, ['image']],
            [Event::class, ['cover_image', 'gallery_images']],
            [Product::class, ['image']],
            [Project::class, ['images']],
            [Service::class, ['image']],
        ];
        foreach ($columns as [$model, $fields]) {
            $table = (new $model)->getTable();
            foreach (DB::table($table)->get(array_merge(['id'], $fields)) as $row) {
                $changes = [];
                foreach ($fields as $field) {
                    $new = $this->convertRaw($row->$field);
                    if ($new !== $row->$field) $changes[$field] = $new;
                }
                if ($changes) {
                    $this->line("{$table}#{$row->id} " . implode(', ', array_keys($changes)));
                    if (!$dry) DB::table($table)->where('id', $row->id)->update($changes);
                }
            }
        }

        if (!$dry) {
            foreach (['api_settings_map', 'api_projects_list', 'api_services_list', 'api_products_list', 'api_activities_list', 'api_events_list'] as $key) {
                cache()->forget($key);
            }
        }

        $this->newLine();
        $this->info(($dry ? 'Would move ' : 'Moved ') . count($this->moved) . ' file(s) to Spaces.');
        if ($this->missing) {
            $this->warn(count($this->missing) . ' referenced file(s) not found locally (left unchanged): ' . implode(', ', array_slice($this->missing, 0, 10)));
        }
        if (!$dry && $this->moved) {
            $this->line('Local copies were kept in storage/app/public; delete them once you have checked the site.');
        }

        return self::SUCCESS;
    }

    /** Convert a raw DB value (string or JSON) and return the new raw value. */
    private function convertRaw(?string $raw): ?string
    {
        if ($raw === null || $raw === '') return $raw;

        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && (is_array($decoded) || is_string($decoded))) {
            $converted = $this->convertValue($decoded);
            return $converted === $decoded ? $raw : json_encode($converted, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $this->convertValue($raw);
    }

    private function convertValue(mixed $value): mixed
    {
        if (is_array($value)) {
            return array_map(fn ($v) => $this->convertValue($v), $value);
        }
        if (!is_string($value)) return $value;

        $path = preg_replace('#^/?(storage/)?#', '', trim($value, "\"' "));
        if (!preg_match('#^[\w\-./]+\.(jpe?g|png|gif|webp|svg|avif|bmp|ico)$#i', $path) || str_contains($path, '..')) {
            return $value;
        }

        if (isset($this->moved[$path])) return $this->moved[$path];

        $local = Storage::disk('public');
        if (!$local->exists($path)) {
            $this->missing[] = $path;
            return $value;
        }

        if ($this->option('dry-run')) {
            return $this->moved[$path] = Storage::disk('spaces')->url($path);
        }

        $stream = $local->readStream($path);
        Storage::disk('spaces')->writeStream($path, $stream, ['visibility' => 'public']);
        if (is_resource($stream)) fclose($stream);

        return $this->moved[$path] = Storage::disk('spaces')->url($path);
    }
}
