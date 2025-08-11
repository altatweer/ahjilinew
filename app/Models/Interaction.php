<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Interaction extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'type',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public $timestamps = true;
    
    const UPDATED_AT = null;

    /**
     * Get the user that owns the interaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post that was interacted with
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Scope a query to only include interactions of a given type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include likes
     */
    public function scopeLikes($query)
    {
        return $query->where('type', 'like');
    }

    /**
     * Scope a query to only include shares
     */
    public function scopeShares($query)
    {
        return $query->where('type', 'share');
    }

    /**
     * Scope a query to only include saves
     */
    public function scopeSaves($query)
    {
        return $query->where('type', 'save');
    }

    /**
     * Scope a query to only include reports
     */
    public function scopeReports($query)
    {
        return $query->where('type', 'report');
    }
}
