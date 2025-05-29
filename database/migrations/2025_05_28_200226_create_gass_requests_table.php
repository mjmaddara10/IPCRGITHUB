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
        Schema::create('gass_requests', function (Blueprint $table) {
            $table->id();
            $table->string('budget', 50)->nullable();
            $table->string('status')->default('pending');
            $table->string('action')->nullable();

            $table->unsignedBigInteger('gass_id')->nullable(); //For editing purposes (reference)
            $table->foreign('gass_id')->references('id')->on('gass')->onDelete('cascade'); //For editing purposes (reference)
            $table->unsignedBigInteger('requestor')->nullable(); 
            $table->foreign('requestor')->references('id')->on('tbl_employee')->onDelete('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gass_requests');
    }
};
