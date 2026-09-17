<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Event extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'cat', 'date', 'location', 'excerpt', 'full_story', 'cover_image', 'gallery_images', 'order', 'is_published'
    ];

    public $translatable = ['title', 'cat', 'location', 'excerpt', 'full_story'];

    protected $casts = [
        'gallery_images' => 'array',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];
}