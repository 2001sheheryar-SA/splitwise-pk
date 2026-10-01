<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    protected $connection = 'mongodb';
    public function up(): void
    {
        Schema::create('user_tokens', function (Blueprint $collection) {
    
            $collection->string('user_id')->index();
            $collection->string('token',100)->unique();
            $collection->timestamps();
            $collection->timestamp('expires_at')->nullable();
           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_tokens');
    }
};
