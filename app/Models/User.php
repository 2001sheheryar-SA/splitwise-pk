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

    /**
     * The company this user belongs to (and may own).
     */
    // public function company(): BelongsTo
    // {
    //     return $this->belongsTo(Company::class);
    // }

    /**
     * The company owned by this user, if any.
     */
    // public function ownedCompany(): HasMany
    // {
    //     return $this->hasMany(Company::class, 'owner_id');
    // }

    /**
     * All authentication tokens issued to this user.
     */
    // public function tokens(): HasMany
    // {
    //     return $this->hasMany(UserToken::class);
    // }

    /**
     * All messages sent by this user.
     */
    // public function messages(): HasMany
    // {
    //     return $this->hasMany(Message::class);
    // }

    // public function isOwnerOf(Company $company): bool
    // {
    //     return $this->id === $company->owner_id;
    // }


//     public function teamMemberships(): HasMany
// {
//     return $this->hasMany(TeamMember::class);
// }

// Teams this user was added to (via pivot)

// public function teams(): BelongsToMany
// {
//     return $this->belongsToMany(Team::class, 'user_id', 'team_id');
// }

// Team members that *this* user has added to teams
// public function addedTeamMembers(): HasMany
// {
//     return $this->hasMany(TeamMember::class, 'added_by');
// }

}
