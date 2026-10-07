<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    protected $connection = 'mongodb';
    public function up(): void
    {
        Schema::create('users', function (Blueprint $collection) {
           
        
            $collection->string('email')->unique();
            $collection->timestamp('email_verified_at')->nullable();
            $collection->timestamps();
        });

        Schema::create('attachments', function (Blueprint $collection) {
            $collection->index('settlement_id');
            $collection->timestamps();
            $collection->timestamp('deleted_at')->nullable();
           
        });

         


    }

  
        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('attachments');
        
       
    }
};
