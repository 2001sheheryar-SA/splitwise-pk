<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{   
    protected $connection = 'mongodb';
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $collection) {

            $collection->string('name');
            $collection->string('description')->nullable();
           // $collection->index('owner_id');
           //$collection->array('member_ids')->nullable()->index('member_ids'); // Stores array of member IDs
            $collection->timestamps();
            $collection->timestamp('deleted_at')->nullable();
            $collection->index('owner_id');
            $collection->index('member_ids');

        });

    
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
        
    }
};
