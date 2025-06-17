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
        Schema::create('sub_activity_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_activity_id')->nullable(); //For editing purposes (reference)
            $table->unsignedBigInteger('activity_id')->nullable(); //Parent table reference
            $table->unsignedBigInteger('requestor');
            
            // Data to add
            $table->string('name', 255)->nullable(); 
            $table->text('successIndicator')->nullable(); 
            $table->text('quality')->nullable(); 
            $table->text('efficiency')->nullable(); 
            $table->text('timeliness')->nullable(); 
            $table->text('remarks')->nullable();
            
            $table->string('status')->default('pending');
            $table->string('action')->nullable(); 
            $table->timestamps();

            $table->foreign('sub_activity_id')->references('id')->on('sub_activities')->onDelete('cascade'); //For editing purposes (reference)
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('no action'); //Parent table reference
            $table->foreign('requestor')->references('id')->on('tbl_employee')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_activity_requests');
    }
};
