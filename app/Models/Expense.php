<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
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

    public function scopeFilter(Builder $query, array $filters): Builder
{
    return $query
        ->when($filters['payer'] ?? null,
            fn ($q, $payer) => $q->where('paid_by', $payer))
        ->when($filters['split_type'] ?? null,
            fn ($q, $type) => $q->where('split_type', $type))
        ->when($filters['date_from'] ?? null,
            fn ($q, $date) => $q->where('created_at', '>=', Carbon::parse($date)->startOfDay()))
        ->when($filters['date_to'] ?? null,
            fn ($q, $date) => $q->where('created_at', '<=', Carbon::parse($date)->endOfDay()));
}
    
}
