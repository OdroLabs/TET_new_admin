<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Activity extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'cat', 'date', 'location', 'excerpt', 'full_story', 'image', 'order', 'is_published'
    ];

    public $translatable = ['title', 'cat', 'location', 'excerpt', 'full_story'];

    protected $casts = [
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        return Storage::disk('public')->url($this->image);
    }
}