<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use DateTimeInterface;
use Carbon\Carbon;

class Settlements extends Model
{
    use HasFactory; use SoftDeletes;
    protected $connection = 'mongodb';

    protected $fillable = [
        'paid_by',
        'group_id',
        'paid_to',
        'amount',
        'note',
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
}
