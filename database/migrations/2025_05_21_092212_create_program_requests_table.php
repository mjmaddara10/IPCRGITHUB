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
            $table->unsignedBigInteger('program_id')->nullable();
            $table->unsignedBigInteger('gass_id')->nullable();
            $table->unsignedBigInteger('requestor');
            
            // Data to add
            $table->string('name', 250)->nullable(); 
            $table->text('successIndicator')->nullable(); 
            $table->text('quality')->nullable(); 
            $table->text('efficiency')->nullable(); 
            $table->text('timeliness')->nullable(); 
            $table->text('remarks')->nullable();
            $table->string('budget')->nullable(); 
            
            $table->string('status')->default('pending');
            $table->string('action')->nullable(); 
            $table->timestamps();

            $table->foreign('gass_id')->references('id')->on('gass')->onDelete('no action');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('requestor')->references('id')->on('tbl_employee')->onDelete('no action');
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
