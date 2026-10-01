<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;

use MongoDB\Laravel\Eloquent\Model;


class Groups extends Model
{
    //use HasFactory;
    protected $connection = 'mongodb';
   

   protected $fillable = [
        'name',
        'description',
        'owner_id',
        'member_ids',
    ];

    protected $casts = [
        //'member_ids' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        //return $this->belongsToMany(User::class, null, 'group_ids', 'member_ids');
        return User::whereIn('_id', $this->member_ids ?? []);
    }

    // public function users(): HasMany
    // {
    //     return $this->hasMany(User::class);
    // }

    // public function teams(): HasMany
    // {
    //     return $this->hasMany(Team::class);
    // }
}
