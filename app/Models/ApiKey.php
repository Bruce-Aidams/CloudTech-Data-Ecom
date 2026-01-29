<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'key',
        'key_preview',
        'last_used_at',
        'expires_at',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected $hidden = [
        'key', // Never expose the hashed key
    ];

    /**
     * Get the user that owns the API key
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the API key is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if the API key is active
     */
    public function isActive(): bool
    {
        return !$this->isExpired();
    }
}
