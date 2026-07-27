<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'author_id',
        'title',
        'slug',
        'short_description',
        'content',
        'featured_image',
        'thumbnail',
        'video_url',
        'source_name',
        'source_url',
        'breaking_news',
        'featured_news',
        'trending_news',
        'editor_choice',
        'is_latest',
        'gallery_images',
        'status',
        'publish_at',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
    ];

    protected $casts = [
        'breaking_news' => 'boolean',
        'featured_news' => 'boolean',
        'trending_news' => 'boolean',
        'editor_choice' => 'boolean',
        'is_latest' => 'boolean',
        'gallery_images' => 'array',
        'publish_at' => 'datetime',
        'views' => 'integer',
    ];

    /**
     * Category relationship.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Subcategory relationship.
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    /**
     * Author relationship.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    /**
     * Tags associated with this news.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Comments on this news.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    /**
     * All comments (including pending/rejected) on this news.
     */
    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Bookmarks for this news.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * View history tracking log.
     */
    public function viewLogs(): HasMany
    {
        return $this->hasMany(View::class);
    }

    /**
     * Featured image media relationship.
     */
    public function featuredImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image');
    }

    /**
     * Thumbnail media relationship.
     */
    public function thumbnailImage(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'thumbnail');
    }

    /**
     * Scope query to only include published news.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('publish_at')
                    ->orWhere('publish_at', '<=', now());
            });
    }

    /**
     * Scope query to breaking news.
     */
    public function scopeBreaking(Builder $query): Builder
    {
        return $query->where('breaking_news', true);
    }

    /**
     * Scope query to featured news.
     */
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured_news', true);
    }

    /**
     * Scope query to trending news.
     */
    public function scopeTrending(Builder $query): Builder
    {
        return $query->where('trending_news', true);
    }

    /**
     * Scope query to editor choices.
     */
    public function scopeEditorChoice(Builder $query): Builder
    {
        return $query->where('editor_choice', true);
    }
}
