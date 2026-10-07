<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\BelongsToManyRelationship;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Auth\User as Authenticatable;
class User extends Authenticatable
{

    protected $connection = 'mongodb';
  
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    //const UPDATED_AT = null;

    protected $fillable = [
        'username',
        'email',
       // 'role',
        'password',
        'email_verified_at',
       
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            
        ];
    }

    public function groups(): HasMany
    {
        // Parameter 1: Related Model
        // Parameter 2: Foreign key field stored in the Group collection ('member_ids')
        // Parameter 3: Local key in User model ('_id' or 'id')
        return $this->hasMany(Groups::class, 'member_ids', '_id');
    }

    


}
