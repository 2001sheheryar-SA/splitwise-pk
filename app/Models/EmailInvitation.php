<?php
namespace App\Models;


use MongoDB\Laravel\Eloquent\Model;


class EmailInvitation extends Model
{
    protected $table = 'email_verify_tokens';

    protected $fillable = [
        'company_id',
        'token',
        'invite',
        'user_id',
        'expires_at'
    ];


    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }


    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
      
    }

  
   
}