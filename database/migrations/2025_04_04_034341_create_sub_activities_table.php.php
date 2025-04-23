<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sub_activities', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->nullable(); 
            $table->string('successIndicator')->nullable(); 
            $table->string('quality')->nullable(); 
            $table->string('efficiency')->nullable(); 
            $table->string('timeliness')->nullable(); 
            $table->string('remarks')->nullable();
            
            $table->unsignedBigInteger('activity_id')->nullable();
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */ 
    public function down(): void
    {
        Schema::dropIfExists('sub_activities');
    }
};
