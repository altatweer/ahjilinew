<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    protected $fillable = [
        'user_id',
        'auto_approve_posts',
        'allow_anonymous_messages',
        'email_notifications',
        'push_notifications',
        'notification_types',
        'privacy_level',
        'blocked_users',
    ];

    protected $casts = [
        'auto_approve_posts' => 'boolean',
        'allow_anonymous_messages' => 'boolean',
        'email_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'notification_types' => 'array',
        'blocked_users' => 'array',
    ];

    /**
     * Get the user that owns the settings
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get notification types array
     */
    public function getNotificationTypesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set notification types array
     */
    public function setNotificationTypesAttribute($value)
    {
        $this->attributes['notification_types'] = json_encode($value);
    }

    /**
     * Get blocked users array
     */
    public function getBlockedUsersAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Set blocked users array
     */
    public function setBlockedUsersAttribute($value)
    {
        $this->attributes['blocked_users'] = json_encode($value);
    }
}
