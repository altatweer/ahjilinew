<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'type',
        'status',
        'admin_reply',
        'replied_at',
        'ip_address',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Scopes
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Accessors
     */
    public function getIsRepliedAttribute(): bool
    {
        return !empty($this->admin_reply);
    }

    public function getTypeNameAttribute(): string
    {
        return match($this->type) {
            'complaint' => 'شكوى',
            'suggestion' => 'اقتراح',
            'support' => 'دعم تقني',
            'other' => 'أخرى',
            default => $this->type,
        };
    }

    public function getStatusNameAttribute(): string
    {
        return match($this->status) {
            'unread' => 'غير مقروءة',
            'read' => 'مقروءة',
            'replied' => 'تم الرد',
            'archived' => 'مؤرشفة',
            default => $this->status,
        };
    }
}
