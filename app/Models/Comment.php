<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
        'parent_id',
        'content',
        'is_active',
        'status',
        'likes_count',
        'replies_count',
        'anonymous_name',
        'is_anonymous',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_anonymous' => 'boolean',
        'likes_count' => 'integer',
        'replies_count' => 'integer',
    ];

    /**
     * العلاقات
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
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

    public function scopeParentComments($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeAnonymous($query)
    {
        return $query->where('is_anonymous', true);
    }

    public function scopeRegistered($query)
    {
        return $query->where('is_anonymous', false);
    }

    /**
     * Accessors
     */
    public function getAuthorNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return $this->anonymous_name ?: 'مجهول';
        }
        
        return $this->user ? $this->user->display_name : 'مستخدم محذوف';
    }

    public function getIsEditableAttribute(): bool
    {
        // Anonymous comments are not editable
        if ($this->is_anonymous) {
            return false;
        }
        
        // Only comment author can edit within 24 hours
        return $this->user_id === auth()->id() && 
               $this->created_at->diffInHours(now()) < 24;
    }

    public function getCanBeDeletedAttribute(): bool
    {
        if (auth()->user()?->hasRole('admin')) {
            return true;
        }
        
        if ($this->is_anonymous) {
            return false;
        }
        
        return $this->user_id === auth()->id();
    }

    /**
     * Check if comment is from same IP (for spam detection)
     */
    public static function countRecentFromIP(string $ip, int $hours = 1): int
    {
        return static::where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHours($hours))
            ->count();
    }

    /**
     * Create anonymous comment
     */
    public static function createAnonymous(array $data): static
    {
        // Allow status to be specified, default to pending
        $status = $data['status'] ?? 'pending';
        
        return static::create([
            'post_id' => $data['post_id'],
            'parent_id' => $data['parent_id'] ?? null,
            'content' => $data['content'],
            'anonymous_name' => $data['anonymous_name'] ?? 'مجهول',
            'is_anonymous' => true,
            'is_active' => true,
            'status' => $status,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'likes_count' => 0,
            'replies_count' => 0,
        ]);
    }
}
