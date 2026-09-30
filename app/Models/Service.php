<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    protected $fillable = ['tag', 'title', 'description', 'image', 'order', 'is_published'];

    public $translatable = ['tag', 'title', 'description'];

    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted()
    {
        $flush = fn () => Cache::forget('api_services_list');
        static::saved($flush);
        static::deleted($flush);
    }
}
