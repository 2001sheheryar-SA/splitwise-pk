<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Channel extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

    protected $fillable = [
        'team_id',
        'created_by',
        'name',
        'type',
        'description',
    ];

    
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

     public function members()
    {
        return $this->belongsToMany(User::class,'channel_members');
    }

}
