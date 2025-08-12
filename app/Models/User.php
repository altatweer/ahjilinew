<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'display_name',
        'email',
        'phone',
        'password',
        'avatar_url',
        'bio',
        'location',
        'birth_date',
        'account_type',
        'role',
        'is_active',
        'is_private',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'birth_date' => 'date',
            'is_active' => 'boolean',
            'is_private' => 'boolean',
            'last_active_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * العلاقات
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function interactions(): HasMany
    {
        return $this->hasMany(Interaction::class);
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function settings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    /**
     * Accessors for Filament compatibility
     */
    public function getNameAttribute(): string
    {
        return $this->display_name ?? $this->username;
    }

    /**
     * Helper methods
     */
    public function getLoginCredential(): ?string
    {
        return $this->email ?? $this->phone;
    }

    public function isVerified(): bool
    {
        return $this->email_verified_at !== null || $this->phone_verified_at !== null;
    }

    public function isCounselor(): bool
    {
        return $this->account_type === 'counselor';
    }

    /**
     * Accessor for name attribute (Filament compatibility)
     */
    public function getNameAttribute(): string
    {
        return $this->display_name ?? $this->username ?? 'مستخدم';
    }

    /**
     * Get user name (Filament compatibility)
     */
    public function getName(): string
    {
        return $this->display_name ?? $this->username ?? 'مستخدم';
    }
}
