<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';

     protected $collection = 'attachments';

    protected $fillable = ['settlement_id', 'file_id', 'filename', 'mime_type', 'size','deleted_at'];
    protected $casts = [
      
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


      public function settlements(): BelongsTo
    {
        return $this->belongsTo(Settlements::class, 'settlement_id', '_id');
    }

    
}
