<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use MongoDB\Laravel\Eloquent\Model;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\SoftDeletes;

//use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;
   protected $collection = 'expenses';
   //protected $dates = ['deleted_at'];

    protected $fillable = [
        'group_id',
        'description',
        'amount',
        'paid_by',
        'split_type',
        'participants',
        'deleted_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function group(): BelongsTo
    {
        return $this->belongsTo(Groups::class, 'group_id', '_id');
    }

    // public function company(): BelongsTo
    // {
    //     return $this->belongsTo(Company::class);
    // }

    // public function channels(): HasMany
    // {
    //     return $this->hasMany(Channel::class);
    // }

    // public function members()
    // {
    //     return $this->belongsToMany(User::class,'team_members');
    // }

    
}
