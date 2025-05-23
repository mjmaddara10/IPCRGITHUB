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
            $table->foreign('user_id')->references('id')->on('tbl_employee')->onDelete('cascade');

            $table->string('full_name', 255);
            $table->string('role', 30);
            $table->string('action', 250);
            $table->string('action_from', 500)->nullable();
            $table->string('action_to', 500)->nullable();
            $table->string('program_name', 50)->nullable();
            $table->unsignedBigInteger('record_id');
            $table->timestamps();
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
