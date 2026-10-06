<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $collection) {
            $collection->timestamps();
            $collection->timestamp('deleted_at')->nullable();
            $collection->index('group_id');
            $collection->index('paid_by');
        });

       
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        
    }
};
