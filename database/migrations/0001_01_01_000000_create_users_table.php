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

        Schema::create('sessions', function (Blueprint $collection) {
            $collection->string('id')->primary();
            $collection->foreignId('user_id')->nullable()->index();
            $collection->string('ip_address', 45)->nullable();
            $collection->text('user_agent')->nullable();
            $collection->longText('payload');
            $collection->integer('last_activity')->index();
        });

         


    }

  
        

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        
       
    }
};
