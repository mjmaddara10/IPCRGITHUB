<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sub_activities', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 255)->nullable(); 
            $table->text('successIndicator')->nullable(); 
            $table->text('quality')->nullable(); 
            $table->text('efficiency')->nullable(); 
            $table->text('timeliness')->nullable(); 
            $table->text('remarks')->nullable();
            
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
