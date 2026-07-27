<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'username',
        'email',
        'phone',
        'profile_photo',
        'designation',
        'bio',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * User associated with the author.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * News articles written by the author.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
