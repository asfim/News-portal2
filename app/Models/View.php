<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class View extends Model
{
    use HasFactory;

    protected $fillable = ['news_id', 'ip_address', 'user_agent', 'viewed_date'];

    protected $casts = [
        'viewed_date' => 'date',
    ];

    /**
     * News article that was viewed.
     */
    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }
}
