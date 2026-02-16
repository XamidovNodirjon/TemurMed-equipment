<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'is_active',
        'sort_order',
    ];

    public $translatable = ['title', 'subtitle'];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'title' => 'array',
        'subtitle' => 'array',
    ];
}
