<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

/**
 * Single place for storing, displaying and deleting uploaded images.
 *
 * With DigitalOcean Spaces configured (DO_* in .env) uploads go to the
 * "spaces" disk under the TET/ folder and the full CDN URL is saved in the DB.
 * Older values (relative paths like "projects/a.jpg") still resolve to the
 * local public disk, so existing content keeps working.
 */
class Media
{
    public static function diskName(): string
    {
        return config('filesystems.media', 'public');
    }

    /** Store an upload in $directory and return the value to save in the DB. */
    public static function store(UploadedFile $file, string $directory): string
    {
        $disk = static::diskName();
        $path = $file->storePublicly($directory, $disk);

        if (!$path) {
            throw new RuntimeException("Could not upload {$file->getClientOriginalName()} to the {$disk} disk.");
        }

        return $disk === 'public' ? $path : Storage::disk($disk)->url($path);
    }

    /** Browser URL for a stored value (absolute URL or legacy local path). */
    public static function url(?string $value): ?string
    {
        if (!$value) return null;
        $value = trim($value, "\"' ");
        if (preg_match('#^(https?:)?//#', $value)) return $value;

        return asset('storage/' . preg_replace('#^/?(storage/)?#', '', $value));
    }

    /** Delete a stored file. Never throws; external URLs (e.g. Unsplash) are ignored. */
    public static function delete(?string $value): void
    {
        if (!$value) return;
        $value = trim($value, "\"' ");

        try {
            if (preg_match('#^https?://#', $value)) {
                $key = static::spacesKey($value);
                if ($key !== null) Storage::disk('spaces')->delete($key);
                return;
            }

            if (Storage::disk('public')->exists($value)) {
                Storage::disk('public')->delete($value);
            }
        } catch (Throwable $e) {
            Log::warning("Could not delete media {$value}: " . $e->getMessage());
        }
    }

    /** Turn a Spaces CDN/origin URL back into a key relative to the disk root (TET/). */
    private static function spacesKey(string $url): ?string
    {
        $config = config('filesystems.disks.spaces', []);
        if (empty($config['bucket'])) return null;

        $root = trim($config['root'] ?? '', '/');
        $bases = array_filter([
            $config['url'] ?? null,
            env('DO_ENDPOINT'),
            $config['endpoint'] ?? null ? rtrim($config['endpoint'], '/') . '/' . $config['bucket'] : null,
        ]);

        foreach ($bases as $base) {
            $base = rtrim($base, '/') . '/';
            if (!str_starts_with($url, $base)) continue;

            $key = rawurldecode(strtok(substr($url, strlen($base)), '?'));
            if ($root !== '') {
                if (!str_starts_with($key, $root . '/')) return null;   // outside the TET folder: leave it alone
                $key = substr($key, strlen($root) + 1);
            }
            return $key;
        }

        return null;
    }
}
