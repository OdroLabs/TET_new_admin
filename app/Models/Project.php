<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasTranslations;

    protected $fillable = [
        'category', 'title1', 'title2', 'summary', 'long_desc', 'status',
        'images', 'order', 'is_published',
    ];

    public $translatable = ['category', 'title1', 'title2', 'summary', 'long_desc', 'status'];

    protected $casts = [
        'images' => 'array',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted()
    {
        $flush = fn () => Cache::forget('api_projects_list');
        static::saved($flush);
        static::deleted($flush);
    }

    /** Public URL for a stored path or an absolute URL (for admin thumbnails). */
    public static function imageUrl(?string $path): ?string
    {
        return \App\Support\Media::url($path);
    }
}
