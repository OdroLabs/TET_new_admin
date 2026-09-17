<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'description', 'price', 'currency', 'specs', 
        'badge', 'icon', 'image', 'order', 'is_available'
    ];

    public $translatable = ['title', 'description'];

    protected $casts = [
        'price' => 'float',
        'is_available' => 'boolean',
        'order' => 'integer',
    ];
}