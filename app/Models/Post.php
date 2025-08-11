<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'content',
        'image_url',
        'type',
        'category',
        'status',
        'is_active',
        'hashtags',
        'location',
        'likes_count',
        'comments_count',
        'shares_count',
        'views_count',
        'featured_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'featured_at' => 'datetime',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'shares_count' => 'integer',
        'views_count' => 'integer',
    ];

    /**
     * العلاقات
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeAnonymous($query)
    {
        return $query->where('type', 'anonymous');
    }

    public function scopeCommunity($query)
    {
        return $query->where('type', 'community');
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeComplaints($query)
    {
        return $query->where('category', 'complaint');
    }

    public function scopeExperiences($query)
    {
        return $query->where('category', 'experience');
    }

    public function scopeRecommendations($query)
    {
        return $query->where('category', 'recommendation');
    }

    public function scopeQuestions($query)
    {
        return $query->where('category', 'question');
    }

    public function scopeReviews($query)
    {
        return $query->where('category', 'review');
    }

    public function scopeFeatured($query)
    {
        return $query->whereNotNull('featured_at');
    }

    public function scopeNotFeatured($query)
    {
        return $query->whereNull('featured_at');
    }

    /**
     * Accessors
     */
    public function getIsAnonymousAttribute(): bool
    {
        return $this->user_id === null || $this->type === 'anonymous';
    }

    public function getAuthorNameAttribute(): string
    {
        return $this->user ? $this->user->display_name : 'مجهول';
    }

    public function getIsFeaturedAttribute(): bool
    {
        return !is_null($this->featured_at);
    }
}
