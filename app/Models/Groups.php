<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use MongoDB\Laravel\Eloquent\Model;
//use MongoDB\Laravel\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Groups extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $connection = 'mongodb';
   

   protected $fillable = [
        'name',
        'description',
        'owner_id',
        'member_ids',
        'deleted_at',
    ];

    protected $casts = [
       
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        
        return User::whereIn('_id', $this->member_ids ?? []);
    }

    public function expenses(): HasMany
    {
        // expenses(RelatedModel, foreignKey, localKey)
        return $this->hasMany(Expense::class, 'group_id', '_id');
    }

    public function settlements(): HasMany
    {
        // expenses(RelatedModel, foreignKey, localKey)
        return $this->hasMany(Settlements::class, 'group_id', 'id');
    }

   
}
