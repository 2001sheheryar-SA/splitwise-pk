<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserToken extends Model
{
    use HasFactory;
    //const UPDATED_AT = null;
    protected $connection = 'mongodb';

    protected $fillable = [
        'user_id',
        'token',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            // 'last_used_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a new, cryptographically random plain-text token.
     */
    public static function generatePlainTextToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
        // return $this->expires_at !== null 
        // && $this->created_at !== null 
        // && $this->expires_at->gt($this->created_at);
    }
}
