<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_en',
        'slug', 'description', 'status'];

    public function getTranslatedNameAttribute()
    {
        return app()->getLocale() === 'en' && !empty($this->name_en) ? $this->name_en : $this->name;
    }

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * News articles associated with the tag.
     */
    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class);
    }
}
