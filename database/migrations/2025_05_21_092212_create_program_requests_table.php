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
        Schema::create('program_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('requested_by');
            
            // Data to add
            $table->string('name');
            $table->string('successIndicator')->nullable(); 
            $table->string('quality')->nullable(); 
            $table->string('efficiency')->nullable(); 
            $table->string('timeliness')->nullable(); 
            $table->string('remarks')->nullable();
            $table->string('budget')->nullable(); 
            
            $table->string('status')->default('pending');
            $table->string('action')->nullable(); 
            $table->timestamps();

            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade')->nullable();
            $table->foreign('requested_by')->references('id')->on('tbl_employee')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_add_requests');
    }
};
