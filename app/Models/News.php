<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = [];
    public $translatable = ['title', 'content'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
