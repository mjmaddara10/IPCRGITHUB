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
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('full_name');
            $table->string('role');
            $table->string('action');  // For storing the type of action (ADDED, UPDATED, DELETED)
            $table->text('action_from')->nullable();  // For storing the original values
            $table->text('action_to')->nullable();    // For storing the new values
            $table->string('program_name');
            $table->unsignedBigInteger('record_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('tbl_employee')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trails');
    }
};
