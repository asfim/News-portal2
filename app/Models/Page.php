<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'title_en',
        'slug',
        'content',
        'content_en',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status'
    ];

    public function getTranslatedTitleAttribute()
    {
        return app()->getLocale() === 'en' && !empty($this->title_en) ? $this->title_en : $this->title;
    }

    public function getTranslatedContentAttribute()
    {
        return app()->getLocale() === 'en' && !empty($this->content_en) ? $this->content_en : $this->content;
    }

    protected $casts = [
        'status' => 'boolean',
    ];
}
