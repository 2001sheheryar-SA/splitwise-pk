<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Team extends Model
{
    use HasFactory;
   protected $connection = 'mongodb';

    protected $fillable = [
        'company_id',
        'created_by',
        'name',
        'description',
    ];

    protected static function booted(): void
    {
        // static::creating(function (Team $team) {
        //     if (empty($team->slug)) {
        //         $team->slug = Str::slug($team->name).'-'.Str::random(6);
        //     }
        // });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function channels(): HasMany
    {
        return $this->hasMany(Channel::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class,'team_members');
    }

    
}
